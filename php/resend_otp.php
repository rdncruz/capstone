<?php
session_start();
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;  
include_once "config.php";
require '../vendor/autoload.php';

function generateOtp() {
    // Implement your OTP generation logic here
    return mt_rand(1111, 9999);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_SESSION['username'];


    if (!empty($username)) {
        $sql = mysqli_query($conn, "SELECT * FROM users WHERE username = '{$username}'");

        if (mysqli_num_rows($sql) > 0) {
            $row = mysqli_fetch_assoc($sql);
            $email = $row['email'];

            // Generate a new OTP
            $otp = generateOtp();
            $status = "Active now";
            $expiration_time = time() + (1 * 60);

            // Update the session variables
            $_SESSION['otp'] = $otp;
            $_SESSION['otp_expiration'] = $expiration_time;

            // Update the user record with the new OTP
            $sql2 = mysqli_query($conn, "UPDATE users SET otp = '{$otp}', status = '{$status}' WHERE unique_id = {$row['unique_id']}");

            if ($sql2) {
                // Send the new OTP via email
                $mail = new PHPMailer(true);
                try {
                    // Server settings
                    $mail->isSMTP();
                    $mail->Host       = 'smtp.gmail.com';
                    $mail->SMTPAuth   = true;
                    $mail->Username   = 'crenzxdaryl@gmail.com';
                    $mail->Password   = 'hhsk nebo abfn muqk';
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;
                    $mail->Port       = 465;

                    // Recipients
                    $mail->setFrom('crenzdaryl@gmail.com', 'Efishing');
                    $mail->addAddress($email);

                    // Content
                    $mail->isHTML(true);
                    $mail->Subject = 'Efishing OTP Resend';
                    $mail->Body    = 'New OTP: ' . $otp;

                    $mail->send();
                    echo "success";
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }
            } else {
                echo "Something went wrong. Please try again!";
            }
        } else {
            echo "Invalid Username";
        }
    } else {
        echo "Username is required!";
    }
} else {
    echo 'Invalid request method.';
}
?>
