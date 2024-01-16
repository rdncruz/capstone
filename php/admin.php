<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;   
session_start();
require 'config.php';
require '../vendor/autoload.php';
if (isset($_POST['unique_id']) && isset($_POST['action'])) {
    $unique_id = mysqli_real_escape_string($conn, $_POST['unique_id']);
    $action = $_POST['action'];

    if ($action === 'reject') {
        // Perform the reject operation in your database
        $query = "DELETE FROM users WHERE unique_id = '$unique_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Seller rejected successfully
            $response = [
                'status' => 'success',
                'message' => 'Seller rejected successfully'
            ];
        } else {
            // Error occurred while rejecting seller
            $response = [
                'status' => 'error',
                'message' => 'Failed to reject seller'
            ];
        }
    } elseif ($action === 'approve') {
        // Perform the approval operation in your database
            // Seller approved successfully
            // Retrieve the OTP from the database
          
            $verificationStatus = "UnVerified";
            $updateQuery = "UPDATE users SET verification_status = '$verificationStatus' WHERE unique_id = '$unique_id'";
            $updateResult = mysqli_query($conn, $updateQuery);

            if ($updateResult) {
                // Retrieve the email address of the seller
                $emailQuery = "SELECT email FROM users WHERE unique_id = '$unique_id'";
                $emailResult = mysqli_query($conn, $emailQuery);

                if ($emailResult && mysqli_num_rows($emailResult) > 0) {
                    $row = mysqli_fetch_assoc($emailResult);
                    $email = $row['email'];

                    // Send the approval email with OTP
                    $reciever = $email;
                                                                
                                                                $mail = new PHPMailer(true);
                                                                try {
                                                                    //Server settings
                                                                    //$mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                                                                    $mail->isSMTP();                                            //Send using SMTP
                                                                    $mail->Host       = 'smtp.gmail.com';                     //Set the SMTP server to send through
                                                                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                                                                    $mail->Username   = 'crenzxdaryl@gmail.com';                     //SMTP username
                                                                    $mail->Password   = 'hhsk nebo abfn muqk';                               //SMTP password
                                                                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                                                                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`
                                                                
                                                                    //Recipients
                                                                    $mail->setFrom('crenzdaryl@gmail.com', 'Efishing');
                                                                    $mail->addAddress($email);     //Add a recipient
                                                                
                                                                
                                                                    //Attachments
                                                                
                                                                
                                                                    //Content
                                                                    $mail->isHTML(true);                                  //Set email format to HTML
                                                                    $mail->Subject = 'Efishing Account Verification';
                                                                    $mail->Body    = 'You are now Verified you can now login';
                                                               
                                                                
                                                                    $mail->send();
                                                                    if (mail($email, $subject, $message, $headers)) {
                        $response = [
                            'status' => 'success',
                            'message' => 'Seller approved successfully and email sent'
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => 'Failed to send approval email'
                        ];
                    }
                                                                } catch (Exception $e) {
                                                                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                                                }

                    if (mail($email, $subject, $message, $headers)) {
                        $response = [
                            'status' => 'success',
                            'message' => 'Seller approved successfully and email sent'
                        ];
                    } else {
                        $response = [
                            'status' => 'error',
                            'message' => 'Failed to send approval email'
                        ];
                    }
                } else {
                    $response = [
                        'status' => 'error',
                        'message' => 'Failed to retrieve seller email'
                    ];
                }
            } else {
                $response = [
                    'status' => 'error',
                    'message' => 'Failed to retrieve OTP'
                ];
            }
        } else {
            // Error occurred while approving seller
            $response = [
                'status' => 'error',
                'message' => 'Failed to approve seller'
            ];
        }
    } else {
        // Invalid action
        $response = [
            'status' => 'error',
            'message' => 'Invalid action'
        ];
    }
echo json_encode($response);
?>
