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
            if ($row['role'] === 'admin') {
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
    <title>Admin Register</title>
    
    <link rel="stylesheet" href="css/logreg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>

</head>
<body data-user-type="admin">
    <div class="wrapper">
        <section class="form signup">
            <header>Consumer Registration</header>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <input type="hidden" name="address">
                <input type="hidden" name="fname">
                <input type="hidden" name="lname">
                <input type="radio" name="user_type" id="admin=" value="admin" style="display: none;" checked>
                <div class="field input">
                    <label>Email</label>
                    <input type="text" name="email" placeholder="email" required>
                </div>
                <div class="field input">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter your Username" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter new password" required>
                    <i class="fas fa-eye"></i>
                </div>
                
                <div class="field button">
                    <input type="submit" name="submit" value="Continue to Chat">
                </div>
            </form>
            <div class="link">Already signed up? <a href="index.php">Login now</a></div>
        </section>
    </div>
<script src="javascript/pass-show-hide.js"></script>
<script src="javascript/signup.js"></script>
</body>
</html>