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
    <title>Seller Center</title>
    
    <link href='https://unpkg.com/boxicons@2.1.4/css/boxicons.min.css' rel='stylesheet'>
    
    <!-- Override Bootstrap's container padding -->
    <style>
       
        #sidebar .sidebar-menu {
            margin-top: 1;
            padding: 0;
        }
    </style>
    <!-- Include the Bootstrap stylesheet -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href='https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css' rel='stylesheet'>
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link rel="stylesheet" href="css/stylenf.css" />
    <link rel="stylesheet" href="css/style.css">
</header>
<body data-user-type="users">
    <section id="sidebar">
        <a href="#" class="logo">
            <i class='bx bxs-store'></i>
            <span class="text"><?php echo $row['username']; ?></span>
        </a>
        <ul class="sidebar-menu">
            <li>
                <a href="seller_dashboard.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Dashboard</span>
                </a>
            </li>
            <li class="active">
                <a href="seller_newsfeed.php">
                    <i class='bx bx-home' ></i>
                    <span class="text">Newsfeed</span>
                </a>
            </li>
            <li>
                <a href="product.php?<?php echo $row['unique_id']; ?>">
                    <i class='bx bx-cart-add' ></i>
                    <span class="text">Product</span>
                </a>
            </li>
            <li>
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
                    <span class="text">Logout</span></a>
                </a>
            </li>
        </ul>
    </section>

    <section id="container">
        <nav class="custom-nav">
			<i class='bx bx-menu' ></i>
		
			<form action="#">
				<div class="form-input">
					<!---->
				</div>
			</form>
			<input type="checkbox" id="switch-mode" hidden>
			<label for="switch-mode" class="switch-mode"></label>
			<a href="#" class="notification">
				<i class='bx bxs-bell' ></i>
				<span class="num">8</span>
			</a>
			<a href="#" class="profile">
                <img src="./image/<?php echo $row['img']; ?>" alt="">
			</a>
		</nav>
        <main>
        <main>
          <div class="newsfeed">
            <div class="wrapper">
              <section class="post">
                <header>Create Post</header>
                <form id="postForm" action="php/add_post.php" method="POST" enctype="multipart/form-data">

                  <div class="content">
                  <img src="./image/<?php echo $row['img']; ?>" alt="">
                    <div class="details">
                      <p><?php echo $row['shop_name']?></p>
                      
                    </div>
                  </div>
                  <textarea placeholder="What's on your mind, <?php echo $row['shop_name']?>" spellcheck="false" name="content" required ></textarea>
                  <div class="options">
                    <p>Add to Your Post</p>
                    <ul class="list">
                    
                    <input type="file" name="image" accept="image/x-png,image/gif,image/jpeg,image/jpg" required>

                    </ul>
                  </div>
                  <input type="hidden" name="username" value="<?php echo $row['username']; ?>">
                  <input type="hidden" name="user_id" value="<?php echo $row['unique_id']; ?>">
                  <button type="submit" name="add_to_newsfeed"> Post</button>
                </form>
              </section>
            </div>
          </div>
          
         
          <?php
// Assuming you have established a database connection

// Fetch post details from the database (replace with your actual SQL query)
$sql = "SELECT * FROM posting"; // Modify the query accordingly
$result = mysqli_query($conn, $sql);

if ($result && mysqli_num_rows($result) > 0) {
    while ($post = mysqli_fetch_assoc($result)) {
?>
        <div class="card post">
            <div class="post-header">
                <div class="post-author-info">
                    <img src="./image/<?php echo $row['img']?>" />
                    <div>
                        <div>
                            <span class="author-name"><?php echo $post['username']; ?></span>
                            <i class="verified-icon"></i>
                        </div>
                        <div class="details">
                            <span><?php echo $post['date']; ?></span>
                            <span> · </span>
                            <i class="post-settings-icon"></i>
                        </div>
                    </div>
                </div>
                <i class="post-menu-icon"></i>
            </div>
            <p class="post-body"><?php echo $post['content']; ?></p>
            <a class="post-image">
                <img src="./image/<?php echo $post['img']; ?>" />
                <div class="excerpt">
                    <!-- Add additional details as needed -->
                    <div class="post-info-icon-wrap">
                        <i class="post-info-icon"></i>
                    </div>
                </div>
            </a>
            <!-- Rest of the HTML code remains unchanged -->
        </div>
<?php
    }
} else {
    echo "No posts found.";
}

// Close the database connection
mysqli_close($conn);
?>

      

        </main>
    </section>
	<script src="javascript/design.js"></script>
</body>
</html>