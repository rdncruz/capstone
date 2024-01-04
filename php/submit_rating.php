<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uniqueId = $_POST['uniqueId'];
    $checkout_id = $_POST['checkoutId'];
    $productId = $_POST['productId'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Add your validation and sanitization code here if needed

    // Insert data into the database
    $query = "INSERT INTO review (unique_id, product_id, rating, description, review_date) 
              VALUES ('$uniqueId', '$productId', '$rating', '$comment', NOW())";
    
    if (mysqli_query($conn, $query)) {
        // Rating submitted successfully
        $updateStatusQuery = "UPDATE checkout SET status = 'Completed' WHERE checkout_id = '$checkout_id' AND product_id = '$productId'";
        mysqli_query($conn, $updateStatusQuery);
        echo "success";
    } else {
        // Error in the database query
        echo "error: " . mysqli_error($conn);
    }
} else {
    // Invalid request method
    echo "Invalid request!";
}
?>
