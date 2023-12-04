<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uniqueId = $_POST['uniqueId'];
    $productId = $_POST['productId'];
    $rating = $_POST['rating'];
    $comment = $_POST['comment'];

    // Add your validation and sanitization code here if needed

    // Insert data into the database
    $query = "INSERT INTO review (unique_id, product_id, rating, description, review_date) 
              VALUES ('$uniqueId', '$productId', '$rating', '$comment', NOW())";
    
    if (mysqli_query($conn, $query)) {
        // Rating submitted successfully
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
