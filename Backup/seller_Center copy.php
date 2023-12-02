<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Seller Center</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    
</head>
<body>
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-smile'></i>
            <span class="text">Renz Daryl Cruz</span>
        </a>
        <ul class="sidebar-menu">
            <li>
                <a href="index.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="inbox.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Inbox</span>
                </a>
            </li>
            <li>
                <a href="store.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Product</span>
                </a>
            </li>
			<li class="active">
                <a href="Seller_Center.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Sell on E-Fishing</span>
                </a>
            </li>
            <li>
                <a href="location.php">
                    <i class='bx bxs-dashboard'></i>
                    <span class="text">Location</span>
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
				<img src="img/people.png">
			</a>
		</nav>
        <main>
            <div class="head-title">
				<div class="left">
					<h1>Seller Centre</h1>
					<ul class="breadcrumb">
						
					</ul>
				</div>
            <div class="table-data">
				<div class="order">
					<div class="head">
						<div class="background">
							<div class="shape"></div>
							<div class="shape"></div>
						</div>
						<div class="logform">
							<form>
								<h3>Login Here</h3>
								<label for="username">Username</label>
								<input type="text" class="inputText"placeholder="Email" id="username">
					
								<label for="password">Password</label>
								<input type="password" placeholder="Password" id="password">
								
								<button>Log In <a href="testing.html"> </button></a>
					
								<div class="desc">
									<p class="txt">Don't have an account? <a href="#" class="signup">Sign Up</a></p>
								</div>
							</form>
						</div>
					</div>
				</div>
            </div>
        </main>
    </section>
	<script src="javascript/design.js"></script>
</body>
</html>