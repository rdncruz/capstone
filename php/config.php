<?php
  $hostname = "localhost";
  $username = "efishing";
  $password = "PcFzHMSQPDzKgd/e";
  $dbname = "efishing";

  $conn = mysqli_connect($hostname, $username, $password, $dbname);
  if(!$conn){
    echo "Database connection error".mysqli_connect_error();
  }
?>
