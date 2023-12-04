<?php 
    session_start();
    use PHPMailer\PHPMailer\PHPMailer;
    use PHPMailer\PHPMailer\SMTP;
    use PHPMailer\PHPMailer\Exception;  
    include_once "config.php";
    require '../vendor/autoload.php';
    $fname = mysqli_real_escape_string($conn, $_POST['fname']);
    $lname = mysqli_real_escape_string($conn, $_POST['lname']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = mysqli_real_escape_string($conn, $_POST['password']);
    $cpassword = mysqli_real_escape_string($conn, $_POST['cpassword']);
    $unique_id = isset($_SESSION['unique_id']) ? $_SESSION['unique_id'] : null;
    $username = mysqli_real_escape_string($conn, $_POST['username']);
    $shop_name = mysqli_real_escape_string($conn, $_POST['shop_name']);
    $lat = mysqli_real_escape_string($conn, $_POST['lat']);
    $lng = mysqli_real_escape_string($conn, $_POST['lng']);
    $encrypt_pass = md5($password);
    $verification_status = 'Not Verified';
    $status = "Offline";
    $ran_id = 0;
    $userType = isset($_POST['user_type']) ? $_POST['user_type'] : 'user';
    if($userType === 'admin') {
        if(!empty($username) && !empty($email) && !empty($password)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
                if(mysqli_num_rows($sql) > 0) {
                    echo "$username - This username already exist!";
                } else {
                    //Admin username is not exist
                    $ran_id = rand(time(), 100000000); //Generate Admin ID
                    $query =  "INSERT INTO users (unique_id, email, username, password, status)  VALUES ($ran_id, '$email', '$username', '$encrypt_pass', '$status')";
                    //Insert admin Data
                    $insert_query = mysqli_query($conn, $query);
                 
                    if($insert_query) {
                        echo "success";
                    } else {
                        echo "Error: " . mysqli_error($conn); // Output the specific error message
                    }
                }
            } else {
                //Admin Email not valid
            }
        } else {
            // If the field is empty in User Admin
        }
    } else {
        if(!empty($fname) && !empty($lname) && !empty($email) && !empty($password) && !empty($username)){
            if(filter_var($email, FILTER_VALIDATE_EMAIL)){
                $sql = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
                if(mysqli_num_rows($sql) > 0){
                    echo "$email - This email already exist!";
    
                } 
                else {
                    $sql = mysqli_query($conn, "SELECT * FROM users WHERE username = '$username'");
                    if(mysqli_num_rows($sql) > 0){ 
                        echo "$username - This username already exist!";
                    }
                    else {
                        if($password == $cpassword) {
                            //let's check if the user uploaded a file or not
                            if (isset($_FILES['image'])) {
                                $img_name = $_FILES['image']['name'];
                                // ... (check file type, extension, etc.)
                                $time = time();
                                $new_img_name = $time . $img_name;
                                $upload_path = "../image/" . $new_img_name;
                                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                                    // File upload handling for the second image (reg_image)
                                    if (isset($_FILES['reg_image'])) {
                                        $reg_img_name = $_FILES['reg_image']['name'];
                                        // ... (check file type, extension, etc.)
                                        $new_reg_img_name = $time . $reg_img_name;
                                        $reg_upload_path = "../image/" . $new_reg_img_name;
                                        if (move_uploaded_file($_FILES['reg_image']['tmp_name'], $reg_upload_path)) {
                                            $ran_id = rand(time(), 100000000); //create a unique user id
                                            $otp = mt_rand(1111, 9999); //creating 4 digits otp

                                            // Insert data into Table
                                            $query =  "INSERT INTO users (unique_id, username, fname, lname, address, email, password, img, otp, status, role, shop_name, reg_img, verification_status)  VALUES ($ran_id, '$username', '$fname', '$lname', '$address', '$email', '$encrypt_pass', '$newimgname', $otp, '$status', '$userType', '$shop_name', '$new_reg_img_name', '$verification_status')";
                                            //Insert admin Data
                                            // echo $query;
                                            
                                            $insert_query = mysqli_query($conn, $query);
                                            if($insert_query){
                                                $insert_location_query = mysqli_query($conn, "INSERT INTO location (unique_id, lat, lng) VALUES ($ran_id, '$lat', '$lng')");

                                                if($insert_location_query){ 
                                                    $select_sql2 = mysqli_query($conn, "SELECT * FROM users WHERE email = '$email'");
                                                    if(mysqli_num_rows($select_sql2) > 0){
                                                        $result = mysqli_fetch_assoc($select_sql2);
                                                        $_SESSION['unique_id'] = $result['unique_id'];
                                                        $_SESSION['email'] = $result['email'];
                                                        $_SESSION['otp'] = $otp;
    
                                                        if ($userType === 'user') { 
                                                            if($otp) {
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
                                                                    $mail->Body    = 'OTP Verication Code: '. $otp;
                                                               
                                                                
                                                                    $mail->send();
                                                                    echo 'success';
                                                                } catch (Exception $e) {
                                                                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                                                                }
                                                            } 
                                                            else {
                                                                echo "something went Wrong";
                                                            }
                                                        }                                            
                                                        else {
                                                            echo "success";
                                                        }
                                                    }
                                                    else {
                                                        echo "This email address not Exist!";
                                                    }
                                                } 
                                                else {
                                                    echo "Something went wrong. Please try agsain!";
                                                }
                                            }
                                            else {
                                                echo "Something went wrong. Please try again!";
                                            }
                                        } else {
                                            echo "Second file not uploaded";
                                        }
                                    } else {
                                        echo "User did not upload the second image";
                                    }
                                } else {
                                    echo "First file not uploaded";
                                }
                            } else {
                                echo "User did not upload the first image";
                            }
                        }
                        else {
                            echo "Confirm Password Don't Match";
                        }
                    }
                }
            }
            else {
                echo "$email is not a valid email!";
            }
        }
        else {
            echo "All input fields are required!";
        }
    }
?>