<?php 
    session_start();
    include 'db.php';

    $category = $_POST['category'];
    $name = $_POST['name'];
    $small_description = $_POST['small_description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $status = $_POST['status'];

    if (!empty($category) && !empty($name) && !empty($small_description) && !empty($price) && !empty($quantity) && !empty($status) && isset($_FILES['image'])) {
        $img_name = $_FILES['image']['name']; //getting image name
        $img_type = $_FILES['image']['type']; //getting image type
        $tmp_name = $_FILES['image']['tmp_name'];
        $img_explode = explode('.', $img_name);
        $img_extension = end($img_explode);
        $extensions = ['png', 'jpeg', 'jpg']; // these are some valid image extensions

        if (in_array($img_extension, $extensions)) {
      
            $destination = "../Images/" . $img_name; // specify the correct destination directory

            if (move_uploaded_file($tmp_name, $destination)) {
                // insert data into table
                $sql2 = mysqli_query($conn, "INSERT INTO products (category, name, small_description, price, quantity, status, image) VALUES ('{$category}', '{$name}', '{$small_description}', '{$price}', '{$quantity}', '{$status}', '{$img_name}')");

                echo "success";
            } else {
                echo "Failed to move the uploaded file.";
            }
        } else {
            echo "Please select a profile picture in JPG, PNG, or JPEG format.";
        }
    } else {
        echo "All input fields are required.";
    }
?>
