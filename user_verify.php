<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>seller Verify</title>
    <link rel="stylesheet" href="css/logreg.css">
</head>
<body data-user-type="users">
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <div class="wrapper">
        <div class="form" style="text-align: center;">
            <h2>Verify Your Account</h2>
            <p>We emailed you the four digit otp code to Enter the code below to confirm your email address..</p>
            <form action="php/otp.php" method="post" autocomplete="off">
                <div class="error-text">Error</div>
                <div class="fields-input">
                    <input type="number" name="otp1" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                    <input type="number" name="otp2" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                    <input type="number" name="otp3" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                    <input type="number" name="otp4" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                </div>
                <input type="radio" name="user_type" id="users" value="users" style="display: none;" checked>
                <div class="field button">
                    <input type="submit" name="submit" value="Enter">
                </div>
            </form>
        </div>
    </div>
    <script src="javascript/user_verification.js"></script>
</body>
</html>