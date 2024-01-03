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
function getRatingInfo($conn, $product_id) {
    $query = "SELECT AVG(rating) as avg_rating, COUNT(*) as review_count FROM review WHERE product_id = '$product_id'";
    $result = mysqli_query($conn, $query);
    $row = mysqli_fetch_assoc($result);

    return $row;
}
// Check if 'product_id' is set in the URL
if(isset($_GET['product_id'])) {
    $product_id = mysqli_real_escape_string($conn, $_GET['product_id']);

    // Retrieve product details from the database
    $select_product = mysqli_query($conn, "SELECT * FROM products WHERE product_id = '$product_id'");

    if(mysqli_num_rows($select_product) > 0) {
        $fetch_product = mysqli_fetch_assoc($select_product);

        // Your existing product details display code goes here...

        // Add to Cart functionality

        if(isset($_POST['add_to_cart'])){

            $product_name = $_POST['product_name'];
            $product_price = $_POST['product_price'];
            $product_id = $_POST['product_id'];
            $product_image = $_POST['product_image'];
         
            $product_quantity = 1;
         
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE unique_id = '{$_SESSION['unique_id']}' AND product_id = '$product_id'");
         
            if(mysqli_num_rows($select_cart) > 0){
               $message[] = 'product already added to cart';
            }else{
               $insert_product = mysqli_query($conn, "INSERT INTO `cart`(product_id, unique_id, quantity) VALUES('$product_id', '$unique_id', '$product_quantity')");
               $message[] = 'product added to cart succesfully';
            }
         
         }
    }
} else {
    echo "Product ID is not set in the URL.";
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
        
            <?php
                // Check if $fetch_product is set before displaying details
                if (isset($fetch_product)) {
                    $rating_info = getRatingInfo($conn, $product_id);
            ?>
            <form action="" method="post">  
            <div class="container-fluid pb-5">
                <div class="row px-xl-5">
                    <div class="col-lg-5 mb-30">
                        <img class="w-100 h-100" src="Image/<?php echo $fetch_product['image']; ?>" alt="Image">
                    </div>
                    <input type="hidden" name="product_id" value="<?php echo $fetch_product['product_id']; ?>">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                    <div class="col-lg-7 h-auto mb-30">
                        <div class="h-100 bg-light p-30">
                            <h3><?php echo $fetch_product['name']; ?></h3>
                            <div class="d-flex mb-3">
                                <div class="text-primary mr-2">
                                    <small class="fas fa-star"></small>
                                    <small><?php echo number_format($rating_info['avg_rating'], 1); ?></small>
                                   
                                </div>
                                <small class="pt-1">(<?php echo $rating_info['review_count']; ?> Review)</small>
                                
                            </div>
                            <h3 class="font-weight-semi-bold mb-4">₱ <?php echo $fetch_product['price']; ?></h3>
                            <h5>Quantity: <?php echo $fetch_product['quantity']; ?></h5>

                            <p class="mb-4"><?php echo $fetch_product['status']; ?></p>
                            <div class="d-flex align-items-center mb-4 pt-2">
                                
                                
                                <button type="submit" class="btn btn-primary px-3" name="add_to_cart"> <i class="fa fa-shopping-cart mr-1"></i> Add To Cart</button>
                                <input type="hidden" name="id" value=" ">
                            </div>
                            <div class="d-flex pt-2">
                                <strong class="text-dark mr-2">Share on:</strong>
                                <div class="d-inline-flex">
                                    <a class="text-dark px-2" href="">
                                        <i class="fab fa-facebook-f"></i>
                                    </a>
                                    <a class="text-dark px-2" href="">
                                        <i class="fab fa-twitter"></i>
                                    </a>
                                    <a class="text-dark px-2" href="">
                                        <i class="fab fa-linkedin-in"></i>
                                    </a>
                                    <a class="text-dark px-2" href="">
                                        <i class="fab fa-pinterest"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row px-xl-5">
                    <div class="col">
                        <div class="bg-light p-30">
                            <div class="nav nav-tabs mb-4">
                                <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Description</a>
                                <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-2">Information</a>
                                <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (0)</a>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-pane-1">
                                    <h4 class="mb-3">Product Description</h4>
                                    <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                                    <p>Dolore magna est eirmod sanctus dolor, amet diam et eirmod et ipsum. Amet dolore tempor consetetur sed lorem dolor sit lorem tempor. Gubergren amet amet labore sadipscing clita clita diam clita. Sea amet et sed ipsum lorem elitr et, amet et labore voluptua sit rebum. Ea erat sed et diam takimata sed justo. Magna takimata justo et amet magna et.</p>
                                </div>
                                <div class="tab-pane fade" id="tab-pane-2">
                                    <h4 class="mb-3">Additional Information</h4>
                                    <p>Eos no lorem eirmod diam diam, eos elitr et gubergren diam sea. Consetetur vero aliquyam invidunt duo dolores et duo sit. Vero diam ea vero et dolore rebum, dolor rebum eirmod consetetur invidunt sed sed et, lorem duo et eos elitr, sadipscing kasd ipsum rebum diam. Dolore diam stet rebum sed tempor kasd eirmod. Takimata kasd ipsum accusam sadipscing, eos dolores sit no ut diam consetetur duo justo est, sit sanctus diam tempor aliquyam eirmod nonumy rebum dolor accusam, ipsum kasd eos consetetur at sit rebum, diam kasd invidunt tempor lorem, ipsum lorem elitr sanctus eirmod takimata dolor ea invidunt.</p>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0">
                                                    Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                                </li>
                                                <li class="list-group-item px-0">
                                                    Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                                </li>
                                                <li class="list-group-item px-0">
                                                    Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                                </li>
                                                <li class="list-group-item px-0">
                                                    Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                                </li>
                                            </ul> 
                                        </div>
                                        <div class="col-md-6">
                                            <ul class="list-group list-group-flush">
                                                <li class="list-group-item px-0">
                                                    Sit erat duo lorem duo ea consetetur, et eirmod takimata.
                                                </li>
                                                <li class="list-group-item px-0">
                                                    Amet kasd gubergren sit sanctus et lorem eos sadipscing at.
                                                </li>
                                                <li class="list-group-item px-0">
                                                    Duo amet accusam eirmod nonumy stet et et stet eirmod.
                                                </li>
                                                <li class="list-group-item px-0">
                                                    Takimata ea clita labore amet ipsum erat justo voluptua. Nonumy.
                                                </li>
                                            </ul> 
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="tab-pane-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="mb-4">1 review for "Product Name"</h4>
                                            <div class="media mb-4" style="width: 120vh;">
                                                <img src="img/user.jpg" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px; height: 45px;">
                                                <div class="media-body">
                                                    <h6>John Doe<small> - <i>01 Jan 2045</i></small></h6>
                                                    <div class="text-primary mb-2">
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star"></i>
                                                        <i class="fas fa-star-half-alt"></i>
                                                        <i class="far fa-star"></i>
                                                    </div>
                                                    <p>Diam amet duo labore stet elitr ea clita ipsum, tempor labore accusam ipsiam amet duo labore stet elitr ea clita ipsum, tempor labore accuiam amet duo labore stet elitr ea clita ipsum, tempor labore accuum et no at. Kasd diam tempor rebum magna dolores sed sed eirmod ipsum.</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            </form>
            <?php
                } else {
                    echo "Product details not available.";
                }
            ?>
        </main>
    </section>
    <script src="javascript/design.js"></script>

    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>

</body>
</html>
                    



