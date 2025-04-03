<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

$MaSV = $_SESSION['MaSV'];

// Lấy tất cả MaDK của sinh viên hiện tại
$sql = "SELECT dk.MaDK, dk.NgayDK, hp.MaHP, hp.TenHP, hp.SoTinChi 
        FROM DangKy dk
        JOIN ChiTietDangKy ctdk ON dk.MaDK = ctdk.MaDK
        JOIN HocPhan hp ON hp.MaHP = ctdk.MaHP
        WHERE dk.MaSV = ?
        ORDER BY dk.MaDK DESC";

$stmt = $conn->prepare($sql);
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

<h3 class="text-primary">🛒 Đăng Kí Học Phần</h3>

<?php if (count($hocPhanList) > 0): ?>
<table class="table table-bordered align-middle">
    <thead class="table-light">
        <tr>
            <th>MãHP</th>
            <th>Tên Học Phần</th>
            <th>Số Tín Chỉ</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($hocPhanList as $hp): ?>
            <tr>
                <td><?= $hp['MaHP'] ?></td>
                <td><?= $hp['TenHP'] ?></td>
                <td><?= $hp['SoTinChi'] ?></td>
                <td><a href="remove.php?MaHP=<?= $hp['MaHP'] ?>" class="text-danger">❌ Xoá</a></td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<p><strong class="text-danger">Số học phần: <?= count($hocPhanList) ?></strong></p>
<p><strong class="text-danger">Tổng số tín chỉ: <?= $tongTinChi ?></strong></p>

<a href="clear_cart.php" class="btn btn-outline-danger btn-sm">Xoá Đăng Kí</a>
<a href="save_register.php" class="btn btn-primary btn-sm">Lưu đăng ký</a>

<?php else: ?>
    <p>Chưa có học phần nào được đăng ký.</p>
<?php endif; ?>



