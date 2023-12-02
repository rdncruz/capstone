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
if(isset($_POST['add_to_cart'])){

    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $product_quantity = 1;
 
    $select_cart = mysqli_query($conn, "SELECT * FROM `cart` WHERE name = '$product_name'");
 
    if(mysqli_num_rows($select_cart) > 0){
       $message[] = 'product already added to cart';
    }else{
       $insert_product = mysqli_query($conn, "INSERT INTO `cart`(name, price, image, quantity) VALUES('$product_name', '$product_price', '$product_image', '$product_quantity')");
       $message[] = 'product added to cart succesfully';
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
    <title>Store</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    <link rel="stylesheet" href="CSS/shopping.css">
</head>
<body>
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-store'></i>
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
                <h1>Store</h1>
            </div>
            <?php
    
                $select_rows = mysqli_query($conn, "SELECT * FROM `cart`") or die('query failed');
                $row_count = mysqli_num_rows($select_rows);

            ?>
            <a href="cart.php" class="btn-download">
                <i class='bx bxs-cart-add'></i>
                <span id="cart_count" class="cart" > 
                    <?php echo $row_count; ?>
                </span>
            </a>
        </div>
        <?php
      
            $select_products = mysqli_query($conn, "SELECT * FROM `products`");
            if(mysqli_num_rows($select_products) > 0){
                while($fetch_product = mysqli_fetch_assoc($select_products)){
        ?>
            <form action="" method="post">     
                <div class="product-card">
                    <div class="badge">Hot</div>
                    <div class="product-tumb">
                        <img src="Image/<?php echo $fetch_product['image']; ?>"  alt="">
                    </div>
                    <div class="product-details">
                    <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                    <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                    <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                        <span class="product-catagory" name="product_name"><?php echo $fetch_product['category']; ?></span>
                        <h4><a href="./product_details.php?product_id=<?php echo $fetch_product['id']; ?>" name="product_name"><?php echo $fetch_product['name']; ?></a></h4>
                        <div class="product-bottom-details">
                            <div class="product-price" name="product_price">₱<?php echo $fetch_product['price']; ?></div>
                            <div class="product-links">
                                <button type="submit" class="fa fa-heart" name="add_to_cart">Add to cart <i class="fas fa-shopping-cart"></i></button>
                                <a href="./product_details.php?product_id=' . $productid . '" class="fa fa-shopping-cart" name="view">View Details <i class="fas fa-info-circle"></i></a>
                                <input type="hidden" name="product_id" value=" ">
                            </div>
                        </div>
                    </div>
                </div>
            </form>
            <?php
            };
        };
        ?>
        </main>
    </section>
    <script src="javascript/design.js"></script>
    <script src="javascript/design.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            document.querySelector('#add-to-cart-button').addEventListener('click', function() {
                const product_id = 123; // Replace with the actual product ID
                const cartCountElement = document.querySelector('#cart_count');
                const currentCount = parseInt(cartCountElement.textContent);

                // Increment the cart count
                cartCountElement.textContent = currentCount + 1;

                alert('Product added to cart');
            });
        });
    </script>
</body>
</html>
                    



