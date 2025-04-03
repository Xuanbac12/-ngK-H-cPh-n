<?php
include 'db.php';
$MaSV = $_GET['MaSV'];
$row = $conn->query("SELECT * FROM SinhVien WHERE MaSV='$MaSV'")->fetch_assoc();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Chi tiết Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>🔎 Thông tin chi tiết</h2>
    <ul class="list-group">
        <li class="list-group-item"><strong>Mã SV:</strong> <?= $row['MaSV'] ?></li>
        <li class="list-group-item"><strong>Họ tên:</strong> <?= $row['HoTen'] ?></li>
        <li class="list-group-item"><strong>Giới tính:</strong> <?= $row['GioiTinh'] ?></li>
        <li class="list-group-item"><strong>Ngày sinh:</strong> <?= $row['NgaySinh'] ?></li>
        <li class="list-group-item"><strong>Ngành:</strong> <?= $row['MaNganh'] ?></li>
        <li class="list-group-item"><img src="http://localhost/KIEMTRA2<?= $row['Hinh'] ?>" class="img-thumbnail" width="150"></li>
    </ul>
    <br>
    <a href="students.php" class="btn btn-secondary">← Quay lại</a>
</body>
</html>
