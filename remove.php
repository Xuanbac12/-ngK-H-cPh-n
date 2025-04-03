<?php
session_start();
include 'db.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];
$MaHP = $_GET['MaHP'] ?? '';

if ($MaHP) {
    // Tìm tất cả MaDK của sinh viên hiện tại
    $stmt = $conn->prepare("SELECT MaDK FROM DangKy WHERE MaSV = ?");
    $stmt->bind_param("s", $MaSV);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($row = $result->fetch_assoc()) {
        $MaDK = $row['MaDK'];

        // Xóa học phần này khỏi từng MaDK (nếu có)
        $stmtDel = $conn->prepare("DELETE FROM ChiTietDangKy WHERE MaDK = ? AND MaHP = ?");
        $stmtDel->bind_param("is", $MaDK, $MaHP);
        $stmtDel->execute();
    }
}

header("Location: cart.php");
exit();
