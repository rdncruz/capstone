<?php 
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;  
    include_once "config.php";
    require '../vendor/autoload.php';
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $userType = isset($_POST['user_type']) ? $_POST['user_type'] : 'user';

    if ($userType === 'admin') {
        if(!empty($username) && !empty($password)) {
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE username = '{$username}'");

            if(mysqli_num_rows($sql) > 0) {
                $row = mysqli_fetch_assoc($sql);
                $user_pass = md5($password);
                $enc_pass = $row['password'];

                if($user_pass === $enc_pass) {
                    $otp = mt_rand(1111, 9999);
                    $status = "Active now";
                    $verify = "Verified";
                    $sql2 = mysqli_query($conn, "UPDATE users SET otp = '{$otp}', status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                    if($sql2){
                        $_SESSION['unique_id'] = $row['unique_id'];
                        echo "success";
                    } else{
                        echo "Something went wrong. Please try again!";
                    }
                } else {
                    echo " Username or Password is Incorrect";
                }
            } else {
                echo"$username - Invalid Username";
            }
        } else {
            echo "All input fields are required!";
        } 
    }
    else {
        if(!empty($username) && !empty($password)){
            $sql = mysqli_query($conn, "SELECT * FROM users WHERE username = '{$username}'");
            if(mysqli_num_rows($sql) > 0){
                $row = mysqli_fetch_assoc($sql);
                $user_pass = md5($password);
                $enc_pass = $row['password'];
                $email = $row['email'];
                if($user_pass === $enc_pass){
                    $otp = mt_rand(1111, 9999);
                    $status = "Active now";
                    if ($row['role'] === 'seller' && $row['verification_status'] === 'Not Verified') {
                        echo "Sorry Please wait to be Verified";
                        exit;
                    }
                    $sql2 = mysqli_query($conn, "UPDATE users SET otp = '{$otp}', status = '{$status}' WHERE unique_id = {$row['unique_id']}");
                    if($sql2){
                        $_SESSION['unique_id'] = $row['unique_id'];
                        echo 'success';
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
                            $mail->Body    = 'OTP Verification Code: '. $otp;
                        
                        
                            $mail->send();
                            
                        } catch (Exception $e) {
                            echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                        }
                    }else{
                        echo "Something went wrong. Please try again!";
                    }
                }else{
                    echo "Email or Password is Incorrect!";
    
                }
            }else{
                echo "$username - This username not Exist!";
            }
        }else{
            echo "All input fields are required!";
        }

        
    }
    
?>