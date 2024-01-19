<?php
 session_start();
 
 $_SESSION['otp'];
 $_SESSION['otp_expiration'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="Cache-Control" content="no-cache, no-store, must-revalidate" />
    <meta http-equiv="Pragma" content="no-cache" />
    <meta http-equiv="Expires" content="0" />
    <title>seller Verify</title>
    <link rel="stylesheet" href="css/logreg.css">
    <style>
        /* Add a CSS style for the clickable label */
        #resendLabel {
            color: blue; /* Initial color */
            cursor: pointer;
        }
    </style>
</head>
<body data-user-type="seller">
    <div class="background">
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    <div class="wrapper">
        <div class="form" style="text-align: center;">
            <h2>OTP Verification</h2>
            <p>We take the security of your account seriously. To ensure the safety of your account, Please check your Email for Verication Code.</p>
            <form action="" autocomplete="off">
            <input type="hidden" name="otp">
                <div class="error-text">Error</div>
                <div class="fields-input">
                    <input type="number" name="otp1" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                    <input type="number" name="otp2" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                    <input type="number" name="otp3" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                    <input type="number" name="otp4" class="otp_field" placeholder="0" min="0" max="9" required onpaste="false">
                </div>
                <input type="radio" name="user_type" id="seller" value="seller" style="display: none;" checked>
                <p>Didn't Recieve a Code or Invalid Code?</p>
                <div id="countdown">1:00</div>
                <div class="field button">
                    <input type="submit" name="submit" value="Enter">
                </div>
            </form>
        </div>
    </div>
    <script src="javascript/user_verification.js"></script>
    <script>
        // Countdown timer logic
        var countdownElement = document.getElementById('countdown');
        var timeRemaining = 60; // 1 minute in seconds

        function updateCountdown() {
            var minutes = Math.floor(timeRemaining / 60);
            var seconds = timeRemaining % 60;

            // Display the countdown in MM:SS format
            countdownElement.textContent = minutes + ':' + (seconds < 10 ? '0' : '') + seconds;

            if (timeRemaining > 0) {
                timeRemaining--;
                setTimeout(updateCountdown, 1000); // Update every second
            } else {
                countdownElement.textContent = "Expired";
                // Optionally, you can add logic to handle expiration (e.g., disable the submit button)
            }
        }

        // Start the countdown when the page loads
        updateCountdown();
    </script>
</body>
</html>