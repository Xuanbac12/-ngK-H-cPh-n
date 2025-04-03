<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$db = 'kt2';

$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    die("Kết nối thất bại: " . $conn->connect_error);
}
mysqli_set_charset($conn, "utf8mb4");
?>
