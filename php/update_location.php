<?php
include_once "config.php";  // Include your database connection configuration

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get the updated latitude and longitude
    $updatedLat = $_POST['lat'];
    $updatedLng = $_POST['lng'];

    session_start();

    if(isset($_SESSION['unique_id'])) {
        $unique_id = $_SESSION['unique_id'];

        // Update the user's location in the database
        $updateLocationQuery = "UPDATE location SET lat = '$updatedLat', lng = '$updatedLng' WHERE unique_id = '$unique_id'";

        if (mysqli_query($conn, $updateLocationQuery)) {
            $response = array("status" => "success", "message" => "Location updated successfully");
            echo json_encode($response);
        } else {
            $response = array("status" => "error", "message" => "Failed to update location");
            echo json_encode($response);
        }
    } else {
        $response = array("status" => "error", "message" => "User not authenticated");
        echo json_encode($response);
    }
} else {
    $response = array("status" => "error", "message" => "Invalid request method");
    echo json_encode($response);
}
?>
