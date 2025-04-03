<?php
include 'header.php';
include 'db.php';

if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}
?>

<h3 class="text-primary">📘 DANH SÁCH HỌC PHẦN</h3>

<table class="table table-bordered table-hover align-middle">
    <thead class="table-dark">
        <tr>
            <th>Mã Học Phần</th>
            <th>Tên Học Phần</th>
            <th>Số Tín Chỉ</th>
            <th>Số lượng dự kiến</th>
            <th>Hành động</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $result = $conn->query("SELECT * FROM HocPhan");
        while ($row = $result->fetch_assoc()):
        ?>
        <tr>
            <td><?= $row['MaHP'] ?></td>
            <td><?= $row['TenHP'] ?></td>
            <td><?= $row['SoTinChi'] ?></td>
            <td><?= $row['Soluong'] ?></td>
            <td>
                <?php if ($row['Soluong'] > 0): ?>
                    <a href="register.php?MaHP=<?= $row['MaHP'] ?>" class="btn btn-success btn-sm">Đăng Kí</a>
                <?php else: ?>
                    <span class="text-danger">Hết chỗ</span>
                <?php endif; ?>
            </td>
        </tr>
        <?php endwhile; ?>
    </tbody>
</table>

<a href="students.php" class="btn btn-secondary">← Quay lại</a>


