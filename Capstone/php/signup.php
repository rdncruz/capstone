<?php 
    ini_set('SMTP', 'mail.example.com');
    ini_set('smtp_port', 587);
    session_start();
    include_once 'db.php';
    $fname = $_POST['fname'];
    $lname = $_POST['lname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $password = md5($_POST['pass']); //secure password
    $cpassword = md5($_POST['cpass']);
    $Role = $_POST['userType'];
    $verification_status = '0';

    //checking fields are not empty
    if (!empty($fname) && !empty($lname) && !empty($email) && !empty($phone) && !empty($password) && !empty($cpassword)) {
        //if email is valid 
        if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
            //checking if email already exists
            $sql = mysqli_query($conn, "SELECT email FROM users WHERE email = '{$email}'");
            if (mysqli_num_rows($sql) > 0) {
                echo "$email ~ Already Exists";
            } else {
                //checking if password and confirm password match
                if ($password == $cpassword) {
                    //let's check if the user uploaded a file or not
                    if (isset($_FILES['image'])) {
                        $img_name = $_FILES['image']['name']; //getting image name
                        $img_type = $_FILES['image']['type']; //getting image type
                        $tmp_name = $_FILES['image']['tmp_name'];
                        $img_explode = explode('.', $img_name);
                        $img_extension = end($img_explode);
                        $extensions = ['png', 'jpeg', 'jpg']; // these are some valid image extensions

                        if (in_array($img_extension, $extensions)) {
                            $time = time();
                            $newimagename = $time . $img_name; //creating a unique name for the image
                            if (move_uploaded_file($tmp_name, "../Images/" . $newimagename)) { //set the uploaded file storage folder
                                $random_id = rand(time(), 1000000); //create a unique user id
                                $otp = mt_rand(1111, 9999); //creating 4 digits otp

                                // Insert data into Table
                                $sql2 = mysqli_query($conn, "INSERT INTO users (unique_id, fname, lname, email, phone, password, image, otp, verification_status, Role)
                                VALUES ({$random_id}, '{$fname}', '{$lname}', '{$email}', '{$phone}', '{$password}', '{$newimagename}', '{$otp}', '{$verification_status}', '{$Role}')");
                                if ($sql2) {
                                    $sql3 = mysqli_query($conn, "SELECT * FROM users WHERE email = '{$email}'");
                                    if (mysqli_num_rows($sql3) > 0) {
                                        $row = mysqli_fetch_assoc($sql3); //fetching data
                                        $_SESSION['unique_id'] = $row['unique_id'];
                                        $_SESSION['email'] = $row['email'];
                                        $_SESSION['otp'] = $row['otp'];

                                        //lets start mail function
                                        if($otp) {
                                            $reciever = $email;
                                            $subject = "From: $fname $lname <$email>";
                                            $body = "Name "." $fname $lname \n Email "." $email \n "." $otp";
                                            $sender = "From: crenzxdaryl@gmail.com";

                                            if(mail($reciever, $subject, $body, $sender)) {
                                                echo "success";
                                            }
                                            else  {
                                                echo "Email Problem!" .mysqli_error($conn);
                                            }
                                        }

                                        
                                       //mail function end

                                    }
                                } 
                                else {
                                    echo "something went Wrong";
                                }                       
                            }    
                        }
                        else {
                            echo "Please Select and Profile Picture - JPG, PNG, JPEG";
                        }
                    }
                    else {
                        echo "Please Select and Profile Picture";
                    }
                }
                else {
                    echo "Confirm Password Don't Match";
                }
            }
        }
        else {
            echo "$email ~ this is not a Valid Email";
        }

    }
    else {
        echo "All Input Fields are Required";
    }

?>