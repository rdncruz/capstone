<?php
    session_start();
    if(isset($_SESSION['unique_id'])){
        include_once "config.php";
        $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
        if(isset($logout_id)){
            $status = "Offline now";
            $verify = "UnVerified"; // corrected variable name and value

            $sql = mysqli_query($conn, "UPDATE users SET otp = '0', status = '{$status}', verification_status = '{$verify}' WHERE unique_id = {$logout_id}");
            if($sql){
                session_unset();
                session_destroy();
                header("location: ../index.php");
            } else {
                echo "Error updating record: " . mysqli_error($conn);
            }
        } else {
            header("location: ../users.php");
        }
    } else {  
        header("location: ../login.php");
    }
?>
