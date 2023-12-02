<?php
// Include your database connection file here if needed (e.g., config.php)

if (isset($_POST['unique_id'])) {
    // Sanitize and retrieve the unique ID
    $uniqueId = $_POST['unique_id'];

    // Define the path to the directory where your images are stored
    $imageDirectory = 'image/';

    // Construct the full file path based on the unique ID (you may need to adjust the filename logic)
    $filePath = $imageDirectory . $uniqueId . '.jpg'; // Adjust the file extension as needed

    // Check if the file exists
    if (file_exists($filePath)) {
        // Determine the MIME type of the image
        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mimeType = finfo_file($finfo, $filePath);
        finfo_close($finfo);

        // Send the appropriate content type header
        header("Content-Type: $mimeType");

        // Output the image file
        readfile($filePath);
        exit; // Terminate script execution after sending the image
    } else {
        // Image not found, you can handle this case (e.g., show a default image)
        header('Content-type: image/jpeg'); // Send a content type even for default images
        readfile('path_to_default_image.jpg'); // Replace with your default image path
        exit; // Terminate script execution
    }
}
