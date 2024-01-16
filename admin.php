
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>Admin</title>
    <link rel="stylesheet" href="css/logreg.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
</head>
<body data-user-type="admins">
    <div class="wrapper">
        <section class="form login">
            <header>Administrator</header>
            <form action="#" method="POST" enctype="multipart/form-data" autocomplete="off">
                <div class="error-text"></div>
                <input type="hidden" name="email">
                <div class="field input">
                    <label>Username</label>
                    <input type="text" name="username" placeholder="Enter your username" required>
                </div>
                <div class="field input">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="Enter your password" required>
                    <i class="fas fa-eye"></i>
                </div>
                <input type="radio" name="user_type" id="admins" value="admins" style="display: none;" checked>
                <div class="field button">
                    <input type="submit" name="submit" value="Login">
                </div>
            </form>
        </section>
    </div>
<script src="javascript/pass-show-hide.js"></script>
<script src="javascript/login.js"></script>
</body>
</html>
