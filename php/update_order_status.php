<?php
include_once "config.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $checkoutId = $_POST["checkout_id"];
    $status = $_POST["status"];

    // Update the order status
    $updateQuery = "UPDATE checkout SET status = '$status' WHERE checkout_id = '$checkoutId'";
    $result = mysqli_query($conn, $updateQuery);

    if ($result) {
        // If the status is 'Delivered', decrement the product quantity
        if ($status === 'Delivered') {
            $getQuantityQuery = "SELECT product_id, quantity FROM checkout WHERE checkout_id = '$checkoutId'";
            $quantityResult = mysqli_query($conn, $getQuantityQuery);

            if ($quantityResult) {
                $quantityData = mysqli_fetch_assoc($quantityResult);
                $productId = $quantityData['product_id'];
                $deliveredQuantity = $quantityData['quantity'];

                // Update the product quantity
                $updateProductQuantityQuery = "UPDATE products SET quantity = quantity - $deliveredQuantity WHERE product_id = '$productId'";
                mysqli_query($conn, $updateProductQuantityQuery);
            }
        }

        echo json_encode(['success' => true, 'message' => 'Order status updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update order status.']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request.']);
}
?>
