<?php
include 'db.php';
$MaSV = $_GET['MaSV'];
$conn->query("DELETE FROM SinhVien WHERE MaSV='$MaSV'");
header("Location: students.php");
exit;
?>
