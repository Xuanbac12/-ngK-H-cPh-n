<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

// Thông tin sinh viên
$stmt = $conn->prepare("SELECT * FROM SinhVien sv JOIN NganhHoc nh ON sv.MaNganh = nh.MaNganh WHERE MaSV = ?");
$stmt->bind_param("s", $MaSV);
$stmt->execute();
$sv = $stmt->get_result()->fetch_assoc();

// Lấy học phần mới đăng ký (MaDK mới nhất)
$stmt = $conn->prepare("SELECT dk.MaDK, hp.MaHP, hp.TenHP, hp.SoTinChi
                        FROM DangKy dk
                        JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK
                        JOIN HocPhan hp ON hp.MaHP = ctdk.MaHP
                        WHERE dk.MaSV = ?
                        ORDER BY dk.MaDK DESC LIMIT 5");
$stmt->bind_param("s", $MaSV);
$stmt->execute();
$result = $stmt->get_result();

$hocPhanList = [];
$tongTinChi = 0;

while ($row = $result->fetch_assoc()) {
    $hocPhanList[] = $row;
    $tongTinChi += $row['SoTinChi'];
}

?>

<h3 class="text-primary">Đăng Kí học phần</h3>

<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th>MaHP</th>
            <th>Tên Học Phần</th>
            <th>Số Chi Chỉ</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hocPhanList as $hp): ?>
        <tr>
            <td><?= $hp['MaHP'] ?></td>
            <td><?= $hp['TenHP'] ?></td>
            <td><?= $hp['SoTinChi'] ?></td>
        </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p class="text-danger">Số lượng học phần: <?= count($hocPhanList) ?></p>
<p class="text-danger">Tổng số tín chỉ: <?= $tongTinChi ?></p>

<a href="cart.php" class="btn btn-link">↩️ Trở về giỏ hàng</a>

<hr>

<div class="border p-4 bg-light rounded" style="max-width: 600px;">
    <h5 class="mb-3 text-center text-dark">📄 <strong>Thông tin Đăng kí</strong></h5>
    <p><strong>Mã số sinh viên:</strong> <?= $sv['MaSV'] ?></p>
    <p><strong>Họ Tên Sinh Viên:</strong> <?= $sv['HoTen'] ?></p>
    <p><strong>Ngày sinh:</strong> <?= date('d/m/Y', strtotime($sv['NgaySinh'])) ?></p>
    <p><strong>Ngành học:</strong> <?= $sv['TenNganh'] ?></p>
    <p><strong>Ngày đăng kí:</strong> <?= date('d/m/Y') ?></p>

    <form method="POST" action="save_confirm.php">
        <button type="submit" class="btn btn-success">✅ Xác Nhận</button>
    </form>
</div>


