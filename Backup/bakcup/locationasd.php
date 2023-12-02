<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    
    header("location: index.php");
  }
  $unique_id = $_SESSION['unique_id'];
  $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
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
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Location</title>
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    <link rel="stylesheet" href="css/style.css">
    <script src="https://maps.googleapis.com/maps/api/js?sensor=false&callback=myMap"></script>

</head>
<body onload="showMap()">
<section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-store'></i>
            <span class="text">Renz Daryl Cruz</span>
        </a>
        <ul class="sidebar-menu">
            <li>
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
            <div id="map" style="height:500px;"></div>

        </main>
    </section>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBT7g_YV4I7cksILtC4ed1TfN7JIpJ8I3Q&callback=initMap" async defer></script>

	
	<script>
		var map;
        var marker;
      
		
        function initMap() {
            var map = new google.maps.Map(document.getElementById('map'), {
                center: { lat: 14.4929, lng: 120.5049 },
                zoom: 11
            });
        }

       


	</script>
	<script src="javascript/design.js"></script>

</body>
</html>