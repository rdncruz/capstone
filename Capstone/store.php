<?php 
    session_start();
    include 'php/db.php';
    include './php/component.php';

	$unique_id = $_SESSION['unique_id'];
    if(empty($unique_id)) {
        header('Location: login.php');
    }
    $qry = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
    if (mysqli_num_rows($qry) > 0) {
        $row = mysqli_fetch_assoc($qry);
        if($row) {
            $_SESSION['verification_status'] = $row ['verification_status'];
            if($row['verification_status'] != 'Verified') {
                header("Location: verify.php");
            }
        }
    }


	if (isset($_POST['add'])) {
        if (isset($_SESSION['cart'])) {
            $item_array_id = array_column($_SESSION['cart'], "product_id");
        
            if (in_array($_POST['product_id'], $item_array_id)) {
                echo "<script>alert('Product is already added in the cart...!')</script>";
                echo "<script>window.location = 'store.php'</script>";
            } else {
                $item_array = array(
                    'product_id' => $_POST['product_id']
                );
    
                // Reset the cart array
                
    
                $_SESSION['cart'][] = $item_array;
            }
        } else {
            $item_array = array(
                'product_id' => $_POST['product_id']
            );
            $_SESSION['cart'][] = $item_array;
            print_r($_SESSION['cart']);
        }
    }
    ?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--Bootsrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="CSS/style.css">
	<link rel="stylesheet" href="CSS/shopping.css">
    


	<title>Add Product</title>
</head>
<body>
	<!-- SIDEBAR -->
	<section id="sidebar">
		<a href="index.html" class="brand">
			<i class='bx bxs-smile'></i>
			<span class="text">Seller Hub</span>
		</a>
		<ul class="side-menu top">
			<li>
				<a href="index.php">
					<i class='bx bxs-dashboard' ></i>
					<span class="text">Home</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-message-dots' ></i>
					<span class="text">Inbox</span>
				</a>
			</li>
			<li class="active">
				<a href="store.php">
					<i class='bx bxs-store'></i>
					<span class="text">store</span>
				</a>
			</li>
			<li>
				<a href="#">
					<i class='bx bxs-map'></i>
					<span class="text">Location</span>
				</a>
			</li>
		</ul>
		<ul class="side-menu">
			<li>
				<a href="#" class="logout">
					<i class='bx bxs-log-out-circle' ></i>
					<span class="text">Logout</span>
				</a>
			</li>
		</ul>
	</section>
	<!-- SIDEBAR -->



	<!-- CONTENT -->
	<section id="content">
		<!-- NAVBAR -->
		<nav>
			<i class='bx bx-menu' ></i>
			<a href="#" class="nav-link">Categories</a>
			<form action="#">
				<div class="form-input">
					<input type="search" placeholder="Search...">
					<button type="submit" class="search-btn"><i class='bx bx-search' ></i></button>
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
				<img src="img/people.png">
			</a>
		</nav>
		<!-- NAVBAR -->

		<!-- MAIN -->
		<main>
			<div class="head-title">
				<div class="left">
					<h1>Store</h1>
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
			<div class="table-data">
				
				<div class="row text-center py-5">
				<?php 
					$sql = "SELECT * FROM products";
					$result = mysqli_query($conn, $sql);
					
					if (mysqli_num_rows($result) > 0) {
						while ($row = mysqli_fetch_assoc($result)) {
							// Call the component() function with retrieved data
							component($row['name'], $row['price'], $row['image'], $row['id']);
						}
					} else {
						echo "No products found.";
					}
					
				?>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	
	<script src="js/products.js"></script>
	<script src="js/script.js"></script>
    
	
</body>
</html>