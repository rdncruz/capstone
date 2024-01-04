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
    <title>Product</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Override Bootstrap's container padding -->
    <style>
        #sidebar .sidebar-menu {
            margin-top: 1;
            padding: 0;
        }
        .action-column {
        width: 15%;    
        }
    </style>

    <!-- Include the Bootstrap stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</header>
<body>
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-store'></i>
            <span class="text"><?php echo $row['shop_name']; ?></span>
        </a>
        <ul class="sidebar-menu">
        <li>
                <a href="seller_dashboard.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="seller_newsfeed.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Newsfeed</span>
                </a>
            </li>
            <li class="active">
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
        <nav class="custom-nav">
			<i class='bx bx-menu' ></i>
			<form action="#">
				<div class="form-input">
					<!---->
				</div>
			</form>
			<a href="seller_profile.php" style="font-size: 30px;">
				<i class='bx bxs-cog' ></i>
			</a>
			<a href="#" class="profile">
                <img src="./image/<?php echo $row['img']; ?>" alt="">
			</a>
		</nav>
        <main>
            <!-- Add Student -->
<div class="modal fade" id="studentAddModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Add Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="saveStudent">
        
            <div class="modal-body">

                <div id="errorMessage" class="alert alert-warning d-none"></div>
                <input type="hidden" id="unique_id" name="unique_id" value="<?php echo isset($_SESSION['unique_id']) ? $_SESSION['unique_id'] : ''; ?>">
                <div class="mb-3">
                    <label for="category">Category</label>
                        <select name="category" class="form-control">
                        <option value="Fishing Equipment">Fishing Equipment</option>
                        <option value="Boat Engine">Boat Engine</option>
                        <option value="Equipment">Equipment</option>
                    </select>
                </div>
                <div class="mb-3">
                    <label for="">Name</label>
                    <input type="text" name="name" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Small_Description</label>
                    <input type="text" name="small_description" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">image</label>
                    <input type="file" name="image" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Price</label>
                    <input type="text" name="price" class="form-control" />
                </div>

                <div class="mb-3">
                    <label for="">quantity</label>
                    <input type="text" name="quantity" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="status">Category</label>
                    <select name="status" class="form-control">
                        <option value="In Stock">In Stock</option>
                        <option value="Out of Stock">Out of Stock</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save Product</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- Edit Student Modal -->
<div class="modal fade" id="studentEditModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Edit Product</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
        <form id="updateStudent">
            <div class="modal-body">

                <div id="errorMessageUpdate" class="alert alert-warning d-none"></div>

                <input type="hidden" name="student_id" id="student_id" >

                <div class="mb-3">
                    <label for="">Category</label>
                    <input type="text" name="category" id="category" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Name</label>
                    <input type="text" name="name" id="name" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Small_description</label>
                    <input type="text" name="small_description" id="small_description" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Price</label>
                    <input type="text" name="price" id="price" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">Quantity</label>
                    <input type="text" name="quantity" id="quantity" class="form-control" />
                </div>
                <div class="mb-3">
                    <label for="">status</label>
                    <input type="text" name="status" id="status" class="form-control" />
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Update Product</button>
            </div>
        </form>
        </div>
    </div>
</div>

<!-- View Student Modal -->
<div class="modal fade" id="studentViewModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">View Student</h5>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
        </div>
            <div class="modal-body">

                <div class="mb-3">
                    <label for="">Category</label>
                    <p id="view_category" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">Name</label>
                    <p id="view_name" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">Small_description</label>
                    <p id="view_small_description" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">Price</label>
                    <p id="view_price" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">Quantity</label>
                    <p id="view_quantity" class="form-control"></p>
                </div>
                <div class="mb-3">
                    <label for="">status</label>
                    <p id="view_status" class="form-control"></p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<div class="container mt-4">
    <div class="rows">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h4>List of your own Products
                        <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#studentAddModal">
                            Add Product
                        </button>
                    </h4>
                </div>
                <div class="card-body">
                    <div class="s table-responsive"> <!-- Make the table responsive -->
                        <table id="myTable" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>Category</th>
                                    <th>Name</th>
                                    <th>Small Description</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Status</th>
                                    <th class="action-column">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                require './php/config.php';
                                $query = "SELECT * FROM products where unique_id = {$_SESSION['unique_id']}";
                                $query_run = mysqli_query($conn, $query);

                                if(mysqli_num_rows($query_run) > 0)
                                {
                                    foreach($query_run as $student)
                                    {
                                        ?>
                                        <tr>
                                            <td><?= $student['category'] ?></td>
                                            <td><?= $student['name'] ?></td>
                                            <td><?= $student['small_description'] ?></td>
                                            <td><?= $student['price'] ?></td>
                                            <td><?= $student['quantity'] ?></td>
                                            <td><?= $student['status'] ?></td>
                                            <td>
                                                <button type="button" value="<?=$student['id'];?>" class="viewStudentBtn btn btn-info btn-sm">View</button>
                                                <button type="button" value="<?=$student['id'];?>" class="editStudentBtn btn btn-success btn-sm">Edit</button>
                                                <button type="button" value="<?=$student['id'];?>" class="deleteStudentBtn btn btn-danger btn-sm">Delete</button>
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
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="//cdn.jsdelivr.net/npm/alertifyjs@1.13.1/build/alertify.min.js"></script>


    <script src="javascript/product.js">
        

    </script>

        </main>
    </section>
	<script src="javascript/design.js"></script>
</body>
</html>