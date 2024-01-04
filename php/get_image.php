<?php
// Include your database configuration
include_once "config.php";

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['unique_id'])) {
        $uniqueId = $_POST['unique_id'];

        // Fetch registration image data from the database based on the unique ID
        $imageQuery = "SELECT reg_img FROM users WHERE unique_id = '$uniqueId'";
        $result = mysqli_query($conn, $imageQuery);

        if ($result) {
            $row = mysqli_fetch_assoc($result);

            // Check if the registration image exists
            if ($row && isset($row['reg_img'])) {
                $imageData = $row['reg_img'];

                // Send appropriate headers and the registration image data
                header('Content-Type: image/jpeg');
                echo base64_decode($imageData);
                exit();
            } else {
                // Registration image not found
                echo 'Registration image not found for unique ID: ' . $uniqueId;
            }
        } else {
            // Query failed
            echo 'Failed to fetch registration image. Error: ' . mysqli_error($conn);
        }
    } else {
        // Unique ID not provided
        echo 'Unique ID not provided';
    }
} else {
    // Invalid request method
    echo 'Invalid request method';
}
?>
