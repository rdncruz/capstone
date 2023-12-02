
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
            <span class="text"></span>

        </a>
        <ul class="sidebar-menu">
            <li class="active">
                <a href="newsfeed.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Newsfeed</span>
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
				
                <a href="php/logout.php?logout_id="> 
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
				<img src="./image/" alt="">
			</a>
		</nav>
        <main>
        <div class="comments-container">
		<h1>Comments</h1>

		<ul id="comments-list" class="comments-list">
			<li>
				<div class="comment-main-level">

					<div class="comment-avatar"><img src="" alt=""></div>

					<div class="comment-box">
						<div class="comment-head">
							<h6 class="comment-name by-author"><a href="#">Agustin Ortiz</a></h6>
							<span>20 minutes ago</span>
							<i class="fa fa-reply"></i>
							<i class="fa fa-heart"></i>
						</div>
						<div class="comment-content">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
						</div>
					</div>
				</div>

				<ul class="comments-list reply-list">
					<li>
						<div class="comment-avatar"><img src="" alt=""></div>

						<div class="comment-box">
							<div class="comment-head">
								<h6 class="comment-name"><a href="#">Lorena Rojero</a></h6>
								<span>10 minutes ago</span>
								<i class="fa fa-reply"></i>
								<i class="fa fa-heart"></i>
							</div>
							<div class="comment-content">
								Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
							</div>
						</div>
					</li>
				</ul>
			</li>
			<li>
				<div class="comment-main-level">

					<div class="comment-avatar"><img src="" alt=""></div>

					<div class="comment-box">
						<div class="comment-head">
							<h6 class="comment-name"><a href="#">Lorena Rojero</a></h6>
							<span>10 minutes ago</span>
							<i class="fa fa-reply"></i>
							<i class="fa fa-heart"></i>
						</div>
						<div class="comment-content">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
						</div>
					</div>
				</div>
			</li>
            <li>
				<div class="comment-main-level">

					<div class="comment-avatar"><img src="" alt=""></div>

					<div class="comment-box">
						<div class="comment-head">
							<h6 class="comment-name"><a href="#">Lorena Rojero</a></h6>
							<span>10 minutes ago</span>
							<i class="fa fa-reply"></i>
							<i class="fa fa-heart"></i>
						</div>
						<div class="comment-content">
							Lorem ipsum dolor sit amet, consectetur adipisicing elit. Velit omnis animi et iure laudantium vitae, praesentium optio, sapiente distinctio illo?
						</div>
					</div>
				</div>
			</li>
		</ul>
	</div>
</main>

    </section>
	<script src="javascript/design.js"></script>
</body>
</html>