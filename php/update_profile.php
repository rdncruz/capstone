<?php
session_start();
include_once "config.php";

if (!isset($_SESSION['unique_id'])) {
    header("Location: ../index.php");
    exit();
}

$unique_id = $_SESSION['unique_id'];

// Your validation and sanitization code here

// Example: Update the username, fname, lname, address, and email
$username = mysqli_real_escape_string($conn, $_POST['username']);
$fname = mysqli_real_escape_string($conn, $_POST['fname']);
$lname = mysqli_real_escape_string($conn, $_POST['lname']);
$address = mysqli_real_escape_string($conn, $_POST['address']);
$email = mysqli_real_escape_string($conn, $_POST['email']);

// Check if image is being uploaded
if (isset($_FILES['image'])) {
    $target_dir = "../image/"; // Update the target directory
    $target_file = $target_dir . basename($_FILES['image']['name']);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

    // Check if the target directory exists, create it if not
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0755, true);
    }

    // Check if the uploaded file is an image
    $check = getimagesize($_FILES['image']['tmp_name']);
    if ($check !== false) {
        // Allow only certain image file formats (you can modify this list)
        $allowed_formats = array('jpg', 'jpeg', 'png', 'gif');
        if (in_array($imageFileType, $allowed_formats)) {
            // Move the uploaded file to the target directory
            if (move_uploaded_file($_FILES['image']['tmp_name'], $target_file)) {
                // Update the database with the new image filename
                $image_filename = basename($_FILES['image']['name']);
            } else {
                $response = ['status' => 'error', 'message' => 'Failed to move the uploaded file.'];
                echo json_encode($response);
                exit();
            }
        } else {
            $response = ['status' => 'error', 'message' => 'Invalid image file format.'];
            echo json_encode($response);
            exit();
        }
    } else {
        $response = ['status' => 'error', 'message' => 'File is not an image.'];
        echo json_encode($response);
        exit();
    }
} else {
    // If no image is being uploaded, retain the existing image filename in the database
    $image_filename_query = mysqli_query($conn, "SELECT img FROM users WHERE unique_id = '$unique_id'");
    $row = mysqli_fetch_assoc($image_filename_query);
    $image_filename = $row['img'];
}

// Set the current password (for demonstration purposes)
$currentPassword = 'password';

// Hash the new password before updating the database
$newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
$encrypt_pass = md5($newPassword);

// Update the database with the new information (including image filename and password)
$update_query = "UPDATE users SET 
                username = '$username',
                fname = '$fname',
                lname = '$lname',
                address = '$address',
                email = '$email',
                password = '$encrypt_pass',
                img = '$image_filename'
                
                WHERE unique_id = '$unique_id'";

$result = mysqli_query($conn, $update_query);

if ($result) {
    $response = ['status' => 'success'];
} else {
    $response = ['status' => 'error', 'message' => 'Database update failed.'];
}

echo json_encode($response);
?>
