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

if (isset($fetch_product)) {
    $rating_info = getRatingInfo($conn, $product_id);

    // Retrieve product name from the products table
    $select_product_name = mysqli_query($conn, "SELECT name FROM products WHERE product_id = '$product_id'");
    $product_name = "";
    
    if ($select_product_name && mysqli_num_rows($select_product_name) > 0) {
        $product_data = mysqli_fetch_assoc($select_product_name);
        $product_name = $product_data['name'];
    }

    // Retrieve reviews for the product
    $select_reviews = mysqli_query($conn, "SELECT * FROM review WHERE product_id = '$product_id'");
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
    <style>
        #map {
            height: 400px;
        }
    </style>
    
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
                            
                        </div>
                    </div>
                </div>
                <div class="row px-xl-5">
                    <div class="col">
                        <div class="bg-light p-30">
                            <div class="nav nav-tabs mb-4">
                                <a class="nav-item nav-link text-dark active" data-toggle="tab" href="#tab-pane-1">Shop Details</a>
                                
                                <a class="nav-item nav-link text-dark" data-toggle="tab" href="#tab-pane-3">Reviews (<?php echo mysqli_num_rows($select_reviews); ?>)</a>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="tab-pane-1">
                                    <?php 
                                   if (isset($fetch_product)) {
                                    $rating_info = getRatingInfo($conn, $product_id);
                                
                                    // Retrieve shop owner's unique_id using product_id
                                    $product_id = $fetch_product['product_id'];
                                    $select_shop_owner = mysqli_query($conn, "SELECT unique_id FROM products WHERE product_id = '$product_id'");
                                    $shop_owner_data = mysqli_fetch_assoc($select_shop_owner);
                                
                                    if ($shop_owner_data) {
                                        $shop_owner_unique_id = $shop_owner_data['unique_id'];
                                
                                        // Retrieve shop owner details using unique_id
                                        $select_shop_owner_details = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '$shop_owner_unique_id'");
                                        $shop_owner_details = mysqli_fetch_assoc($select_shop_owner_details);
                                
                                        // Your existing code for displaying product details goes here...
                                
                                        // Your existing code for displaying shop details goes here...
                                        ?>
                                        

                                    <div class="container-fluid">
                                        <div class="row px-xl-5">
                                            <div class="col-lg-8">
                                            
                                                <div class="bg-light p-30 mb-5">
                                                    <div class="row">
                                                        <div class="col-md-6 form-group">
                                                            <label>Shop Name</label>
                                                            <input class="form-control" type="text" value="<?php echo $shop_owner_details['shop_name']; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label>Status</label>
                                                            <input class="form-control" type="text" value="<?php echo $shop_owner_details['status']; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label>Full Name</label>
                                                            <input class="form-control" type="text" value="<?php echo $shop_owner_details['fname']; ?> <?php echo $shop_owner_details['lname']; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-6 form-group">
                                                            <label>E-mail</label>
                                                            <input class="form-control" type="text" value="<?php echo $shop_owner_details['email']; ?>" readonly>
                                                        </div>
                                                        
                                                        <div class="col-md-6 form-group">
                                                            <label>City</label>
                                                            <input class="form-control" type="text" value="<?php echo $shop_owner_details['address']; ?>" readonly>
                                                        </div>
                                                        <div class="col-md-12 form-group">
                                                            <label id="messageLabel" style="cursor: pointer;">
                                                                <i class="fas fa-envelope"></i> Message us
                                                            </label>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="custom-control custom-checkbox">
                                                                <input type="checkbox" class="custom-control-input" id="shipto">
                                                                <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">View Shop Location</label>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="collapse mb-5" id="shipping-address">
                                                    
                                                   
                                                        <div id="map"></div>
                                                    
                                                </div>
                                            </div>

                                            <div class="col-lg-4">
                                                
                                                <div class="bg-light p-30 mb-5">
                                                    <img src="image/Orange_Minimalist_Fishing_Logo.png" alt="Order Total Image" class="img-fluid">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <?php
                                    }
                                }
?>

                                </div>
                                
                                <div class="tab-pane fade" id="tab-pane-3">
                                    <div class="row">
                                        <div class="col-md-6">
                                            <h4 class="mb-4"><?php echo mysqli_num_rows($select_reviews); ?> review(s) for "<?php echo $fetch_product['name']; ?>"</h4>
                                            <?php
                                            while ($review = mysqli_fetch_assoc($select_reviews)) {
                                                // Retrieve username from the users table
                                                $review_user_id = $review['unique_id']; // Assuming unique_id is used in the review table
                                                $select_username = mysqli_query($conn, "SELECT username FROM users WHERE unique_id = '$review_user_id'");
                                                $username = "";

                                                if ($select_username && mysqli_num_rows($select_username) > 0) {
                                                    $user_data = mysqli_fetch_assoc($select_username);
                                                    $username = $user_data['username'];
                                                }
                                            ?>
                                                <div class="media mb-4" style="width: 120vh;">
                                                
                                                    <img src="./image/<?php echo $row['img']; ?>" alt="Image" class="img-fluid mr-3 mt-1" style="width: 45px; height: 45px;">
                                                    <div class="media-body">
                                                        <h6><?php echo $username; ?><small> - <i><?php echo date('Y-m-d', strtotime($review['review_date'])); ?></i></small></h6>
                                                        <div class="text-primary mb-2">
                                                            <?php
                                                            $stars = $review['rating'];
                                                            for ($i = 1; $i <= 5; $i++) {
                                                                if ($i <= $stars) {
                                                                    echo '<i class="fas fa-star"></i>';
                                                                } else {
                                                                    echo '<i class="far fa-star"></i>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                        <p><?php echo $review['description']; ?></p>
                                                    </div>
                                                </div>
                                            <?php
                                            }
                                            ?>
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
    <script src="javascript/chat.js"></script>
    <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBT7g_YV4I7cksILtC4ed1TfN7JIpJ8I3Q&callback=initMap" async defer></script>

    <?php
// Get the user's location from the database (assuming you have latitude and longitude columns)
    $sql_location = mysqli_query($conn, "SELECT lat, lng FROM location WHERE unique_id = '{$shop_owner_unique_id}'");
    if (mysqli_num_rows($sql_location) > 0) {
        $location_data = mysqli_fetch_assoc($sql_location);
        $latitude = $location_data['lat'];
        $longitude = $location_data['lng'];
    } else {
        // Default coordinates if not found in the database
        $latitude = 37.7749;
        $longitude = -122.4194;
    }
    ?>
    <script>
    $(document).ready(function(){
        $('#messageLabel').click(function(){
            // Make sure to replace 'seller_id' with the correct parameter used in chat.php
            window.location.href = 'chat.php?user_id=<?php echo $shop_owner_unique_id; ?>';
        });
    });
</script>


    <script>
        var map;
        var markers = [];

        function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?> },
                zoom: 17.0
            });

            // Add a custom icon for the user's location marker
            var userMarker = new google.maps.Marker({
                position: { lat: <?php echo $latitude; ?>, lng: <?php echo $longitude; ?> },
                map: map,
                title: 'Your Location',
                icon: {
                    url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png',
                }
            });
        }

       
    </script>


</body>
</html>
                    



