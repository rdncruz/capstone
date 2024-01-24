<?php
// update_order_status.php

require_once 'config.php'; // Update the path as needed

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $checkoutId = $_POST['checkout_id'];
    $status = $_POST['status'];

    // Perform the update in the database
    $updateQuery = "UPDATE checkout SET status = '$status' WHERE checkout_id = '$checkoutId'";
    $updateResult = mysqli_query($conn, $updateQuery);

    if ($updateResult) {
        echo json_encode(['success' => true, 'message' => 'Order status updated successfully']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update order status']);
    }
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request']);
}
?>
