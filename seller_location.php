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
    $query = "SELECT unique_id, username, address, email, status FROM users WHERE role = 'user'";
    $query_run = mysqli_query($conn, $query);
    
    if (mysqli_num_rows($query_run) > 0) {
        while ($user = mysqli_fetch_assoc($query_run)) {
            // Fetch the lat and lng from the location table based on unique_id
            $location_query = "SELECT lat, lng FROM location WHERE unique_id = '{$user['unique_id']}'";
            $location_result = mysqli_query($conn, $location_query);
    
            if (mysqli_num_rows($location_result) > 0) {
                $location_data = mysqli_fetch_assoc($location_result);
                $user['lat'] = $location_data['lat'];
                $user['lng'] = $location_data['lng'];
            }
    
            $users[] = $user;
        }
    }
    
    $userLocationQuery = "SELECT lat, lng FROM location WHERE unique_id = '{$unique_id}'";
    $userLocationResult = mysqli_query($conn, $userLocationQuery);
    
    if (mysqli_num_rows($userLocationResult) > 0) {
        $userLocationData = mysqli_fetch_assoc($userLocationResult);
        $userLat = $userLocationData['lat'];
        $userLng = $userLocationData['lng'];
    } else {
        // Set a default location if user location data is not found
        $userLat = 0;
        $userLng = 0;
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

    <style>
        #map {
            height: 400px;
        }
        .table-responsive {
            margin: 30px 0;
        }

        .table-wrapper {
            background: #fff;
            padding: 20px 25px;
            border-radius: 3px;
            min-width: 1000px;
            box-shadow: 0 1px 1px rgba(0, 0, 0, .05);
        }

        .table-title {
            padding-bottom: 15px;
            background: #435d7d;
            color: #fff;
            padding: 16px 30px;
            min-width: 100%;
            margin: -20px -25px 10px;
            border-radius: 3px 3px 0 0;
        }

        .table-title h2 {
            margin: 5px 0 0;
            font-size: 24px;
        }

        .table-title .btn-group {
            float: right;
        }

        .table-title .btn {
            color: #fff;
            float: right;
            font-size: 13px;
            border: none;
            min-width: 50px;
            border-radius: 2px;
            border: none;
            outline: none !important;
            margin-left: 10px;
        }

        .table-title .btn i {
            float: left;
            font-size: 21px;
            margin-right: 5px;
        }

        .table-title .btn span {
            float: left;
            margin-top: 2px;
        }

        table.table tr th,
        table.table tr td {
            border-color: #e9e9e9;
            padding: 12px 15px;
            vertical-align: middle;
        }

        table.table tr th:first-child {
            width: 250px;
        }

        table.table tr th:last-child {
            width: 250px;
        }

        table.table-striped tbody tr:nth-of-type(odd) {
            background-color: #fcfcfc;
        }

        table.table-striped.table-hover tbody tr:hover {
            background: #f5f5f5;
        }

        table.table th i {
            font-size: 13px;
            margin: 0 5px;
            cursor: pointer;
        }

        table.table td:last-child i {
            opacity: 0.9;
            font-size: 22px;
            margin: 0 5px;
        }

        table.table td a {
            font-weight: bold;
            color: #566787;
            display: inline-block;
            text-decoration: none;
            outline: none !important;
        }

        table.table td a:hover {
            color: #2196F3;
        }

        table.table td a.edit {
            color: #FFC107;
        }

        table.table td a.delete {
            color: #F44336;
        }

        table.table td i {
            font-size: 19px;
        }

        table.table .avatar {
            border-radius: 50%;
            vertical-align: middle;
            margin-right: 10px;
        }
    </style>
</head>
<body>
<section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-store'></i>
            <span class="text"><?php echo $row['shop_name']; ?></span>
        </a>
        <ul class="sidebar-menu">
        <li>
                <a href="seller_dashboard.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="seller_newsfeed.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Newsfeed</span>
                </a>
            </li>
            <li>
                <a href="product.php?<?php echo $row['unique_id']; ?>">
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
            <li class="active">
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
			<a href="seller_profile.php" style="font-size: 30px;">
				<i class='bx bxs-cog' ></i>
			</a>
			<a href="#" class="profile">
                <img src="./image/<?php echo $row['img']; ?>" alt="">
			</a>
		</nav>
        <main>
        <div id="map"></div>
        <div class="container-xl">
        <div class="table-responsive">
            <div class="table-wrapper">
                <div class="table-title">

                    <div class="row">
                        <div class="col-sm-6">
                            <h2>List of <b>users</b></h2>
                        </div>
                    </div>
                </div>
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Shop Name</th>
                            <th>Email</th>
                            <th>Address</th>
                            <th>Distance</th>
                            <th>Status</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        foreach ($users as $user) {
                            // Check if 'lat' and 'lng' keys exist in the user array
                            if (isset($user['lat']) && isset($user['lng'])) {
                                $userLocation = [$userLat, $userLng];
                                $userSeller = [$user['lat'], $user['lng']];
                                $distance = calculateDistance($userLocation, $userSeller);
                            } else {
                                // Set a default value for distance if 'lat' and 'lng' keys are missing
                                $distance = 'N/A';
                            }
                            ?>
                            <tr>
                                <td><?= $user['username'] ?></td>
                                <td><?= $user['email'] ?></td>
                                <td><?= $user['address'] ?></td>
                                <td><?= $distance ?> km</td>
                                <td><?= $user['status'] ?></td>
                                <!-- Add actions or other user information here -->
                            </tr>
                            <?php
                        }
                        ?>

                    </tbody>
                </table>
            </div>
        </div>
    </div>
     
        
        </main>
    </section>
	<script src="javascript/design.js"></script>
    <?php
    // Function to calculate the distance between two sets of coordinates
    function calculateDistance($point1, $point2) {
        $theta = $point1[1] - $point2[1];
        $dist = sin(deg2rad($point1[0])) * sin(deg2rad($point2[0])) +  cos(deg2rad($point1[0])) * cos(deg2rad($point2[0])) * cos(deg2rad($theta));
        $dist = acos($dist);
        $dist = rad2deg($dist);
        $miles = $dist * 60 * 1.1515;
        return round($miles * 1.60934, 2); // Convert miles to kilometers and round to 2 decimal places
    }
    ?>
    
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBT7g_YV4I7cksILtC4ed1TfN7JIpJ8I3Q&libraries=geometry&callback=initMap" async defer></script>
  
    
    <script>
    var map;
    var markers = [];

    function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
            center: { lat: <?php echo $userLat; ?>, lng: <?php echo $userLng; ?> },
            zoom: 12.5
        });

        // Add a custom icon for the user's location marker
        var userMarker = new google.maps.Marker({
            position: { lat: <?php echo $userLat; ?>, lng: <?php echo $userLng; ?> },
            map: map,
            title: 'Your Location',
            icon: {
                url: 'http://maps.google.com/mapfiles/ms/icons/green-dot.png', // Set the URL of the custom icon
            }
        });

        markers.push(userMarker);

        // Fetched user data, including lat and lng, from the PHP code
        var users = <?php echo json_encode($users); ?>;

        users.forEach(function (user) {
            var marker = new google.maps.Marker({
                position: { lat: parseFloat(user.lat), lng: parseFloat(user.lng) },
                map: map,
                title: user.username, // Assuming you want to display the username as the title
            });

            markers.push(marker);
        });

        updateDistance();
    }
</script>


</body>
</html>