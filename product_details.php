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
            $product_name = $fetch_product['name'];
            $product_price = $fetch_product['price'];
            $product_image = $fetch_product['image'];
            $product_quantity = 1;
         
            $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");
         
            if(mysqli_num_rows($select_cart) > 0){
                $message[] = 'Product already added to the cart';
            } else {
                $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
                $message[] = 'Product added to the cart successfully';
            }
        }
    } else {
        echo "Product not found.";
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
    <title>Product</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Override Bootstrap's container padding -->
    <style>
       
        #sidebar .sidebar-menu {
            margin-top: 1;
            padding: 0;
        }
    </style>
    <!-- Include the Bootstrap stylesheet -->

    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-smile'></i>
            <span class="text"><?php echo $row['username']; ?></span>
        </a>
        <ul class="sidebar-menu">
            <li>
                <a href="home.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Home</span>
                </a>
            </li>
            <li>
                <a href="newsfeed.php">
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
            <input type="checkbox" id="switch-mode" hidden>
            <label for="switch-mode" class="switch-mode"></label>
            <a href="#" class="notification">
                <i class='bx bxs-bell' ></i>
                <span class="num">8</span>
            </a>
            <a href="#" class="profile">
                <img src="./image/<?php echo $row['img']; ?>" alt="">
            </a>
        </nav>
        <main>
            <div class="head-title">
                <div class="left">
                <a href="store.php"><h1>Store</h1>
                </div>
                <a href="cart.php" class="btn-download">
                    <i class='bx bxs-cart-add'></i>
                    <?php 
                        if(isset($_SESSION['cart'])) {
                            $count = count($_SESSION['cart']);
                            echo "<span id=\"cart_count\" class=\"text-warning bg-light\">$count</span>";
                        } else {
                            echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";
                        }
                    ?>
                </a>
            </div>
            
            <?php
            // Check if $fetch_product is set before displaying details
            if (isset($fetch_product)) {
                $rating_info = getRatingInfo($conn, $product_id);
        ?>
        
        <form action="" method="post">     
            <div class="single-product">
                <div class="row">
                    <div class="col-6">
                        <div class="product-image">
                            <div class="product-image-main">
                                <img src="Image/<?php echo $fetch_product['image']; ?>" alt="" id="product-main-image">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="product">
                            <div class="product-title">
                                <h1><?php echo $fetch_product['name']; ?></h1>
                                <!--<h3><?php echo $fetch_product['Category']; ?></h3>-->
                            </div>
                            <div class="rating">
        <!-- Display the scaled average rating -->
        <span><?php echo number_format($rating_info['avg_rating'], 1); ?></span>
        <!-- Display the review count -->
        
    </div>
                            <div class="product-price">
                                <span class="offer-price">₱<?php echo $fetch_product['price']; ?></span>
                            </div>
                            <div class="product-detailss">
                                <h3>Status: <?php echo $fetch_product['status']; ?> </h3>
                                <h3>Quantity: <?php echo $fetch_product['quantity']; ?></h3>
                                <h3>Description</h3>
                                <p><?php echo $fetch_product['small_description']; ?></p>
                            </div>
                            <div class="product-btn-group">
                                <a href="store.php" class="button add-cart" name="view">Go Back<i class="bx bxs-cart"></i></a>
                                <button type="submit" class="button buy-now" name="add_to_cart">Add to cart <i class="bx bxs-cart"></i></button>
                                <input type="hidden" name="id" value=" ">
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
    <script src="javascript/product.js"></script>
</body>
</html>