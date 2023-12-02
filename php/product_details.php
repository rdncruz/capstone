<?php
require 'config.php';

if(isset($_POST['id']))
{
    $id = mysqli_real_escape_string($conn, $_POST['id']);

    // Query to retrieve product details based on unique_id
    $query = "SELECT * FROM products WHERE id = '$id'";
    $result = mysqli_query($conn, $query);

    if ($result) {
        if (mysqli_num_rows($result) == 1) {
            $row = mysqli_fetch_assoc($result);

            // Prepare the product data as an associative array
            $productData = [
                'image' => $row['image'],
                'name' => $row['name'],
                'category' => $row['category'],
                'description' => $row['description'], // Update with your actual column name
                'price' => $row['price']
            ];

            // Return product data as JSON
            echo json_encode($productData);
        } else {
            echo json_encode(['error' => 'Product not found']);
        }
    } else {
        echo json_encode(['error' => 'Error executing the query: ' . mysqli_error($conn)]);
    }
} else {
    echo json_encode(['error' => 'No unique_id provided']);
}
?>
