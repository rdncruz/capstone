<?php
    session_start();
    include_once "config.php";
    $userType = isset($_POST['user_type']) ? $_POST['user_type'] : 'users';
    $outgoing_id = $_SESSION['unique_id'];
    $sql = "";

    if($userType === 'seller') {
        $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND role = 'seller'";
    }
    else {
        $sql = "SELECT * FROM users WHERE NOT unique_id = {$outgoing_id} AND role = 'user'";
    }
    $query = mysqli_query($conn, $sql);
    $output = "";

    if(mysqli_num_rows($query) == 0){
        $output .= "$userType: No users are available to chat";
    } elseif(mysqli_num_rows($query) > 0){
        $data_file = ($userType === 'users') ? "seller_data.php" : "data.php";
        include_once $data_file;
    }

    echo $output;
?>


