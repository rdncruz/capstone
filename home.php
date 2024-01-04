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
			<a href="user_profile.php" style="font-size: 30px;">
				<i class='bx bxs-cog' ></i>
			</a>
			<a href="#" class="profile">
				<img src="./image/<?php echo $row['img']; ?>" alt="">
			</a>
		</nav>
        <main>
        <section class="hero">
        <div class="containser">
            <div class="hero-content">
                <h2>Welcome to our Site</h2>
                <p id="p1" class="elementToFadeInAndOut">E-Fishing Supply Shop Management Information System in Bataan is your all-in-one solution for fishing supply sellers and fisheries in the region. For fishing supply sellers, our system simplifies the process of keeping track of inventory, sales, and engaging with customers. It's like having a personal assistant for your business, making your day-to-day operations smoother and more efficient.</p>
              
                <p id="p2" class="elementToFadeInAndOut">
                Fisheries in Bataan also benefit from our platform as it streamlines the procurement of supplies and manages the supply chain effectively. Moreover, we're committed to promoting sustainable practices in the fishing industry, helping fisheries make eco-friendly choices.
                </p>
              
                <p id="p3" class="elementToFadeInAndOut">
                What sets our system apart is that it's customized to fit your specific needs, ensuring it's a perfect match for your business. Plus, our team of experts is available round the clock to provide support and training, making sure you get the most out of the system. Together, we're building a stronger and more prosperous future for the fishing industry in Bataan, one that fosters efficiency and collaboration for both sellers and fisheries alike.
                </p>
           
            </div>
            <div class="hero-image">
                <img src="image/Orange_Minimalist_Fishing_Logo.png" alt="">
            </div>
        </div>
    </section>
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