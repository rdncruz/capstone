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
            if ($row['role'] === 'user') {
                if($row['verification_status'] != 'Verified') {
                    header("Location: verify.php");
                }
            } 
            else {
                // Redirect to login.php if the user is not a seller
                header("Location: index.php");
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
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
                                <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
                                <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link rel="stylesheet" href="css/style.css">
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
                <a href="newsfeed.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Newsfeed</span>
                </a>
            </li>
            <li  class="active">
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
            <li>
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
                                <th>Shop Name</th>
								<th>Product Name</th>
                                <th>Quantity</th>
                                <th>Price</th>
								<th>Date Order</th>
								<th>Status</th>
                                <th>Action</th>
							</tr>
						</thead>
						<tbody>
                            <?php
                                require './php/config.php';
                                $query = "SELECT checkout.*, products.name as product_name, users.shop_name as seller_shop_name
                                            FROM checkout 
                                            INNER JOIN products ON checkout.product_id = products.product_id 
                                            INNER JOIN users ON products.unique_id = users.unique_id 
                                            WHERE checkout.unique_id = {$_SESSION['unique_id']}
                                            ORDER BY checkout.id DESC";
                                $query_run = mysqli_query($conn, $query);
                            if(mysqli_num_rows($query_run) > 0)
                                    {
                                        foreach($query_run as $order)
                                        {
                                             ?>
                                            <tr>
                                                <td><?= $order['checkout_id'] ?></td>
                                                <td><?= $order['seller_shop_name'] ?></td>
                                                <td><?= $order['product_name'] ?></td>
                                                <td><?= $order['quantity'] ?></td>
                                                <td><?= $order['price'] ?></td>
                                                <td><?= $order['order_date'] ?></td>
                                                <td><?= $order['status'] ?></td>
                                                <td>
                                                <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#form"> Rate Now </button>
                                                   
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

            <div class="modal fade" id="form" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="text-right cross"> <i class="fa fa-times mr-2"></i> </div>
            <div class="card-body text-center"> <img src=" https://i.imgur.com/d2dKtI7.png" height="100" width="100">
                <div class="comment-box text-center">
                <h4>Add a comment</h4>
                <div class="rating"> <input type="radio" name="rating" value="5" id="5"><label for="5">☆</label> <input type="radio" name="rating" value="4" id="4"><label for="4">☆</label> <input type="radio" name="rating" value="3" id="3"><label for="3">☆</label> <input type="radio" name="rating" value="2" id="2"><label for="2">☆</label> <input type="radio" name="rating" value="1" id="1"><label for="1">☆</label> </div>
                <div class="comment-area"> <textarea class="form-control" placeholder="what is your view?" rows="4"></textarea> </div>
                    
                    <div class="text-center mt-4"> <button class="btn btn-success send px-5">Send message <i class="fa fa-long-arrow-right ml-1"></i></button>
            </div>
            </div>
        </div>
    </div>
</div>
</div>
        </main>
    </section>
    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js'></script>
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