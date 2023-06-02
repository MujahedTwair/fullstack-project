<?php

$servername = "localhost";
$dbname = "database";
$username = "root";
$password = "";



$conn= new mysqli($servername,$username,$password,$dbname);

//check connection

if($conn->connect_error){
    die("Connection falied: " . $conn->connect_error);
}

?>