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
                header("Location: user_verify.php");
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
    <title>Seller Login</title>
    <link rel="stylesheet" href="css/logreg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body data-user-type="seller">
    <div class="wrapper">
        <section class="form login">
            <header>Seller Center</header>
            <div class="buttons">
                <input type="button" id="btnUser" value="User" style="float: left;" onclick="navigateToUserPage()">
                <input type="button" value="Seller" onclick="navigateToSellerPage()">
            </div>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <input type="hidden" name="username">
                <input type="radio" name="user_type" id="seller" value="seller" style="display: none;" checked>
                <div class="field input">
                    <label>Email Address</label>
                    <input type="text" name="email" placeholder="Enter your email" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <div class="field button">
                    <input type="submit" name="submit" value="Login">
                </div>
            </form>
            <?php 
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$_SESSION['unique_id']}");
                if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
                }
            ?>
            <div class="link">Not yet signed up? <a href="seller_register.php?<?php echo $row['unique_id']; ?>">Signup now</a></div>
        </section>
    </div>
    <script src="javascript/pass-show-hide.js"></script>
    <script src="javascript/login.js"></script>
    <script>
        function navigateToUserPage() {
            window.location.href = "index.php";
        }

        function navigateToSellerPage() {
            window.location.href = "seller_login.php";
        }
    </script>
</body>
</html>
