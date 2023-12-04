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
                        if ($password == $cpassword) {
                            // let's check if the user uploaded a file or not
                            if (isset($_FILES['image'])) {
                                $img_name = $_FILES['image']['name'];
                                // ... (check file type, extension, etc.)
                                $time = time();
                                $new_img_name = $time . $img_name;
                                $upload_path = "../image/" . $new_img_name;
                        
                                if (move_uploaded_file($_FILES['image']['tmp_name'], $upload_path)) {
                                    // File upload handling for the second image (reg_image)
                        
                                    if ($userType === 'seller') {
                                        // Only users with role 'user' can access the second image upload
                                        if (isset($_FILES['reg_image'])) {
                                            $reg_img_name = $_FILES['reg_image']['name'];
                                            // ... (check file type, extension, etc.)
                                            $new_reg_img_name = $time . $reg_img_name;
                                            $reg_upload_path = "../image/" . $new_reg_img_name;
                        
                                            if (move_uploaded_file($_FILES['reg_image']['tmp_name'], $reg_upload_path)) {
                                                // Continue with the rest of your code
                                                $ran_id = rand(time(), 100000000); // create a unique user id
                                                $otp = mt_rand(1111, 9999); // creating 4 digits otp
                        
                                                // Insert data into Table
                                                $query =  "INSERT INTO users (unique_id, username, fname, lname, address, email, password, img, otp, status, role, shop_name, reg_img, verification_status)  VALUES ($ran_id, '$username', '$fname', '$lname', '$address', '$email', '$encrypt_pass', '$new_img_name', $otp, '$status', '$userType', '$shop_name', '$new_reg_img_name', '$verification_status')";
                        
                                                // Continue with the rest of your code...
                                            } else {
                                                echo "Second file not uploaded";
                                            }
                                        } else {
                                            echo "User did not upload the second image";
                                        }
                                    } else {
                                        // Users with a role other than 'user' are not allowed to access the second image upload
                                        echo "Access denied. Only users with role 'user' can upload the second image.";
                                    }
                                } else {
                                    echo "First file not uploaded";
                                }
                            } else {
                                echo "User did not upload the first image";
                            }
                        } else {
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