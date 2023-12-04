<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Seller Register</title>
    <link rel="stylesheet" href="css/logreg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

</head>
<body data-user-type="seller">
    <div class="wrapper">
        <section class="form signup">
            <header>Seller Registration</header>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <div class="name-details">
                    <input type="hidden" name="unique_id">
                    <input type="radio" name="user_type" id="seller" value="seller" style="display: none;" checked>
                    <div class="field input">
                        <label>First Name</label>
                        <input type="text" name="fname" placeholder="First name" required>
                    </div>
                    <div class="field input">
                        <label>Last Name</label>
                        <input type="text" name="lname" placeholder="Last name" required>
                    </div>
                </div>
                <div class="field input">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="username" required>
                </div>
                <div class="field input">
                    <label>Shop Name</label>
                    <input type="text" name="shop_name" placeholder="shop_name" required>
                </div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="text" name="email" placeholder="Enter your email" required>
                </div>
                <div class="field input">
                    <label>Address</label>
                 
                    <select id="address" name="address" required>
                        <option value="Bagac Bataan">Bagac</option>
                        <option value="Balanga Bataan">Balanga</option>
                        <option value="Dinalupihan Bataan">Dinalupihan</option>
                        <option value="Limay Bataan">Limay</option>
                        <option value="Mariveles Bataan">Mariveles</option>
                        <option value="Orani Bataan">Orani</option>
                        <option value="Pilar Bataan">Pilar</option>
                        <option value="Samat Bataan">Samat</option>
                    </select>
                    <button class="btn btn-primary load-map" id="get_map"><span class="glyphicon glyphicon-location"></span> Show Map</button>
                    <button class="btn btn-primary load-map" id="close-map" style="display:none;">Save Map</button>
                    
                </div>
                <div id="map-container">
               
                    <div id="coordinates" style="display:none" >Latitude: <span id="lat"></span>, Longitude: <span id="lng"></span></div>
                        <input type="hidden" name="lat" id="lat-input">
                        <input type="hidden" name="lng" id="lng-input">
                    
                    <div id="map" style="height:500px; display:none;"></div>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter new password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field input">
                    <label>Confirm Password</label>
                    <input type="password" name="cpassword" placeholder="Enter new password" required>
                    
                </div>
                <div class="field image">
                <label>Select Image</label>
                    <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                </div>
                <div class="field image">
                    <label>Certificate of Registration</label>
                    <input type="file" name="reg_image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Register">
                </div>
            </form>
            <div class="link">Already signed up? <a href="index.php">Login now</a></div>
        </section>
    </div>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/signup.js"></script>
    <script src="javascript/jquery-3.2.1.min.js"></script>
    <script src="javascript/map.js"></script>
   
	<script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBT7g_YV4I7cksILtC4ed1TfN7JIpJ8I3Q&callback=initMap" async defer></script>
	
	<script>
		var map;
        var marker;
		function initMap() {
            map = new google.maps.Map(document.getElementById('map'), {
                center: { lat:  14.492900, lng: 120.606867 },
                zoom: 15
            });

            marker = new google.maps.Marker({
            position: { lat:  14.492900, lng: 120.606867 },
            map: map,
            draggable: true // Make the marker draggable
        });

        // Add a dragend event listener to the marker to update the pin's coordinates
        marker.addListener('dragend', function () {
            updatePinCoordinates(marker.getPosition());
        });
        
        }
        function updatePinCoordinates(position) {
            var latSpan = document.getElementById('lat');
            var lngSpan = document.getElementById('lng');
            var latInput = document.getElementById('lat-input');
            var lngInput = document.getElementById('lng-input');

            latSpan.textContent = position.lat().toFixed(6);
            lngSpan.textContent = position.lng().toFixed(6);
            latInput.value = position.lat().toFixed(6);
            lngInput.value = position.lng().toFixed(6);
    }

        document.getElementById('get_map').addEventListener('click', function () {
        // Show the map container and the "Close Map" button
        document.getElementById('map-container').style.display = 'block';
        document.getElementById('coordinates').style.display = 'block';
        document.getElementById('get_map').style.display = 'none';
        document.getElementById('close-map').style.display = 'block';
    });

    document.getElementById('close-map').addEventListener('click', function () {
        document.getElementById('map-container').style.display = 'none';
        document.getElementById('get_map').style.display = 'block';
        document.getElementById('coordinates').style.display = 'none';
        document.getElementById('close-map').style.display = 'none';
    });
    function googleMapsError() {
    var errorContainer = document.getElementById('map-error-message');
    if (errorContainer) {
        errorContainer.style.display = 'block';
        errorContainer.textContent = "Google Maps failed to load. Please try again later.";
    }
}
	</script>
</body>
</html>