<?php 
    session_start();
    include 'php/db.php';
    include './php/component.php';

    if (isset($_POST['remove'])) {
        if ($_GET['action'] == 'remove') {
            foreach ($_SESSION['cart'] as $key => $value) {
                if ($value['product_id'] == $_GET['id']) {
                    unset($_SESSION['cart'][$key]);
                    echo "<script>alert('Product has been Removed..!')</script>";
                    echo "<script>window.location='cart.php'</script>";
                }
            }
        }
    }
    
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cart</title>
    <!--font Awesome-->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/ZH/XLlvWZOJyj7Yy7tcenmpD1ypASozpmT/E0iPtmFIB46ZmdtAc9eNBvH0H/ZpiBw==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <!--Bootsrap CDN-->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-9ndCyUaIbzAi2FUVXJi0CjmCapSmO7SnpJef0486qhLnuZ2cdeRhO02iuK6FUUVM" crossorigin="anonymous">

    <link rel="stylesheet" href="./CSS/shopping.css">
</head>
<body class="bg-light">
    <?php require_once("php/header.php");?>

    <div class="container-fluid">
        <div class="row px-5">
            <div class="col-md-7">
                <div class="shopping-cart">
                    <h6>My cart</h6>
                    <hr>
                    <?php
                        $total = 0;
                        if(isset($_SESSION['cart'])) {
                            $sql = "SELECT * FROM products";
                            $product_id = array_column($_SESSION['cart'], 'product_id');
                            $result = mysqli_query($conn, $sql);
                            
                            while ($row = mysqli_fetch_assoc($result)) {
                                foreach ($product_id as $id) {
                                    if ($row['id'] == $id) {
                                        cartElement($row['image'], $row['name'], $row['price'], $row['id']);
                                        $total = $total + (int)$row['price'];
                                    }
                                }
                            } 
                        }
                        else {
                            echo "<h5>Cart is Empty</h5>";
                        }
                        
                    ?>
                </div>
            </div>
            <div class="col-md-4 offset-md-1 border rounded mt-5 bg-white h-25">
                <div class="pt-4">
                    <h6>PRICE DETAILS</h6>
                    <hr>
                    <div class="row price-details">
                        <div class="col-md-6">
                            <?php 
                                if(isset($_SESSION['cart'])) {
                                    $count = count($_SESSION['cart']);
                                    echo "<h6>Price($count items)</h6>";
                                }
                                else {
                                    echo "<h6>Price(0 items)</h6>";
                                }
                            ?>
                            <h6>Delivery Charges</h6>
                            <hr>
                            <h6>Amount Payable</h6>
                        </div>
                        <div class="col-md-6">
                            <h6>$<?php echo $total?></h6>
                            <h6 class="text-success">Free</h6>
                            <hr>
                            <h6>$<?php
                            echo $total;
                            ?></h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>



<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-geWF76RCwLtnZ8qwWowPQNguL3RmwHVBC9FhGdlKrxdiJJigb/j/68SIy3Te4Bkz" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.min.js" integrity="sha384-fbbOQedDUMZZ5KreZpsbe1LCZPVmfTnH7ois6mU1QK+m14rQ1l2bGBq41eYeM/fS" crossorigin="anonymous"></script>
</body>
</html>