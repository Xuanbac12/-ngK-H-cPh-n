<?php
session_start();
include 'db.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

// 1. Lấy tất cả MaDK của sinh viên này
$stmt = $conn->prepare("SELECT MaDK FROM DangKy WHERE MaSV = ?");
$stmt->bind_param("s", $MaSV);
$stmt->execute();
$res = $stmt->get_result();

while ($row = $res->fetch_assoc()) {
    $MaDK = $row['MaDK'];

    // 2. Xoá các học phần trong bảng ChiTietDangKy
    $conn->query("DELETE FROM ChiTietDangKy WHERE MaDK = $MaDK");

    // 3. Xoá cả lượt đăng ký trong bảng DangKy
    $conn->query("DELETE FROM DangKy WHERE MaDK = $MaDK");
}

header("Location: cart.php");
exit();
