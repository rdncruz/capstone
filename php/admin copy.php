<?php
require 'config.php';

if (isset($_POST['unique_id']) && isset($_POST['action'])) {
    $unique_id = mysqli_real_escape_string($conn, $_POST['unique_id']);
    $action = $_POST['action'];

    if ($action === 'reject') {
        // Perform the reject operation in your database
        $query = "DELETE FROM seller WHERE unique_id = '$unique_id'";
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
        $query = "UPDATE seller SET verification_status = 'pending' WHERE unique_id = '$unique_id'";
        $result = mysqli_query($conn, $query);

        if ($result) {
            // Seller approved successfully
            // Retrieve the OTP from the database
            $otpQuery = "SELECT otp FROM seller WHERE unique_id = '$unique_id'";
            $otpResult = mysqli_query($conn, $otpQuery);

            if ($otpResult && mysqli_num_rows($otpResult) > 0) {
                $row = mysqli_fetch_assoc($otpResult);
                $otp = $row['otp'];

                // Retrieve the email address of the seller
                $emailQuery = "SELECT email FROM seller WHERE unique_id = '$unique_id'";
                $emailResult = mysqli_query($conn, $emailQuery);

                if ($emailResult && mysqli_num_rows($emailResult) > 0) {
                    $row = mysqli_fetch_assoc($emailResult);
                    $email = $row['email'];

                    // Send the approval email with OTP
                    $subject = "Your Seller Account is Approved";
                    $message = "Congratulations! Your seller account has been approved. Your OTP is: $otp";
                    $headers = "From: your_email@example.com"; // Change this to your email address

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
} else {
    // Invalid request
    $response = [
        'status' => 'error',
        'message' => 'Invalid request'
    ];
}

echo json_encode($response);
?>
