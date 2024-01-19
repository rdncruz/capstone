<?php
include_once 'config.php';
session_start();

$otp1 = $_POST['otp1'];
$otp2 = $_POST['otp2'];
$otp3 = $_POST['otp3'];
$otp4 = $_POST['otp4'];

$unique_id = $_SESSION['unique_id'];
$otp = $otp1 . $otp2 . $otp3 . $otp4;

if (!empty($otp)) {
    // Check if OTP is set in the session and not expired
    if (isset($_SESSION['otp']) && isset($_SESSION['otp_expiration']) && $_SESSION['otp_expiration'] > time()) {
        $session_otp = $_SESSION['otp'];

        if ($otp === $session_otp) {
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE unique_id = '{$unique_id}' AND otp = '{$otp}'");
            if (mysqli_num_rows($sql) > 0) {
                $null_otp = 0; // Set the OTP value to 0 to indicate a verified user
                $sql2 = mysqli_query($conn, "UPDATE users SET `verification_status` = 'Verified', `otp` = '$null_otp' WHERE unique_id = '{$unique_id}'");
                if ($sql2) {
                    $row = mysqli_fetch_assoc($sql);
                    if ($row) {
                        $_SESSION['unique_id'] = $row['unique_id'];
                        $_SESSION['verification_status'] = $row['verification_status'];
                        echo "success";
                    }
                }
            } else {
                echo "Wrong Otp!";
            }
        } else {
            echo "Wrong Otp!";
        }
    } else {
        echo "Expired Otp!";
    }
} else {
    echo "Enter Otp!";
}
?>
