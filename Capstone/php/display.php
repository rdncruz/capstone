<?php 
    session_start();
    include 'db.php';
    
    function getData($conn) {
        $sql = mysqli_query($conn, "SELECT * FROM products");

        if(mysqli_num_rows($sql) > 0) {
            return $sql;
        }
    }
?>