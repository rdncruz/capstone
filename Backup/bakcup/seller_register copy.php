<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['unique_id'])){
    header("location: index.php");
    exit(); // Exit to prevent further execution
  }
  $unique_id = $_SESSION['unique_id'];
  $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        if($row) {
            $_SESSION['verification_status'] = $row ['verification_status'];
            if($row['verification_status'] != 'Verified') {
                header("Location: user_verify.php");
            }
        }
    }
  
  // Define variables to store user information
  $fname = $lname = $email = $address = "";

  // Fetch user data from the database
  $sql = "SELECT fname, lname, address, email FROM users WHERE unique_id = ?";
  $stmt = $conn->prepare($sql);
  $stmt->bind_param("s", $unique_id);
  $stmt->execute();
  $result = $stmt->get_result();

  if ($result->num_rows > 0) {
      $row = $result->fetch_assoc();
      $fname = $row['fname'];
      $lname = $row['lname'];
      $email = $row['email'];
      $address = $row['address'];
  }

  $stmt->close();
  $conn->close();
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
                    <input type="hidden" name="username">
                    <input type="hidden" name="unique_id" value="<?php echo $unique_id; ?>">
                    <input type="radio" name="user_type" id="seller" value="seller" style="display: none;" checked>
                    <div class="field input">
                        <label>First Name</label>
                        <input type="text" name="fname" placeholder="First name" required value="<?php echo $fname; ?>">
                    </div>
                    <div class="field input">
                        <label>Last Name</label>
                        <input type="text" name="lname" placeholder="Last name" required value="<?php echo $lname; ?>">
                    </div>
                </div>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="text" name="email" placeholder="Enter your email" required value="<?php echo $email; ?>">
                </div>
                <div class="field input">
                    <label>Address</label>
                    <input type="text" name="address" placeholder="Enter your address" required value="<?php echo $address; ?>">
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
                    <label>Certificate of Registration</label>
                    <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Register">
                </div>
            </form>
            <div class="link">Already signed up? <a href="login.php">Login now</a></div>
        </section>
    </div>
    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/signup.js"></script>
</body>
</html>