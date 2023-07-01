<?php 

    // if the user is not login so redirect to login page
    session_start();
    include 'php/db.php';
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

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	

	<!-- Boxicons -->
	<link href='https://unpkg.com/boxicons@2.0.9/css/boxicons.min.css' rel='stylesheet'>
	<!-- My CSS -->
	<link rel="stylesheet" href="CSS/style.css">

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
				<a href="#">
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
			<li>
				<a href="store.php">
					<i class='bx bxs-store'></i>
					<span class="text">store</span>
				</a>
			</li>
			<li class="active">
				<a href="#">
					<i class='bx bxs-cart-add' ></i>
					<span class="text">Add Product</span>
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
					<h1>List of Products</h1>
				</div>
				<a href="./create.php" class="btn-download">
					<i class='bx bx-plus-medical' ></i>
					<span class="text">Insert Product</span>
				</a>
			</div>
			<div class="table-data">
				<div class="order">
					<div class="head">
						<h3>List of Products</h3>
					</div>
					<table class="table">
						<thread>
						  
							<th>Category Id</th>
							<th>name</th>
							<th>Small Description</th>
							<th>Price</th>
							<th>Quantity</th>
							<th>Status</th>
							<th>Action</th>
						</thread>
						<tbody>
							<?php 
		
								include 'php/db.php';
		
								$sql = "SELECT * FROM `products`";
								$result = $conn->query($sql);
		
								if(!$result) {
									die("Invalid query: ". $connection->error);
								}
								while ($row = $result->fetch_assoc()) {
									echo "
									<tr>
										
										<td>$row[category]</td>
										<td>$row[name]</td>
										<td>$row[small_description]</td>
										<td>$row[price]</td>
										<td>$row[quantity]</td>
										<td>$row[status]</td>
										<td>
											<a class='btn btn-primary btn-sm' href='./edit.php?id=$row[id]'>Edit</a>
											<a class='btn btn-danger btn-sm' href='./php/delete.php?id=$row[id]'>Delete</a>
										</td>
									</tr>
									";
								}
							?>
							
						</tbody>
					</table>
				</div>
			</div>
		</main>
		<!-- MAIN -->
	</section>
	<!-- CONTENT -->
	

	<script src="js/script.js"></script>
	
</body>
</html>