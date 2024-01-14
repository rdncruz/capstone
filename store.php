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
function getAverageRating($conn, $product_id) {
    $query = "SELECT AVG(rating) as avg_rating, COUNT(unique_id) as review_count FROM review WHERE product_id = '$product_id'";
    $result = mysqli_query($conn, $query);

    if (!$result) {
        // Output the error message and exit
        die('Error in query: ' . mysqli_error($conn));
    }

    $row = mysqli_fetch_assoc($result);

    // Scale the average rating to be within 5
    $scaled_rating = ($row['avg_rating'] / 5) * 5;

    // Return an associative array with scaled average rating and review count
    return [
        'average_rating' => round($scaled_rating, 1) ?: 0,
        'review_count' => $row['review_count']
    ];
}

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
            <a href="user_profile.php" style="font-size: 30px;">
				<i class='bx bxs-cog' ></i>
			</a>
			<a href="#" class="profile">
				<img src="./image/<?php echo $row['img']; ?>" alt="">
			</a>
		</nav>

        <main>
            
        <form action="" method="post">   
            <div class="container-fluid">
                <div class="row px-xl-5">
                    <!-- Shop Sidebar Start -->
                    <div class="col-lg-3 col-md-4">
                        <!-- Price Start -->
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
                        <div class="bg-light p-4 mb-30">
    <form method="post" action="">
        <div class="form-group">
            <label for="min_price">Min Price</label>
            <input type="text" class="form-control" id="min_price" name="min_price" placeholder="Enter min price" value="<?php echo isset($_POST['min_price']) ? htmlspecialchars($_POST['min_price']) : ''; ?>">
        </div>
        <div class="form-group">
            <label for="max_price">Max Price</label>
            <input type="text" class="form-control" id="max_price" name="max_price" placeholder="Enter max price" value="<?php echo isset($_POST['max_price']) ? htmlspecialchars($_POST['max_price']) : ''; ?>">
        </div>
        <button type="submit" class="btn btn-primary" name="filter_price">Apply Filter</button>
        <button type="submit" class="btn btn-secondary" name="reset_filter">Reset Filter</button>
    </form>
</div>

                        <!-- Price End -->
        
                        
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by Shop</span></h5>
                        <div class="bg-light p-4 mb-30">
        <form method="post" action="" id="shopFilterForm">
            <div class="form-group">
                <label for="selected_shop">Select Shop</label>
                <select class="form-control" id="selected_shop" name="selected_shop">
                    <option value="" selected>Select a shop</option>
                    <?php
                    $select_shops = mysqli_query($conn, "SELECT DISTINCT shop_name FROM users WHERE shop_name IS NOT NULL");
                    while ($shop = mysqli_fetch_assoc($select_shops)) {
                        ?>
                        <option value="<?php echo $shop['shop_name']; ?>" <?php echo (isset($_POST['selected_shop']) && $_POST['selected_shop'] === $shop['shop_name']) ? 'selected' : ''; ?>><?php echo $shop['shop_name']; ?></option>
                        <?php
                    }
                    ?>
                </select>
            </div>
            <button type="submit" class="btn btn-primary" name="filter_shop">Apply Shop Filter</button>
            <!-- Add Reset Shop Filter button -->
            <button type="button" class="btn btn-secondary" name="reset_shop_filter" id="resetShopFilter">Reset Shop Filter</button>
        </form>
    </div>
                       
                    </div>
                    <!-- Shop Sidebar End -->
                    
        
                    <!-- Shop Product Start -->
                    <div class="col-lg-9 col-md-8">
                        <div class="row pb-3">
                            
                        <?php
                        $filter_sql = "";
                        $min_price = '';
                        $max_price = '';
                        $current_page = isset($_GET['page']) ? intval($_GET['page']) : 1;

                        // Set the number of products per page
                        $products_per_page = 6;

                        // Calculate the offset for the SQL query based on the current page
                        $offset = ($current_page - 1) * $products_per_page;

                        

                        
                        if (isset($_POST['filter_price'])) {
                            $min_price = mysqli_real_escape_string($conn, $_POST['min_price']);
                            $max_price = mysqli_real_escape_string($conn, $_POST['max_price']);
                        
                            // Validate the input values (you may add more robust validation as needed)
                            if (!is_numeric($min_price) || !is_numeric($max_price)) {
                                // Handle invalid input
                                echo "Please enter valid numeric values for both min and max prices.";
                                exit();
                            }
                        
                            $filter_sql .= " AND price BETWEEN $min_price AND $max_price";
                        
                            // Store filter values in session variables
                            $_SESSION['min_price'] = $min_price;
                            $_SESSION['max_price'] = $max_price;
                        }
                        
                        // Check for Reset Filter button
                        if (isset($_POST['reset_filter'])) {
                            // Clear filter values and session variables
                            $min_price = $max_price = '';
                            unset($_SESSION['min_price']);
                            unset($_SESSION['max_price']);
                        }
                        
                        // Check for shop filter
                        $selected_shop = '';
                        if (isset($_POST['filter_shop'])) {
                            $selected_shop = isset($_POST['selected_shop']) ? mysqli_real_escape_string($conn, $_POST['selected_shop']) : '';
                        
                            if (!empty($selected_shop)) {
                                // Apply the shop filter to the SQL query
                                $filter_sql .= " AND shop_name = '$selected_shop'";
                            }
                        }
                        
                        // Check for Reset Shop Filter button
                        if (isset($_POST['reset_shop_filter'])) {
                            // Clear the shop filter
                            $selected_shop = '';
                        }
                        
                        
                        // Add this line after the $select_products query
                        
                        
                        // Check for Reset Shop Filter button

                        $select_products = mysqli_query($conn, "SELECT p.*, u.shop_name FROM `products` p JOIN `users` u ON p.unique_id = u.unique_id WHERE 1 $filter_sql ORDER BY p.id DESC LIMIT $offset, $products_per_page");
                        $total_products_query = mysqli_query($conn, "SELECT COUNT(*) AS total FROM `products` p JOIN `users` u ON p.unique_id = u.unique_id WHERE 1 $filter_sql");
$total_products_result = mysqli_fetch_assoc($total_products_query);
$total_products = $total_products_result['total'];

// Calculate the total number of pages
$totalPages = ceil($total_products / $products_per_page);

// Check for errors
if (!$select_products) {
    // Output the error message and exit
    die('Error in query: ' . mysqli_error($conn));
}
                        if (mysqli_num_rows($select_products) > 0) {
                                while ($fetch_product = mysqli_fetch_assoc($select_products)) {
                                    // Calculate the scaled average rating and get the review count for the current product
                                    $rating_info = getAverageRating($conn, $fetch_product['product_id']);
                            ?>
                            
                            <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                                <div class="product-item bg-light mb-4">
                                <input type="hidden" name="product_id" value="<?php echo $fetch_product['product_id']; ?>">
                                <input type="hidden" name="product_name" value="<?php echo $fetch_product['name']; ?>">
                                <input type="hidden" name="product_price" value="<?php echo $fetch_product['price']; ?>">
                                <input type="hidden" name="product_image" value="<?php echo $fetch_product['image']; ?>">
                                    <div class="product-img position-relative overflow-hidden">
                                        <img class="img-fluid w-100" src="<?php echo $fetch_product['image']; ?>" alt="">
                                    </div>
                                    <div class="text-center py-4">
                                        <a class="h6 text-decoration-none text-truncate" href="./product_details.php?product_id=<?php echo $fetch_product['product_id']; ?>" name="product_name"> <?php echo $fetch_product['name']; ?></a>
                                        <div class="d-flex align-items-center justify-content-center mt-2">
                                            <h5>₱<?php echo $fetch_product['price']; ?></h5><h6 class="text-muted ml-2"><del>₱000.00</del></h6>
                                        </div>
                                        <div class="rating">
                                            <!-- Display the scaled average rating -->
                                                <small>(<?php echo $rating_info['review_count']; ?> reviews)</small>
                                                <small><?php echo number_format($rating_info['average_rating'], 1); ?></small>
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                
                                            <!-- Display the review count -->
                                                
                                        </div>

                                        <!--
                                        <div class="d-flex align-items-center justify-content-center mb-1">
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small class="fa fa-star text-primary mr-1"></small>
                                            <small>(99)</small>
                                        </div>
                                        -->
                                    </div>
                                </div>
                            </div>
                            
                            <?php
            };
        };
        ?>
                            <div class="col-12">
                                <ul class="pagination justify-content-center">
                                <?php
    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<li class='page-item " . ($i === $current_page ? 'active' : '') . "'><a class='page-link' href='?page=$i'>$i</a></li>";
    }
    ?>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <!-- Shop Product End -->
                </div>
            </div>
        </form>
        </main>
    </section>
    <script src="javascript/design.js"></script>
    <script src="javascript/design.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>
    <!-- Add the following script to handle resetting filter values -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        var minPriceInput = document.getElementById('min_price');
        var maxPriceInput = document.getElementById('max_price');
        var filterForm = document.getElementById('filterForm');

        // Validate input values to be non-negative integers
        minPriceInput.addEventListener('input', function () {
            validateInput(minPriceInput);
        });

        maxPriceInput.addEventListener('input', function () {
            validateInput(maxPriceInput);
        });

        // Function to validate input as non-negative integers
        function validateInput(inputElement) {
            var inputValue = parseInt(inputElement.value, 10);
            if (isNaN(inputValue) || inputValue < 0) {
                inputElement.value = '';
            }
        }

        // Listen for the Reset Filter button click
        var resetFilterButton = document.querySelector('[name="reset_filter"]');
        resetFilterButton.addEventListener('click', function () {
            // Reset min and max price values to empty when the button is clicked
            minPriceInput.value = '';
            maxPriceInput.value = '';

            // Automatically submit the form to trigger the filtering process
            filterForm.submit();
        });
    });
    document.addEventListener('DOMContentLoaded', function () {
        var shopFilterForm = document.getElementById('shopFilterForm');
        var resetShopFilterButton = document.getElementById('resetShopFilter');
        var selectedShop = document.getElementById('selected_shop');

        // Listen for the Reset Shop Filter button click
        resetShopFilterButton.addEventListener('click', function () {
            // Reset the selected shop value to the default option
            selectedShop.value = '';

            // Automatically submit the form to trigger the filtering process
            shopFilterForm.submit();
        });
    });
</script>

</body>
</html>
                    



