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
            if ($row['role'] === 'user') {
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
  <title>Chat</title>
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
<body>
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
      <li class="active">
        <a href="inbox.php">
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
          <span class="text">Logout</span></a>
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
      
      <a href="#" class="profile">
        <img src="./image/<?php echo $row['img']; ?>" alt="">
      </a>
    </nav>
    <main>
      <div class="wrapper">
        <section class="chat-area">
          <header>
            <?php 
              $user_id = mysqli_real_escape_string($conn, $_GET['user_id']);
              $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = {$user_id}");
              if(mysqli_num_rows($sql) > 0) {
                $row = mysqli_fetch_assoc($sql);
              } 
              else  {
                header("location: users.php");
              }
            ?>
            <a href="inbox.php" class="back-icon"><i class="fas fa-arrow-left"></i></a>
            <img src="./image/<?php echo $row['img']; ?>" alt="">
            <div class="details">
              <span><?php echo $row['fname']. " " . $row['lname'] ?></span>
              <p><?php echo $row['status']; ?></p>
            </div>
          </header>
          <div class="chat-box">

          </div>
          <form action="#" class="typing-area">
            <input type="text" class="incoming_id" name="incoming_id" value="<?php echo $user_id; ?>" hidden>
            <input type="text" name="message" class="input-field" placeholder="Type a message here..." autocomplete="off">
            <button><i class="fab fa-telegram-plane"></i></button>
          </form>
        </section>
      </div>
    </main>
  </section>
	<script src="javascript/design.js"></script>
  <script src="javascript/chat.js"></script>
</body>
</html>