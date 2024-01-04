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
  <title>Seller Inbox</title>
  <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.2/css/all.min.css"/>
  <link rel="stylesheet" href="css/style.css">

  <style>
    .wrapper{
    background: #fff;
    max-width: 100%;
    width: 100%;
    border-radius: 16px;
    box-shadow: 0 0 128px 0 rgba(0,0,0,0.1),
                0 32px 64px -48px rgba(0,0,0,0.5);
  }
  </style>
</head>     
<body data-user-type="users">
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
        <a href="product.php">
          <i class='bx bx-cart-add' ></i>
          <span class="text">Product</span>
        </a>
      </li>
      <li class="active">
        <a href="seller_inbox.php">
          <i class='bx bx-conversation'></i>
          <span class="text">Inbox</span>
        </a>
      </li>
      <li>
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
      <a href="seller_profile.php" style="font-size: 30px;">
				<i class='bx bxs-cog' ></i>
			</a>
      <a href="#" class="profile">
        <img src="./image/<?php echo $row['img']; ?>" alt="">
      </a>
    </nav>
      <main>
        <div class="wrapper">
          <section class="users">
            <header>
              <div class="content">
                  <input type="radio" name="user_type" id="users" value="users" style="display: none;" checked>
                <img src="image/<?php echo $row['img']; ?>" alt="">
                <div class="details">
                  <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
                  <p><?php echo $row['status']; ?></p>
                </div>
              </div>
            </header>
            <div class="search">
              <span class="text">Select a user to start chat</span>
              <input type="text" placeholder="Enter a name to search...">
              <button><i class="fas fa-search"></i></button>
            </div>
            <div class="users-list">
              <!-- User list content goes here -->
            </div>
          </section>
        </div>
      </main>
  </section>
  <script src="javascript/design.js"></script>
  <script src="javascript/script.js"></script>
  <script src="javascript/inbox.js"></script>
</body>
</html>
