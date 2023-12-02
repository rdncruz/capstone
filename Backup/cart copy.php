<?php 
    session_start();
    include 'php/config.php';
    include './php/product.php';

    if (isset($_POST['product_id'], $_POST['quantity']) && is_numeric($_POST['product_id']) && is_numeric($_POST['quantity'])) {
        // Set the post variables so we easily identify them, also make sure they are integer
        $product_id = (int)$_POST['product_id'];
        $quantity = (int)$_POST['quantity'];
        // Prepare the SQL statement, we basically are checking if the product exists in our databaser
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id = ?');
        $stmt->execute([$_POST['product_id']]);
        // Fetch the product from the database and return the result as an Array
        $product = $stmt->fetch(PDO::FETCH_ASSOC);
        // Check if the product exists (array is not empty)
        if ($product && $quantity > 0) {
            // Product exists in database, now we can create/update the session variable for the cart
            if (isset($_SESSION['cart']) && is_array($_SESSION['cart'])) {
                if (array_key_exists($product_id, $_SESSION['cart'])) {
                    // Product exists in cart so just update the quanity
                    $_SESSION['cart'][$product_id] += $quantity;
                } else {
                    // Product is not in cart so add it
                    $_SESSION['cart'][$product_id] = $quantity;
                }
            } else {
                // There are no products in cart, this will add the first product to cart
                $_SESSION['cart'] = array($product_id => $quantity);
            }
        }
        // Prevent form resubmission...
        header('location: index.php?page=cart');
        exit;
    }
    
    if (isset($_GET['remove']) && is_numeric($_GET['remove']) && isset($_SESSION['cart']) && isset($_SESSION['cart'][$_GET['remove']])) {
        // Remove the product from the shopping cart
        unset($_SESSION['cart'][$_GET['remove']]);
    }
    
    if (isset($_POST['update']) && isset($_SESSION['cart'])) {
        // Loop through the post data so we can update the quantities for every product in cart
        foreach ($_POST as $k => $v) {
            if (strpos($k, 'quantity') !== false && is_numeric($v)) {
                $id = str_replace('quantity-', '', $k);
                $quantity = (int)$v;
                // Always do checks and validation
                if (is_numeric($id) && isset($_SESSION['cart'][$id]) && $quantity > 0) {
                    // Update new quantity
                    $_SESSION['cart'][$id] = $quantity;
                }
            }
        }
        // Prevent form resubmission...
        header('location: index.php?page=cart');
        exit;
    }
    
    if (isset($_POST['placeorder']) && isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        header('Location: index.php?page=placeorder');
        exit;
    }
    
    $products_in_cart = isset($_SESSION['cart']) ? $_SESSION['cart'] : array();
    $products = array();
    $subtotal = 0.00;
    // If there are products in cart
    if ($products_in_cart) {
        // There are products in the cart so we need to select those products from the database
        // Products in cart array to question mark string array, we need the SQL statement to include IN (?,?,?,...etc)
        $array_to_question_marks = implode(',', array_fill(0, count($products_in_cart), '?'));
        $stmt = $pdo->prepare('SELECT * FROM products WHERE id IN (' . $array_to_question_marks . ')');
        // We only need the array keys, not the values, the keys are the id's of the products
        $stmt->execute(array_keys($products_in_cart));
        // Fetch the products from the database and return the result as an Array
        $products = $stmt->fetchAll(PDO::FETCH_ASSOC);
        // Calculate the subtotal
        foreach ($products as $product) {
            $subtotal += (float)$product['price'] * (int)$products_in_cart[$product['id']];
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
$(document).ready(function() {
    $(".decrement-quantity").click(function() {
        updateQuantityAndTotalPrice(this, -1);
    });

    $(".increment-quantity").click(function() {
        updateQuantityAndTotalPrice(this, 1);
    });

    $(".quantity-input").on('input', function() {
        updateTotalPrice($(this));
    });

    function updateQuantityAndTotalPrice(button, change) {
        var item = $(button).closest(".cart-items");
        var quantityInput = item.find(".quantity-input");
        var quantity = parseInt(quantityInput.val()) + change;

        if (quantity < 1) {
            quantity = 1;
        }

        quantityInput.val(quantity);
        updateTotalPrice(quantityInput);
    }

    function updateTotalPrice(input) {
        var quantity = parseInt(input.val());
        var pricePerItem = parseFloat(input.closest(".cart-items").find(".product-price").data("price"));
        var totalPrice = quantity * pricePerItem;

        input.closest(".cart-items").find(".total-price").text("$" + totalPrice.toFixed(2));
    }
});
</script>


</body>
</html>