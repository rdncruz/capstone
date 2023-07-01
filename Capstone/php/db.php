<?php 
    $conn = new mysqli('localhost','root','','efishing');
    if(!$conn) {
        echo "Connection Denied!" .mysqli_connect_error();
    }
    else {
        // echo "Connection Denied!";
    }

?>