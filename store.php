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
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="" class="btn px-0 ml-3">
                <i class="fas fa-shopping-cart shopping-cart-icon"></i>
                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;"><h6>10</h6></span>
            </a>
			<a href="#" class="profile">
				<img src="./image/<?php echo $row['img']; ?>" alt="">
			</a>
		</nav>

        <main>
            
      
            <div class="container-fluid">
                <div class="row px-xl-5">
                    <!-- Shop Sidebar Start -->
                    <div class="col-lg-3 col-md-4">
                        <!-- Price Start -->
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
                        <div class="bg-light p-4 mb-30">
                            <form>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" checked id="price-all">
                                    <label class="custom-control-label" for="price-all">All Price</label>
                                    <span class="badge border font-weight-normal">1000</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="price-1">
                                    <label class="custom-control-label" for="price-1">$0 - $100</label>
                                    <span class="badge border font-weight-normal">150</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="price-2">
                                    <label class="custom-control-label" for="price-2">$100 - $200</label>
                                    <span class="badge border font-weight-normal">295</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="price-3">
                                    <label class="custom-control-label" for="price-3">$200 - $300</label>
                                    <span class="badge border font-weight-normal">246</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="price-4">
                                    <label class="custom-control-label" for="price-4">$300 - $400</label>
                                    <span class="badge border font-weight-normal">145</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                                    <input type="checkbox" class="custom-control-input" id="price-5">
                                    <label class="custom-control-label" for="price-5">$400 - $500</label>
                                    <span class="badge border font-weight-normal">168</span>
                                </div>
                            </form>
                        </div>
                        <!-- Price End -->
                        
                        <!-- Color Start -->
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by color</span></h5>
                        <div class="bg-light p-4 mb-30">
                            <form>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" checked id="color-all">
                                    <label class="custom-control-label" for="price-all">All Color</label>
                                    <span class="badge border font-weight-normal">1000</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="color-1">
                                    <label class="custom-control-label" for="color-1">Black</label>
                                    <span class="badge border font-weight-normal">150</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="color-2">
                                    <label class="custom-control-label" for="color-2">White</label>
                                    <span class="badge border font-weight-normal">295</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="color-3">
                                    <label class="custom-control-label" for="color-3">Red</label>
                                    <span class="badge border font-weight-normal">246</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="color-4">
                                    <label class="custom-control-label" for="color-4">Blue</label>
                                    <span class="badge border font-weight-normal">145</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                                    <input type="checkbox" class="custom-control-input" id="color-5">
                                    <label class="custom-control-label" for="color-5">Green</label>
                                    <span class="badge border font-weight-normal">168</span>
                                </div>
                            </form>
                        </div>
                        <!-- Color End -->
        
                        <!-- Size Start -->
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by size</span></h5>
                        <div class="bg-light p-4 mb-30">
                            <form>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" checked id="size-all">
                                    <label class="custom-control-label" for="size-all">All Size</label>
                                    <span class="badge border font-weight-normal">1000</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="size-1">
                                    <label class="custom-control-label" for="size-1">XS</label>
                                    <span class="badge border font-weight-normal">150</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="size-2">
                                    <label class="custom-control-label" for="size-2">S</label>
                                    <span class="badge border font-weight-normal">295</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="size-3">
                                    <label class="custom-control-label" for="size-3">M</label>
                                    <span class="badge border font-weight-normal">246</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                                    <input type="checkbox" class="custom-control-input" id="size-4">
                                    <label class="custom-control-label" for="size-4">L</label>
                                    <span class="badge border font-weight-normal">145</span>
                                </div>
                                <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                                    <input type="checkbox" class="custom-control-input" id="size-5">
                                    <label class="custom-control-label" for="size-5">XL</label>
                                    <span class="badge border font-weight-normal">168</span>
                                </div>
                            </form>
                        </div>
                        <!-- Size End -->
                    </div>
                    <!-- Shop Sidebar End -->
                    
        
                    <!-- Shop Product Start -->
                    <div class="col-lg-9 col-md-8">
                        <div class="row pb-3">
                            
                        <?php
      
                            $select_products = mysqli_query($conn, "SELECT * FROM `products` ORDER BY id DESC");
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
                                                <small class="fa fa-star text-primary mr-1"></small>
                                                <small><?php echo number_format($rating_info['average_rating'], 1); ?></small>
                                            <!-- Display the review count -->
                                                <small>(<?php echo $rating_info['review_count']; ?> reviews)</small>
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
                                    <li class="page-item disabled"><a class="page-link" href="#">Previous</span></a></li>
                                    <li class="page-item active"><a class="page-link" href="#">1</a></li>
                                    <li class="page-item"><a class="page-link" href="#">2</a></li>
                                    <li class="page-item"><a class="page-link" href="#">3</a></li>
                                    <li class="page-item"><a class="page-link" href="#">Next</a></li>
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
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="lib/easing/easing.min.js"></script>
    <script src="lib/owlcarousel/owl.carousel.min.js"></script>

</body>
</html>
                    



