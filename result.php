<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

// Lấy thông tin đăng ký gần nhất
$stmt = $conn->prepare("SELECT dk.MaDK, hp.MaHP, hp.TenHP, hp.SoTinChi
                        FROM DangKy dk
                        JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK
                        JOIN HocPhan hp ON hp.MaHP = ctdk.MaHP
                        WHERE dk.MaSV = ?
                        ORDER BY dk.MaDK DESC LIMIT 5");
$stmt->bind_param("s", $MaSV);
$stmt->execute();
$result = $stmt->get_result();
?>

<h3 class="text-success">🎉 Thông Tin Học Phần Đã Lưu</h3>

<table class="table table-bordered">
    <thead>
        <tr>
            <th>Mã Học Phần</th>
            <th>Tên Học Phần</th>
            <th>Số Tín Chỉ</th>
        </tr>
    </thead>
    <tbody>
        <?php while ($row = $result->fetch_assoc()): ?>
            <tr>
                <td><?= $row['MaHP'] ?></td>
                <td><?= $row['TenHP'] ?></td>
                <td><?= $row['SoTinChi'] ?></td>
            </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="students.php" class="btn btn-outline-primary">Về trang chủ</a>

