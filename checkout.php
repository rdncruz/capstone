<?php
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");
session_start();
include_once "php/config.php";

if (!isset($_SESSION['unique_id'])) {
    header("location: index.php");
}

$unique_id = $_SESSION['unique_id'];

$sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");

if (mysqli_num_rows($sql) > 0) {
    $row = mysqli_fetch_assoc($sql);

    if ($row) {
        $_SESSION['verification_status'] = $row['verification_status'];

        if ($row['role'] === 'user') {
            if ($row['verification_status'] != 'Verified') {
                header("Location: verify.php");
            }
        } else {
            // Redirect to login.php if the user is not a seller
            header("Location: index.php");
        }
    }
}

$sql1 = mysqli_query($conn, "SELECT * FROM cart WHERE unique_id = '{$unique_id}'");
if (mysqli_num_rows($sql) > 0) {
    $product = mysqli_fetch_assoc($sql);
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
    <title>Store</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    
    <link rel="stylesheet" href="css/shopping.css">
    
</head>
<body>
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-store'></i>
            <span class="text"></span>
        </a>
        <ul class="sidebar-menu">
            <li>
                <a href="home.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Home</span>
                </a>
            </li>
            <li>
                <a href="userfeed.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Newsfeed</span>
                </a>
            </li>
            <li>
                <a href="dashboard.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="inbox.php">
                    <i class='bx bx-conversation'></i>
                    <span class="text">Inbox</span>
                </a>
            </li>
            <li class="active">
                <a href="store.php">
                    <i class='bx bxl-shopify'></i>
                    <span class="text">Store</span>
                </a>
            </li>
            <li>
                <a href="location.php">
                    <i class='bx bx-map' ></i>
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
                    <span class="text">Logout</span></a>
                </a>
            </li>
        </ul>
    </section>

    <section id="container">
        <nav>
			<i class='bx bx-menu' ></i>
		
			<form action="#">
				<div class="form-input">
					<!---->
				</div>
			</form>
		
			<a href="cart.php" class="btn px-0 ml-3">
                <i class="fas fa-shopping-cart shopping-cart-icon"></i>
                <?php
              
                
                $select_rows = mysqli_query($conn, "SELECT * FROM `cart` where unique_id = '$unique_id'") or die('query failed');
                $count = mysqli_num_rows($select_rows);

                echo "<span class=\"badge text-secondary border border-secondary rounded-circle\" style=\"padding-bottom: 2px;\">$count</span>";
                ?>
            </a>

			<a href="#" class="profile">
				<img src="./image/<?php echo $row['img']; ?>" alt="">
			</a>
		</nav>
                  
        <main>
            <div class="container-fluid">
                <div class="row px-xl-5">
                    <div class="col-lg-8">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
                        <div class="bg-light p-30 mb-5">
                            <div class="row">
                                <div class="col-md-6 form-group">
                                    <label>First Name</label>
                                    <label class="form-control"> <?php echo $row['fname'];?> </label>
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Last Name</label>
                                    <label class="form-control"> <?php echo $row['lname'];?> </label> 
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>E-mail</label>
                                    <label class="form-control"> <?php echo $row['email'];?> </label> 
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Mobile No</label>
                                    <input class="form-control" type="text" placeholder="+69-00-0000-0000">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>Address Line</label>
                                    <input class="form-control" type="text" placeholder="123 Street">
                                </div>
                                <div class="col-md-6 form-group">
                                    <label>City</label>
                                    <label class="form-control"> <?php echo $row['address'];?> </label> 
                                </div>
                                <div class="col-md-12">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="shipto">
                                        <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">View Your Location</label>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="collapse mb-5" id="shipping-address">
                            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Google Map</span></h5>
                            <div class="bg-light p-30">
                                <div class="row">
                                    
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $sql1 = mysqli_query($conn, "SELECT cart.*, products.name, products.price FROM `cart` INNER JOIN `products` ON cart.product_id = products.product_id WHERE cart.unique_id = '{$unique_id}'");

                    if (mysqli_num_rows($sql1) > 0) {
                        // Display the Order Total section
                        ?>
                        <div class="col-lg-4">
                            <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                            <div class="bg-light p-30 mb-5">
                                <div class="border-bottom">
                                    <h6 class="mb-3">Products</h6>
                                    <?php
                                    $subtotal = 0;

                                    while ($fetch_cart = mysqli_fetch_assoc($sql1)) {
                                        $quantity = $fetch_cart['quantity'];
                                        $product_price = $fetch_cart['price'];
                                        $product_total = $quantity * $product_price;
                                        $subtotal += $product_total;
                                        ?>
                                        <div class="d-flex justify-content-between">
                                            <p><?php echo $fetch_cart['name']; ?></p>
                                            <p>₱<?php echo $product_total; ?></p>
                                        </div>
                                        <?php
                                    }

                                    // Display the Subtotal, Shipping, and Total for the Order Total section
                                    ?>
                                </div>
                                <div class="border-bottom pt-3 pb-2">
                                    <div class="d-flex justify-content-between mb-3">
                                        <h6>Subtotal</h6>
                                        <h6>₱<?php echo $subtotal; ?></h6>
                                    </div>
                                    <div class="d-flex justify-content-between">
                                        <h6 class="font-weight-medium">Shipping</h6>
                                        <h6 class="font-weight-medium">₱50</h6>
                                    </div>
                                </div>
                                <div class="pt-2">
                                    <div class="d-flex justify-content-between mt-2">
                                        <h5>Total</h5>
                                        <h5>₱<?php echo $subtotal + 50; ?></h5>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-5">
                                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                                <div class="bg-light p-30">
                                    <button class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
                                </div>
                            </div>
                        </div>
                    <?php
                    }
                    ?>



                </div>
            </div>
        </main>
    </section>
    <script src="javascript/design.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

</body>
</html>
                    



