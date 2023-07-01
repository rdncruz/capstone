<?php 
    session_start();
    include 'db.php';


    if(isset($_GET["id"])) {
        $id = $_GET["id"];

        $sql = "DELETE FROM products WHERE id=$id";
        $conn->query($sql);  
    }
    header("location: ../product.php");
    exit;
?>