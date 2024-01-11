<?php
session_start();
require 'config.php';

// Assuming you have a 'posting' table with columns 'unique_id', 'username', 'content', 'img', 'video', and 'date'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $content = mysqli_real_escape_string($conn, $_POST["content"]);
    $timestamp = date("Y-m-d H:i:s");

    // Handling image upload
    if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
        $img_name = $_FILES['image']['name'];
        $img_tmp_name = $_FILES['image']['tmp_name'];
        $img_size = $_FILES['image']['size'];
    
        $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
        $allowed_img_extensions = array("jpg", "jpeg", "png", "gif");
    
        if (in_array($img_ext, $allowed_img_extensions)) {
            $time = time();
            $new_img_name = $time . $img_name;
            $upload_path_img =  $new_img_name; // Store relative path
       
            if (move_uploaded_file($img_tmp_name, "../image/" . $upload_path_img)) {
                
                $image_filename = $new_img_name;
            } else {
                echo "Error uploading image. Please try again.";
                exit();
            }
        } else {
            echo "Invalid image file extension. Allowed extensions are jpg, jpeg, png, gif.";
            exit();
        }
    } else if (isset($_FILES['image']) && $_FILES['image']['error'] !== 4) {
        echo "Error uploading image. Error code: " . $_FILES['image']['error'];
        exit();
    }
    
    // Handling video upload


    // Inserting paths into the database
    $sql = "INSERT INTO posting (unique_id, username, content, img, date) VALUES ($user_id, '$username', '$content', '$image_filename', '$timestamp')";

    if ($conn->query($sql) === TRUE) {
        echo "Post added successfully";
        // Redirect the user to seller_newsfeed.php
        header("Location: ../seller_newsfeed.php");
        exit(); // Ensure that no further code is executed after the redirect
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}

$conn->close();
?>
