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
    <title>Newsfeed</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-store'></i>
            <span class="text"><?php echo $row['username']; ?></span>

        </a>
        <ul class="sidebar-menu">
            <li class="active">
                <a href="seller_dashboard.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li >
                <a href="seller_newsfeed.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Newsfeed</span>
                </a>
            </li>
            <li>
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
        <nav>
			<i class='bx bx-menu' ></i>
			
			<form action="#">
				<!---->
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
					<h1>Dashboard</h1>
					<ul class="breadcrumb">
						
					</ul>
				</div>
				<a href="#" class="btn-download">
					<i class='bx bxs-cloud-download' ></i>
					<span class="text">Download PDF</span>
				</a>
			</div>

            <ul class="box-info">
				<li>
					<i class='bx bxs-calendar-check' ></i>
					<span class="text">
                    <?php 
                        $total_order_query = mysqli_query($conn, "SELECT COUNT(*) AS total_rows FROM `checkout` WHERE unique_id = '{$_SESSION['unique_id']}'");
                        $total_order_result = mysqli_fetch_assoc($total_order_query);
                        $total_order = $total_order_result['total_rows'];
                    ?>
                    <h3><?php echo $total_order ?></h3>
                    <h4>Total Order</h4>

					</span>
				</li>
	
				<li>
					<i class='bx bxs-dollar-circle' ></i>
					<span class="text">
                        <?php 
                            $total_order_querys = mysqli_query($conn, "SELECT COUNT(*) AS total_rows FROM `checkout` WHERE unique_id = '{$_SESSION['unique_id']}' AND status = 'Completed'");
                            $total_order_results = mysqli_fetch_assoc($total_order_querys); // Fix: Change $total_order_result to $total_order_results
                            $complete_order = $total_order_results['total_rows'];
                        ?>
                        <h3><?php echo $complete_order ?></h3>
						<h4>Completed Order</h4>
					</span>
				</li>
			</ul>

            <div class="table-data">
				<div class="order">
					<div class="head">
						<h3>List of your Orders</h3>
						<i class='bx bx-filter' ></i>
					</div>
					<table>
						<thead>
							<tr>
                                <th>Reference ID</th>
                                <th>Full Name</th>
                                <th>Username</th>
								<th>Email</th>
                                <th>Product Name</th>
                                <th>Quantity</th>
								<th>Price</th>
								<th>Order Date</th>
                                <th>Status</th>
                                <th>Action</th>
							</tr>
						</thead>
						<tbody>
                            <?php
                                require './php/config.php';
                                
                                $query = "SELECT c.*, p.name AS product_name, u.username, u.email
          FROM checkout c
          INNER JOIN products p ON c.product_id = p.product_id
          INNER JOIN users u ON c.unique_id = u.unique_id
          WHERE p.unique_id = $unique_id";

                                $query_run = mysqli_query($conn, $query);
                            if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $order)
                                        {
                                             ?>
                                            <tr>
                                                <td><?= $order['checkout_id'] ?></td>
                                                <td><?= $order['name'] ?></td>
                                                <td><?= $order['username'] ?></td>
                                                <td><?= $order['email'] ?></td>
                                                <td><?= $order['product_name'] ?></td>
                                                <td><?= $order['quantity'] ?></td>
                                                <td><?= $order['price'] ?></td>
                                                <td><?= $order['order_date'] ?></td>
                                                <td><?= $order['status'] ?></td>
                                                <td>
                                                    <button type="button" value="<?=$student['id'];?>" class="viewStudentBtn btn btn-info btn-sm">Map</button>
                                                    <button type="button" value="<?=$student['id'];?>" class="editStudentBtn btn btn-success btn-sm">Update</button>
                                                    <button type="button" value="<?=$student['id'];?>" class="deleteStudentBtn btn btn-danger btn-sm">Delivered</button>
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
        </main>
    </section>
	<script src="javascript/design.js"></script>
    <script>
        const pElements = document.querySelectorAll('p');
        let currentIndex = 0;

        function displayNextP() {
            pElements.forEach((p, index) => {
                p.style.display = index === currentIndex ? 'block' : 'none';
                p.classList.remove('fade');
            });

            currentIndex = (currentIndex + 1) % pElements.length;

            pElements[currentIndex].classList.add('fade');
        }

        displayNextP();
        setInterval(displayNextP, 5000); // Change the time interval (in milliseconds) as needed
    </script>
</body>
</html>