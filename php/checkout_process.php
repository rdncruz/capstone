<?php
include_once 'config.php';
session_start();

// Check if the unique_id, orderProducts, and ref_id keys exist in the POST data
if (isset($_POST['unique_id'], $_POST['orderProducts'], $_POST['ref_id']) && is_array($_POST['orderProducts'])) {
    // Get unique_id, ref_id, and current date
    $unique_id = $_POST['unique_id'];
    $ref_id = $_POST['ref_id'];
    $current_date = date('Y-m-d');

    foreach ($_POST['orderProducts'] as $product) {
        // Check if the product_id and quantity keys exist in the current product array
        if (isset($product['product_id'], $product['quantity'])) {
            $product_id = $product['product_id'];
            $quantity = $product['quantity'];

            // Fetch the current price from the database based on product_id
            $fetch_price_query = "SELECT price FROM products WHERE product_id = '$product_id'";
            $result = mysqli_query($conn, $fetch_price_query);

            if ($result && $row = mysqli_fetch_assoc($result)) {
                $price = $row['price'];

                // Calculate the total price
                $total_price = $quantity * $price;

                // Insert data into the database with 'pending' status
                $insert_query = "INSERT INTO checkout (checkout_id, unique_id, product_id, quantity, price, order_date, status) 
                                VALUES ('$ref_id', '$unique_id', '$product_id', '$quantity', '$total_price', '$current_date', 'pending')";

                if (mysqli_query($conn, $insert_query)) {
                    // Remove the product from the cart
                    $delete_cart_query = "DELETE FROM cart WHERE unique_id = '$unique_id' AND product_id = '$product_id'";
                    if (!mysqli_query($conn, $delete_cart_query)) {
                        echo "Error deleting product from the cart: " . mysqli_error($conn) . "\n";
                    }

                    // Update product quantity in the products table
                
                        // Check if the quantity has reached zero
                        $check_quantity_query = "SELECT quantity FROM products WHERE product_id = '$product_id'";
                        $result_quantity = mysqli_query($conn, $check_quantity_query);

                        if ($result_quantity && $row_quantity = mysqli_fetch_assoc($result_quantity)) {
                            $remaining_quantity = $row_quantity['quantity'];

                            if ($remaining_quantity == 0) {
                                // Update product status to 'Out of stock'
                                $update_status_query = "UPDATE products SET status = 'Out of stock' WHERE product_id = '$product_id'";
                                if (!mysqli_query($conn, $update_status_query)) {
                                    echo "Error updating product status: " . mysqli_error($conn) . "\n";
                                }
                            }
                        } else {
                            echo "Error checking remaining product quantity: " . mysqli_error($conn) . "\n";
                        }
                    }

                    echo "Order placed successfully.";
                } else {
                    echo "Error inserting order into the database: " . mysqli_error($conn) . "\n";
                }
            } else {
                echo "Error fetching product price from the database.\n";
            }

    }

    // Close the database connection after the loop
    mysqli_close($conn);
} else {
    echo "Error: Invalid orderProducts data or ref_id not found.\n";
}
?>
