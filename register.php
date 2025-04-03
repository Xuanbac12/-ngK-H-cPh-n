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
    // ✅ Kiểm tra: sinh viên đã đăng ký học phần này chưa (bất kỳ lượt nào)
    $stmt = $conn->prepare("
        SELECT 1 FROM DangKy dk
        JOIN ChiTietDangKy ct ON dk.MaDK = ct.MaDK
        WHERE dk.MaSV = ? AND ct.MaHP = ?
    ");
    $stmt->bind_param("ss", $MaSV, $MaHP);
    $stmt->execute();
    $check = $stmt->get_result()->fetch_assoc();

    if ($check) {
        // Nếu đã đăng ký rồi → không cho đăng ký lại
        echo "<script>alert('❗ Bạn đã đăng ký học phần này rồi!'); window.location.href = 'courses.php';</script>";
        exit();
    }

    // ✅ Nếu chưa đăng ký, tiếp tục như cũ
    // Tìm MaDK mới nhất
    $stmt = $conn->prepare("SELECT MaDK FROM DangKy WHERE MaSV = ? ORDER BY MaDK DESC LIMIT 1");
    $stmt->bind_param("s", $MaSV);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        $MaDK = $row['MaDK'];
        $insert = $conn->prepare("INSERT INTO ChiTietDangKy(MaDK, MaHP) VALUES (?, ?)");
        $insert->bind_param("is", $MaDK, $MaHP);
        $insert->execute();
    } else {
        // Nếu chưa có lượt đăng ký nào → tạo mới
        $now = date('Y-m-d');
        $stmt = $conn->prepare("INSERT INTO DangKy(NgayDK, MaSV) VALUES (?, ?)");
        $stmt->bind_param("ss", $now, $MaSV);
        $stmt->execute();
        $newMaDK = $conn->insert_id;

        $insert = $conn->prepare("INSERT INTO ChiTietDangKy(MaDK, MaHP) VALUES (?, ?)");
        $insert->bind_param("is", $newMaDK, $MaHP);
        $insert->execute();
    }
}

header("Location: cart.php");
exit();
