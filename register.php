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
    // Tìm MaDK mới nhất
    $stmt = $conn->prepare("SELECT MaDK FROM DangKy WHERE MaSV = ? ORDER BY MaDK DESC LIMIT 1");
    $stmt->bind_param("s", $MaSV);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $MaDK = $row['MaDK'];

        // Kiểm tra xem học phần này đã tồn tại trong ChiTietDangKy chưa
        $check = $conn->prepare("SELECT * FROM ChiTietDangKy WHERE MaDK = ? AND MaHP = ?");
        $check->bind_param("is", $MaDK, $MaHP);
        $check->execute();
        $exist = $check->get_result()->fetch_assoc();

        if (!$exist) {
            // Nếu chưa tồn tại thì thêm mới
            $insert = $conn->prepare("INSERT INTO ChiTietDangKy(MaDK, MaHP) VALUES (?, ?)");
            $insert->bind_param("is", $MaDK, $MaHP);
            $insert->execute();
        }
    } else {
        // Nếu chưa có lượt đăng ký nào → tạo mới
        $now = date('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO DangKy(NgayDK, MaSV) VALUES (?, ?)");
        $stmt->bind_param("ss", $now, $MaSV);
        $stmt->execute();
        $newMaDK = $conn->insert_id;

        // Sau đó thêm học phần
        $insert = $conn->prepare("INSERT INTO ChiTietDangKy(MaDK, MaHP) VALUES (?, ?)");
        $insert->bind_param("is", $newMaDK, $MaHP);
        $insert->execute();
    }
}

header("Location: cart.php");
exit();
