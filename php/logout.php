<?php
session_start();
if(isset($_SESSION['unique_id'])){
    include_once "config.php";
    $logout_id = mysqli_real_escape_string($conn, $_GET['logout_id']);
    
    if(isset($logout_id)){
        // Check if the user is an admin
        $admin_role = "admin"; // Change this to the actual role for admin users

        $check_admin_query = mysqli_query($conn, "SELECT * FROM Role WHERE unique_id = {$logout_id} AND role = '{$admin_role}'");
        
        if ($check_admin_query !== false) {
            if (mysqli_num_rows($check_admin_query) == 0) {
                // User is not an admin, proceed with update and logout
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
                // User is an admin, redirect to the appropriate page
                header("location: ../index.php");
            }
        } else {
            // Handle query error
            echo "Error executing query: " . mysqli_error($conn);
        }
    } else {
        header("location: ../index.php");
    }
} else {  
    header("location: ../login.php");
}
?>
