<?php
$ipuser = $_SERVER['REMOTE_ADDR'];
$servername = "DB_SERVER";
$username = "DB_USER";
$password = "DB_PASSWORD";
$dbname = "DB_NAME";
$conn = new mysqli($servername, $username, $password, $dbname);
if ($conn->connect_error){
    die("Connection failed: " . $conn->connect_error);
}
?>