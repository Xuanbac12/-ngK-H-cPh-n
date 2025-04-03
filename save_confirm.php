<?php
session_start();
include 'db.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

// Lấy MaDK mới nhất của sinh viên
$stmt = $conn->prepare("SELECT MaDK FROM DangKy WHERE MaSV = ? ORDER BY MaDK DESC LIMIT 1");
$stmt->bind_param("s", $MaSV);
$stmt->execute();
$res = $stmt->get_result();
$row = $res->fetch_assoc();

if ($row) {
    $MaDK = $row['MaDK'];

    // Lấy danh sách học phần trong MaDK đó
    $stmt = $conn->prepare("SELECT MaHP FROM ChiTietDangKy WHERE MaDK = ?");
    $stmt->bind_param("i", $MaDK);
    $stmt->execute();
    $result = $stmt->get_result();

    while ($hp = $result->fetch_assoc()) {
        // Giảm số lượng học phần tương ứng
        $updateStmt = $conn->prepare("UPDATE HocPhan SET Soluong = Soluong - 1 WHERE MaHP = ? AND Soluong > 0");
        $updateStmt->bind_param("s", $hp['MaHP']);
        $updateStmt->execute();
    }
}

echo "<script>
    alert('✅ Đăng ký học phần thành công!');
    window.location.href = 'result.php';
</script>";
