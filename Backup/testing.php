<?php
$to = 'recipients@email-address.com';
$subject = 'Hello from XAMPP!';
$message = 'This is a test';
$headers = "From: your@email-address.com\r\n";
if (mail($to, $subject, $message, $headers)) {
   echo "SUCCESssS";
} else {
   echo "ERROR";
}
?>