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
  <title>Inbox</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  
  <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
  <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    
 
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">
  
  <link rel="stylesheet" href="css/style.css">
  <style>
    #map {
            height: 400px;
        }
    .img-account-profile {
    height: 10rem;
}
.rounded-circle {
    border-radius: 50% !important;
    
}

  </style>
</head>     
<body data-user-type="seller">
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
      <li>
                <a href="dashboard.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
      <li>
        <a href="seller_inbox.php">
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
          <span class="text">Logout</span>
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
      <a href="user_profile.php" style="font-size: 30px;">
				<i class='bx bxs-cog' ></i>
			</a>
      <a href="#" class="profile">
        <img src="./image/<?php echo $row['img']; ?>" alt="">
      </a>
    </nav>
    <main>
      <div class="container-xl px-4 mt-4">
        <hr class="mt-0 mb-4">
        <div class="row">
            <div class="col-xl-4">
                <div class="card mb-4 mb-xl-0" style="width: 70%; margin-left: 25%;">
                    <div class="card-header">Profile Picture</div>
                    <div class="card-body text-center">
                      <img class="img-account-profile rounded-circle mb-2" id="profileImage" src="./image/<?php echo $row['img']; ?>" alt="Profile Picture" style="height: 25vh;">
                      <div class="small font-italic text-muted mb-4">JPG or PNG no larger than 5 MB</div>
                      <input type="file" class="form-control-file" id="fileInput" style="display: none;" onchange="displayImage(this);">
                      <label for="fileInput" class="btn btn-primary">Upload new image</label>
                  </div>
                </div>
            </div>
            <div class="col-xl-8">
                <div class="card mb-4">
                    <div class="card-header">Account Details</div>
                    <div class="card-body">
                      <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                            <div class="mb-3">
                                <label class="small mb-1" for="username">Username</label>
                                <input class="form-control" id="username" type="text" placeholder="" value="<?php echo $row['username']; ?>">
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="fname">First Name</label>
                                    <input class="form-control" id="fname" type="text" placeholder="" value="<?php echo $row['fname']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="lname">Last nName</label>
                                    <input class="form-control" id="lname" type="text" placeholder="" value="<?php echo $row['lname']; ?>">
                                </div>
                            </div>
                            <div class="row gx-3 mb-3">
                                <div class="col-md-6">
                                    <label class="small mb-1" for="email">Email Address</label>
                                    <input class="form-control" id="email" type="email" placeholder="" value="<?php echo $row['email']; ?>">
                                </div>
                                <div class="col-md-6">
                                    <label class="small mb-1" for="address">City</label>
                                    <input class="form-control" id="address" type="text" placeholder="" value="<?php echo $row['address']; ?>">
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="password">Current Password</label>
                                <input class="form-control" id="password" type="password" placeholder="Enter your current password">
                            </div>
                            <div class="mb-3">
                                <label class="small mb-1" for="newPassword">New Password</label>
                                <input class="form-control" id="newPassword" type="password" placeholder="Enter your new password">
                            </div>
                            <button class="btn btn-primary" type="button" id="saveChangesBtn">Save Changes</button>
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="shipto">
                                <label class="custom-control-label" for="shipto"  data-toggle="collapse" data-target="#shipping-address">View Your Location</label>
                            </div>
                            <div class="collapse mb-5" id="shipping-address">
                              
                            <div id="map"></div>
                        </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
      </div>

    </main>
  </section>
	<script src="javascript/design.js"></script>
  <script src="https://code.jquery.com/jquery-3.4.1.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.bundle.min.js"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBT7g_YV4I7cksILtC4ed1TfN7JIpJ8I3Q&callback=initMap" async defer></script>
  
    
    <?php
// Get the user's location from the database (assuming you have latitude and longitude columns)
    $sql_location = mysqli_query($conn, "SELECT lat, lng FROM location WHERE unique_id = '{$unique_id}'");
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

<!-- ... your HTML code ... -->

<script>
    var map;
    var markers = [];

    function initMap() {
        console.log("Map initialized");  // Add this line for debugging

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
            },
            draggable: true  // Make the marker draggable
        });

        // Event listener for dragend event of the marker
        userMarker.addListener('dragend', function(event) {
            var updatedLat = event.latLng.lat();
            var updatedLng = event.latLng.lng();

            // Send the updated location to the server (you may use AJAX for this)
            updateLocation(updatedLat, updatedLng);
        });
    }

    // Function to update the user's location on the server
    function updateLocation(lat, lng) {
        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/update_location.php', true);

        // Send the latitude and longitude as parameters
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        var params = 'lat=' + lat + '&lng=' + lng;
        xhr.send(params);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    console.log('Location updated successfully!');
                } else {
                    console.log('Failed to update location. Please try again.');
                }
            }
        };
    }
</script>

<!-- ... your remaining HTML code ... -->

  <script>
function displayImage(input) {
    var profileImage = document.getElementById('profileImage');
    
    if (input.files && input.files[0]) {
        var reader = new FileReader();

        reader.onload = function (e) {
            profileImage.setAttribute('src', e.target.result);
        };

        reader.readAsDataURL(input.files[0]);
    }
}
</script>
<script>
document.addEventListener("DOMContentLoaded", function () {
    document.getElementById("saveChangesBtn").addEventListener("click", function () {
        updateUserProfile();
    });

    function updateUserProfile() {
        var username = document.getElementById('username').value.trim();
        var fname = document.getElementById('fname').value.trim();
        var lname = document.getElementById('lname').value.trim();
        var email = document.getElementById('email').value.trim();
        var address = document.getElementById('address').value.trim();
        var password = document.getElementById('password').value.trim();
        var newPassword = document.getElementById('newPassword').value.trim(); // Corrected variable name

        var formData = new FormData();
        formData.append('username', username);
        formData.append('fname', fname);
        formData.append('lname', lname);
        formData.append('email', email);
        formData.append('address', address);
        formData.append('password', password);
        formData.append('newPassword', newPassword);  // Corrected variable name
        // Append more fields if needed

        var fileInput = document.getElementById('fileInput');
        if (fileInput.files.length > 0) {
            formData.append('image', fileInput.files[0]);
        }

        var xhr = new XMLHttpRequest();
        xhr.open('POST', 'php/update_profile.php', true);

        xhr.onload = function () {
            if (xhr.status === 200) {
                var response = JSON.parse(xhr.responseText);
                if (response.status === 'success') {
                    alert('Profile updated successfully!');
                    // Reload the page after successful update
                    location.reload();
                } else {
                    alert('Failed to update profile. Please try again.');
                }
            }
        };

        xhr.send(formData);
    }
});

</script>
</body>
</html>