<?php

require 'config.php';

if(isset($_POST['save_student'])) {
    // Retrieve the unique_id from the POST data
    $unique_id = mysqli_real_escape_string($conn, $_POST['unique_id']);
    $product_id = mysqli_real_escape_string($conn, $_POST['product_id']);
    
    $category = mysqli_real_escape_string($conn, $_POST['category']);
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $small_description = mysqli_real_escape_string($conn, $_POST['small_description']); // Correct field name
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    
    // Check if any of the fields are empty
    if(empty($category) || empty($name) || empty($small_description) || empty($price) || empty($quantity) || empty($status)) {
        $response = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($response);
        return;
    }

    $img_name = $_FILES['image']['name']; // Getting image name
    $img_type = $_FILES['image']['type']; // Getting image type
    $tmp_name = $_FILES['image']['tmp_name'];
    $img_explode = explode('.', $img_name);
    $img_extension = end($img_explode);
    $extensions = ['png', 'jpeg', 'jpg']; // Valid image extensions

    if (in_array($img_extension, $extensions)) {
        $destination = "../image/" . $img_name; // Specify the correct destination directory
        
        if (move_uploaded_file($tmp_name, $destination)) {
            // Image uploaded successfully, now insert data into the database
            $prod_id = rand(time(), 100000000);
     
            $query = "INSERT INTO products (product_id, unique_id, category, name, small_description, price, quantity, status, image) VALUES ('$prod_id','$unique_id','$category', '$name', '$small_description', '$price', '$quantity', '$status', '$destination')";
            $query_run = mysqli_query($conn, $query);

            if($query_run) {
                $res = [
                    'status' => 200,
                    'message' => 'Product Created Successfully'
                ];
                echo json_encode($res);
                return;
            } else {
                $res = [
                    'status' => 500,
                    'message' => 'Product Not Created'
                ];
                echo json_encode($res);
                return;
            }
        } else {
            $res = [
                'status' => 5020,
                'message' => 'Error uploading image'
            ];
            echo json_encode($res);
            return;
        }
    } else {
        $res = [
            'status' => 4222,
            'message' => 'Invalid image format'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_POST['update_student']))
{   
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);
    $category = mysqli_real_escape_string($conn, $_POST['category']); // Change $con to $conn
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $small_description = mysqli_real_escape_string($conn, $_POST['small_description']); // Correct field name
    $price = mysqli_real_escape_string($conn, $_POST['price']);
    $quantity = mysqli_real_escape_string($conn, $_POST['quantity']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);

    if($name == NULL || $small_description == NULL || $price == NULL || $quantity == NULL || $status == NULL)
    {
        $res = [
            'status' => 422,
            'message' => 'All fields are mandatory'
        ];
        echo json_encode($res);
        return;
    }
    
    $query = "UPDATE products SET category='$category',name='$name', small_description='$small_description', price='$price', quantity='$quantity', status='$status' 
                WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query); // Change $con to $conn

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Product Updated Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Product Not Updated'
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_GET['id'])) // Change 'student_id' to 'product_id'
{
    $product_id = mysqli_real_escape_string($conn, $_GET['id']); // Change $con to $conn

    $query = "SELECT * FROM products WHERE id='$product_id'"; // Change 'students' to 'products'
    $query_run = mysqli_query($conn, $query);

    if(mysqli_num_rows($query_run) == 1)
    {
        $product = mysqli_fetch_array($query_run);

        $res = [
            'status' => 200,
            'message' => 'Product Fetch Successfully by id', // Update the message
            'data' => $product
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 404,
            'message' => 'Product Id Not Found' // Update the message
        ];
        echo json_encode($res);
        return;
    }
}


if(isset($_POST['delete_student']))
{
    $student_id = mysqli_real_escape_string($conn, $_POST['student_id']);

    $query = "DELETE FROM products WHERE id='$student_id'";
    $query_run = mysqli_query($conn, $query);

    if($query_run)
    {
        $res = [
            'status' => 200,
            'message' => 'Student Deleted Successfully'
        ];
        echo json_encode($res);
        return;
    }
    else
    {
        $res = [
            'status' => 500,
            'message' => 'Student Not Deleted'
        ];
        echo json_encode($res);
        return;
    }
}

?>