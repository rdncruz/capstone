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
    // ... (rest of the image upload code remains unchanged)
} else {
    // If no image is being uploaded, retain the existing image filename in the database
    $image_filename_query = mysqli_query($conn, "SELECT img FROM users WHERE unique_id = '$unique_id'");
    $row = mysqli_fetch_assoc($image_filename_query);
    $image_filename = $row['img'];
}

// Check if a new password is provided
if (!empty($_POST['newPassword'])) {
    // Set the current password (for demonstration purposes)
    $currentPassword = 'password';

    // Hash the new password before updating the database
    $newPassword = mysqli_real_escape_string($conn, $_POST['newPassword']);
    $encrypt_pass = md5($newPassword);
    
    // Update the database with the new password
    $update_query = "UPDATE users SET password = '$encrypt_pass' WHERE unique_id = '$unique_id'";
    $result = mysqli_query($conn, $update_query);

    if (!$result) {
        $response = ['status' => 'error', 'message' => 'Password update failed.'];
        echo json_encode($response);
        exit();
    }
}

// Update the database with the new information (excluding password if not provided)
$update_query = "UPDATE users SET 
                username = '$username',
                fname = '$fname',
                lname = '$lname',
                address = '$address',
                email = '$email',
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
