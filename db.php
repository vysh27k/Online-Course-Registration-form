<?php
$host = 'localhost:3307';  // <-- change 3307 if that’s your actual port
$user = 'root';
$password = '';
$database = 'login_system';

$conn = new mysqli($host, $user, $password, $database); 

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "";
}
?>
