<?php 
    header("Cache-Control: no-cache, no-store, must-revalidate");
    header("Pragma: no-cache");
    header("Expires: 0");
    session_start();
    include_once "php/config.php";
    if(!isset($_SESSION['unique_id'])) {
        header("location: index.php");
    }
    $unique_id = $_SESSION['unique_id'];
    $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        if($row) {
            $_SESSION['verification_status'] = $row ['verification_status'];
            if ($row['role'] === 'admin') {
                if($row['verification_status'] != 'Verified') {
                    header("Location: verify.php");
                }
            } 
            else {
                // Redirect to login.php if the user is not a seller
                header("Location: index.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Admin Portal</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <!-- Override Bootstrap's container padding -->
    <style>
       
        #sidebar .sidebar-menu {
            margin-top: 1;
            padding: 0;
        }
    </style>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-store'></i>
            <span class="text"><?php echo $row['username']; ?></span>
        </a>
        <ul class="sidebar-menu">
            <li class="active">
                <a href="admin_portal.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Home</span>
                </a>
            </li>
            <li>
                <a href="admin_location.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Location</span>
                </a>
            </li>
            <li>
                <a href="admin_register.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Settings</span>
                </a>
            </li>
			<li>
                <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>"> 
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Logout</span></a>
                </a>
            </li>
        </ul>
    </section>
    <section id="container">
        <nav class="custom-nav">
			<i class='bx bx-menu' ></i>
			<form action="#">
				<div class="form-input">
					<!---->
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
			</a>
			<a href="#" class="profile">
                
			</a>
		</nav>
        <main>
          
            <!-- Modal -->
            <!-- Modal -->
            <div id="imageModal" class="modal" role="dialog" aria-hidden="true">
                <div class="modal-dialog modal-lg" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <img id="sellerImage" src="" alt="Seller Image" class="img-fluid zoom-image" style="max-height: 800px;">
                        </div>
                    </div>
                </div>
            </div>

            <div class="container mt-4">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h4>List of the Registered Seller</h4>
                            </div>
                            <div class="card-body">
                                <table id="myTable" class="table table-bordered table-striped">
                                    <thead>
                                        <tr>
                                            <th>User Id</th>
                                            <th>Shop Name</th>
                                            <th>Full Name</th>
                                            <th>City</th>
                                            <th>Verify Status</th>
                                            <th>image</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                            require './php/config.php';
                                            $query = "SELECT * FROM users WHERE role = 'seller'" ;
                                            $query_run = mysqli_query($conn, $query);
                                            if(mysqli_num_rows($query_run) > 0) {
                                                foreach($query_run as $seller)  {
                                        ?>
                                        <tr>
                                            <td><?= $seller['unique_id'] ?></td>
                                            <td><?= $seller['shop_name'] ?></td>
                                            <td><?= $seller['fname'] ?> <?= $seller['lname'] ?></td>
                                            
                                            <td><?= $seller['address'] ?></td>
                                            <td><?= $seller['verification_status'] ?></td>
                                            <td class="image-cell">
                                            <?php
                                                if (!empty($seller['reg_img'])) {
                                                    $imagePath = './image/' . $seller['reg_img'];
                                                    echo '<img src="' . $imagePath . '" alt="Seller Image" class="img-fluid clickable-image" data-bs-toggle="modal" data-bs-target="#imageModal" data-image="' . $imagePath . '"style="max-width: 50px; max-height: auto;">';
                                                } else {
                                                    echo 'No Image';
                                                }
                                            ?>
                                            </td>
                                            <td>
                                                <button type="button" value="<?=$seller['unique_id'];?>" class="editStudentBtn btn btn-success btn-sm">Send OTP</button>
                                                <button type="button" value="<?=$seller['unique_id'];?>" class="deleteStudentBtn btn btn-danger btn-sm">Reject</button>
                                            </td>
                                        </tr>
                                        <?php
                                            }
                                        }
                                        ?>   
                                    </tbody>
                                </table>    
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </main>
    </section>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/medium-zoom@1.0.6/dist/medium-zoom.min.js"></script>

<script src="javascript/admin.js"></script>
<script src="javascript/design.js"></script>
<script>
    $(document).ready(function() {
        // Attach a click event handler to the button
        $(".viewStudentBts").click(function() {
            // Get the unique ID from the button's value attribute
            var uniqueId = $(this).val();

            // Send an AJAX request to fetch the image
            $.ajax({
                url: 'php/get_image.php', // PHP script to fetch the image
                type: 'POST',
                data: { unique_id: uniqueId },
                success: function(response) {
                    // Display the image in a modal or a separate HTML element
                    $("#imageContainer").html('<img src="data:image/jpeg;base64,' + response + '" alt="Image">');
                    // You can use a Bootstrap modal or another method to display the image.
                },
                error: function() {
                    alert('Failed to fetch the image.');
                }
            });
        });
    });
</script>
<script>
    $(document).ready(function() {
        // Attach a click event handler to the clickable images
        $(".clickable-image").click(function() {
            // Get the image source from the data attribute
            var imagePath = $(this).data("image");

            // Set the image source in the modal
            $("#sellerImage").attr("src", imagePath);

            // Show the native dialog
            var dialog = document.getElementById('imageModal');
            dialog.showModal();

            // Initialize Medium Zoom on the modal image
            
        });

        // Close the native dialog when clicking outside the image
        $('#imageModal').on('click', function (event) {
            var dialog = document.getElementById('imageModal');
            if (event.target === dialog) {
                dialog.close();
            }
        });
    });
</script>


</body>
</html>