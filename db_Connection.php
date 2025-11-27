<?php
$host = 'localhost:3307'; // change to 3306 or 3307 depending on your XAMPP setup
$user = 'root';
$password = '';
$database = 'login_system';

$conn = new mysqli($host, $user, $password, $database);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo " ";
}
?>
