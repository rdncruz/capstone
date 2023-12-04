<?php
    session_start();
    require 'config.php';

    // Assuming you have a 'posting' table with columns 'unique_id', 'username', 'content', 'img', and 'date'

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $user_id = mysqli_real_escape_string($conn, $_POST["user_id"]);
        $username = mysqli_real_escape_string($conn, $_POST["username"]);
        $content = mysqli_real_escape_string($conn, $_POST["content"]);
        $timestamp = date("Y-m-d H:i:s");

        if (isset($_FILES['image'])) {
            $img_name = $_FILES['image']['name'];
            $img_tmp_name = $_FILES['image']['tmp_name'];
            $img_size = $_FILES['image']['size'];
            $img_error = $_FILES['image']['error'];

            if ($img_error === 0) {
                $img_ext = pathinfo($img_name, PATHINFO_EXTENSION);
                $allowed_extensions = array("jpg", "jpeg", "png", "gif");

                if (in_array($img_ext, $allowed_extensions)) {
                    $time = time();
                    $new_img_name = $time . $img_name;
                    $upload_path = "../image/" . $new_img_name;

                    if (move_uploaded_file($img_tmp_name, $upload_path)) {
                        $sql = "INSERT INTO posting (unique_id, username, content, img, date) VALUES ($user_id, '$username', '$content', '$new_img_name', '$timestamp')";

                        if ($conn->query($sql) === TRUE) {
                            echo "Post added successfully";
                            // Redirect the user to seller_newsfeed.php
                            header("Location: seller_newsfeed.php");
                            exit(); // Ensure that no further code is executed after the redirect
                        } else {
                            echo "Error: " . $sql . "<br>" . $conn->error;
                        }
                    } else {
                        echo "File not uploaded. Please try again.";
                    }
                } else {
                    echo "Invalid file extension. Allowed extensions are jpg, jpeg, png, gif.";
                }
            } else {
                echo "Error uploading file. Error code: " . $img_error;
            }
        } else {
            echo "Please select an image to upload.";
        }
    }

    $conn->close();
?>
