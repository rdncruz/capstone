<?php 
  session_start();
  include_once "php/config.php";
  if(!isset($_SESSION['id'])){
    
    header("location: seller_login.php");
  }
  $unique_id = $_SESSION['unique_id'];
  $sql = mysqli_query($conn, "SELECT * FROM seller WHERE unique_id = '{$unique_id}'");
    if (mysqli_num_rows($sql) > 0) {
        $row = mysqli_fetch_assoc($sql);
        if($row) {
            $_SESSION['verification_status'] = $row ['verification_status'];
            if($row['verification_status'] != 'Verified') {
                header("Location: seller_verify.php");
            }
        }
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Product</title>
    
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
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
<section id="sidebar">
    <a href="#" class="logo">
        <i class='bx bxs-smile'></i>
        <span class="text">Renz Daryl Cruz</span>
    </a>
    <ul class="sidebar-menu">
        <li>
            <a href="seller_center.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Newsfeed</span>
            </a>
        </li>
        <li class="active">
            <a href="product.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Product</span>
            </a>
        </li>
        <li>
            <a href="seller_inbox.php">
                <i class='bx bxs-dashboard'></i>
                <span class="text">Inbox</span>
            </a>
        </li>
        <li> 
            <?php 
            $sql = mysqli_query($conn, "SELECT * FROM seller WHERE unique_id = {$_SESSION['unique_id']}");
            if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
            }
            ?>
            <a href="php/logout.php?logout_id=<?php echo $row['unique_id']; ?>"> 
                <i class='bx bxs-dashboard'></i>
                <span class="text">Logout</span>
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
            <img src="img/people.png">
        </a>
    </nav>
    <main>
    <div class="head-title">
            <div class="left">
                <h1>Store</h1>
            </div>
            <a href="cart.php" class="btn-download">
                <i class='bx bxs-cart-add'></i>
                <?php 
                    if(isset($_SESSION['cart'])) {
                        $count = count($_SESSION['cart']);
                        echo "<span id=\"cart_count\" class=\"text-warning bg-light\">$count</span>";
                    } else {
                        echo "<span id=\"cart_count\" class=\"text-warning bg-light\">0</span>";
                    }
                ?>
            </a>
        </div>
        <div id="body">
            <div class="containerDetails">
                <div class="imgBx">
                    <img src="image/272158914_544367456520021_4850970752494959715_n.jpg" alt="Nike Jordan Proto-Lyte Image">
                </div>
                <div class="details">
                    <div class="content">
                        <h2>Jordan Proto-Lyte <br>
                            <span>Running Collection</span>
                        </h2>
                        <p>
                            Featuring soft foam cushioning and lightweight, woven fabric in the upper, the Jordan Proto-Lyte is
                            made for all-day, bouncy comfort.
                            Lightweight Breathability: Lightweight woven fabric with real or synthetic leather provides
                            breathable support.
                            Cushioned Comfort: A full-length foam midsole delivers lightweight, plush cushioning.
                            Secure Traction: Exaggerated herringbone-pattern outsole offers traction on a variety of surfaces.
                        </p>
                        <h3>Rs. 12,800</h3>
                        <button>Add to cart</button>
                    </div>
                </div>
            </div>
        </div>
    </main>
</section>
<script src="javascript/design.js"></script>
<script src="javascript/product.js"></script>
</body>
</html>