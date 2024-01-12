<?php
session_start();
require 'config.php';

// Assuming you have a 'posting' table with columns 'unique_id', 'username', 'content', 'img', 'date'

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);
    $username = mysqli_real_escape_string($conn, $_POST["username"]);
    $content = mysqli_real_escape_string($conn, $_POST["content"]);
    $timestamp = date("Y-m-d H:i:s");

    // Handling image or video upload
    if (isset($_FILES['media']) && $_FILES['media']['error'] === 0) {
        $media_name = $_FILES['media']['name'];
        $media_tmp_name = $_FILES['media']['tmp_name'];
        $media_size = $_FILES['media']['size'];

        $media_ext = pathinfo($media_name, PATHINFO_EXTENSION);
        $allowed_media_extensions = array("jpg", "jpeg", "png", "gif", "mp4", "mov", "avi");

        if (in_array($media_ext, $allowed_media_extensions)) {
            $time = time();
            $new_media_name = $time . $media_name;
            $upload_path_media =  $new_media_name;

            if (move_uploaded_file($media_tmp_name, "../image/" . $upload_path_media)) {
                $media_filename = $new_media_name;
            } else {
                echo "Error uploading media. Please try again.";
                exit();
            }
        } else {
            echo "Invalid media file extension. Allowed extensions are jpg, jpeg, png, gif, mp4, mov, avi.";
            exit();
        }
    } else if (isset($_FILES['media']) && $_FILES['media']['error'] !== 4) {
        echo "Error uploading media. Error code: " . $_FILES['media']['error'];
        exit();
    }

    // Inserting paths into the database
    $sql = "INSERT INTO posting (unique_id, username, content, img, date) 
            VALUES ($user_id, '$username', '$content', '$media_filename', '$timestamp')";

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
