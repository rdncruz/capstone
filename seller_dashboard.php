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
            if ($row['role'] === 'seller') {
                if($row['verification_status'] != 'Verified') {
                    header("Location: verify.php");
                }
            } 
            else {
                // Redirect to login.php if the user is not a seller
                header("Location: seller_login.php");
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
    <title>Newsfeed</title>
    
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>

   
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    <style>
        #map {
            height: 400px;
            margin-left: 20px;
            margin-right: 20px;
            margin-bottom: 20px;

        }
    </style>
</head>
<body>
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-store'></i>
            <span class="text"><?php echo $row['shop_name']; ?></span>

        </a>
        <ul class="sidebar-menu">
            <li class="active">
                <a href="seller_dashboard.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li >
                <a href="seller_newsfeed.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Newsfeed</span>
                </a>
            </li>
            <li>
                <a href="product.php">
                    <i class='bx bx-cart-add' ></i>
                    <span class="text">Product</span>
                </a>
            </li>
            <li>
                <a href="seller_inbox.php">
                    <i class='bx bx-conversation'></i>
                    <span class="text">Inbox</span>
                </a>
            </li>
            <li>
                <a href="seller_location.php">
                    <i class='bx bx-conversation'></i>
                    <span class="text">Location</span>
                </a>
            </li>
            <li> 
              <?php 
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
                if(mysqli_num_rows($sql) > 0){
                  $row = mysqli_fetch_assoc($sql);
                }
              ?>
                <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>"> 
                    <i class='bx bx-log-out' ></i>
                    <span class="text">Logout</span>
                </a>
            </li>
        </ul>
    </section>

    <section id="container">
        <nav>
			<i class='bx bx-menu' ></i>
			
			<form action="#">
				<!---->
			</form>
			
			<a href="seller_profile.php" style="font-size: 30px;">
				<i class='bx bxs-cog' ></i>
			</a>
			<a href="#" class="profile">
				<img src="./image/<?php echo $row['img']; ?>" alt="">
			</a>
		</nav>
        <main>
            

            <ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
                    <?php 
                        $total_order_query = mysqli_query($conn, "SELECT COUNT(*) AS total_rows FROM `checkout` WHERE unique_id = '{$_SESSION['unique_id']}'");
                        $total_order_result = mysqli_fetch_assoc($total_order_query);
                        $total_order = $total_order_result['total_rows'];
                    ?>
                    <h3><?php echo $total_order ?></h3>
                    <h4>Total Order</h4>

					</span>
				</li>
	
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
                        <?php 
                            $total_order_querys = mysqli_query($conn, "SELECT COUNT(*) AS total_rows FROM `checkout` WHERE unique_id = '{$_SESSION['unique_id']}' AND status = 'Completed'");
                            $total_order_results = mysqli_fetch_assoc($total_order_querys); // Fix: Change $total_order_result to $total_order_results
                            $complete_order = $total_order_results['total_rows'];
                        ?>
                        <h3><?php echo $complete_order ?></h3>
						<h4>Completed Order</h4>
					</span>
				</li>
			</ul>
            <div class="table-data">
                <div class="order">
                    <div class="head">
                        <h3>List of your Orders</h3>
                        <i class='bx bx-filter' ></i>
                    </div>
                    <table>
                        <thead>
                            <tr>
                                <th>Reference ID</th>
                                <th>Full Name</th>
                                <th>Username</th>
                                <th>Email</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
                                <th>Order Date</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            require './php/config.php';

                            $query = "SELECT c.*, p.name AS product_name, u.fname, u.lname, u.username, u.email, u.unique_id AS user_unique_id
                                        FROM checkout c
                                        INNER JOIN products p ON c.product_id = p.product_id
                                        INNER JOIN users u ON c.unique_id = u.unique_id
                                        WHERE p.unique_id = '$unique_id'
                                        ORDER BY c.id DESC";

                            $query_run = mysqli_query($conn, $query);

                            if (mysqli_num_rows($query_run) > 0) {
                                // Create the initMap function only once
                                ?>
                                <script>
                                    var map;
                                    var markers = [];

                                    function initMap(latitude, longitude) {
                                        map = new google.maps.Map(document.getElementById('map'), {
                                            center: { lat: latitude, lng: longitude },
                                            zoom: 17.0
                                        });

                                        // Add a custom icon for the user's location marker
                                        var userMarker = new google.maps.Marker({
                                            position: { lat: latitude, lng: longitude },
                                            map: map,
                                            title: 'User Location',
                                            icon: {
                                                url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
                                            }
                                        });
                                    }
                                </script>
                                <?php

                                foreach ($query_run as $order) {
                                    $checkout_id = $order['checkout_id'];
                                    $sql_order_user = mysqli_query($conn, "SELECT unique_id FROM checkout WHERE checkout_id = '{$checkout_id}'");

                                    if (mysqli_num_rows($sql_order_user) > 0) {
                                        $order_user_data = mysqli_fetch_assoc($sql_order_user);
                                        $order_user_unique_id = $order_user_data['unique_id'];

                                        $sql_location = mysqli_query($conn, "SELECT lat, lng FROM location WHERE unique_id = '{$order_user_unique_id}'");

                                        if (mysqli_num_rows($sql_location) > 0) {
                                            $location_data = mysqli_fetch_assoc($sql_location);
                                            $latitude = $location_data['lat'];
                                            $longitude = $location_data['lng'];
                                        } else {
                                            $latitude = 37.7749;
                                            $longitude = -122.4194;
                                        }
                                    } else {
                                        $order_user_unique_id = null;
                                        $latitude = 37.7749;
                                        $longitude = -122.4194;
                                    }
                                    ?>
                                    <tr>
                                        <td><?= $order['checkout_id'] ?></td>
                                        <td><?= $order['fname'] ?> <?= $order['lname'] ?></td>
                                        <td><?= $order['username'] ?></td>
                                        <td><?= $order['email'] ?></td>
                                        <td><?= $order['product_name'] ?></td>
                                        <td><?= $order['quantity'] ?></td>
                                        <td><?= $order['price'] ?></td>
                                        <td><?= $order['order_date'] ?></td>
                                        <td><?= $order['status'] ?></td>
                                        <td>
                                            <!-- Modify the button in the newsfeed section -->
                                            <button class="placeOrderBtn btn btn-info btn-sm" onclick="initMap(<?php echo $latitude; ?>, <?php echo $longitude; ?>)">Show Map</button>

                                            <button class="editStudentBtn btn btn-success btn-sm">In Transit</button>
                                            <button class="deleteStudentBtn btn btn-danger btn-sm">Delivered</button>
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
            <div class="modal fade" id="orderConfirmationModal" tabindex="-1" role="dialog" aria-labelledby="orderConfirmationModalLabel" aria-hidden="true">
                <div class="modal-dialog modal-dialog-centered" role="document">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="orderConfirmationModalLabel">User Location</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        
                        <div class="modal-body">
                            
                        </div>
                        <div id="map"></div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal" onclick="redirectToStore()">Close</button>

                        </div>
                    </div>
                </div>
            </div>
        </main>
        
    </section>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBT7g_YV4I7cksILtC4ed1TfN7JIpJ8I3Q&callback=initMap" async defer></script>
	<script src="https://code.jquery.com/jquery-3.6.4.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
<script src="javascript/design.js"></script>




<!-- ... your existing HTML code ... -->

<script>
    $(document).ready(function () {
        $('.placeOrderBtn').on('click', function () {
            $('#orderConfirmationModal').modal('show');
        });

        // Check status on page load and disable 'In Transit' button if status is 'Delivered'
        checkStatusAndDisableButtons();

        $('.editStudentBtn').on('click', function () {
            var checkoutId = $(this).closest('tr').find('td:first').text(); // Assuming the first column contains checkout_id
            var clickedButton = $(this); // Store a reference to the clicked button
            updateOrderStatus(checkoutId, 'In Transit', clickedButton);
        });

        $('.deleteStudentBtn').on('click', function () {
        var checkoutId = $(this).closest('tr').find('td:first').text(); // Assuming the first column contains checkout_id
        var inTransitButton = $(this).closest('tr').find('.editStudentBtn'); // Find the corresponding 'In Transit' button
        updateOrderStatus(checkoutId, 'Delivered', inTransitButton, $(this).closest('tr'));
    });

    function updateOrderStatus(checkoutId, status, relatedButton, rowElement) {
        $.ajax({
            url: 'php/update_order_status.php', // Replace with the actual PHP file to handle the update
            method: 'POST',
            data: {
                checkout_id: checkoutId,
                status: status
            },
            success: function (response) {
                // Handle the success response
                try {
                    var result = JSON.parse(response);
                    if (result.success) {
                        // Update the status in the UI
                        var statusCell = $('td:contains(' + checkoutId + ')').siblings('td:eq(7)'); // Assuming the eighth column contains the status
                        statusCell.text(status);

                        // Disable the related button if the status is 'Delivered'
                        if (status === 'Delivered') {
                            relatedButton.prop('disabled', true);
                            // Remove the row from the table
                            
                        }

                        // You can perform other actions or UI updates here
                    } else {
                        // Handle the case where the update was not successful
                        console.error(result.message);
                    }
                } catch (error) {
                    // Handle JSON parsing error
                    console.error('Error parsing JSON: ' + error);
                }
            },
            error: function (xhr, status, error) {
                // Handle the error, if needed
                console.error(error);
            }
        });
    }

        function checkStatusAndDisableButtons() {
            // Iterate through each row and disable 'In Transit' button if status is 'Delivered'
            $('tbody tr').each(function () {
                var statusText = $(this).find('td:eq(8)').text();
                if (statusText.trim() === 'Delivered') {
                    $(this).find('.editStudentBtn').prop('disabled', true);
                }
            });
        }
    });
</script>

<!-- ... your existing HTML code ... -->


    <script>
        const pElements = document.querySelectorAll('p');
        let currentIndex = 0;

        function displayNextP() {
            pElements.forEach((p, index) => {
                p.style.display = index === currentIndex ? 'block' : 'none';
                p.classList.remove('fade');
            });

            currentIndex = (currentIndex + 1) % pElements.length;

            pElements[currentIndex].classList.add('fade');
        }

        displayNextP();
        setInterval(displayNextP, 5000); // Change the time interval (in milliseconds) as needed
    </script>
</body>
</html>