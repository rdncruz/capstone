<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="CSS/form.css">
    <link rel="stylesheet" href="https://maxst.icons8.com/vue-static/landings/line-awesome/line-awesome/1.3.0/css/line-awesome.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script src="https:code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <div class="form">
        <h2>Login Form</h2>
        <form action="">
            <div class="error-text">Error</div>
            <div class="input">
                <label>Email</label>
                <input type="email" name="email" placeholder="Enter Your Email" required>
            </div>
                <div class="input">
                    <label>Password</label>
                    <input type="password" name="pass" placeholder="Password" required>
                </div>
            <div class="submit">
                <input type="submit" value="Signup Now" class="button">
            </div>
        </form>
        <div class="link">Dont have account? <a href="register.php">Signup Now </a></div>
    </div>
    <script src="js/logins.js"></script>
</body>
</html>