<?php
include 'db.php';
$MaSV = $_GET['MaSV'];

// Lấy thông tin sinh viên hiện tại
$row = $conn->query("SELECT * FROM SinhVien WHERE MaSV='$MaSV'")->fetch_assoc();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];

    // Kiểm tra nếu có hình mới được upload
    if (isset($_FILES['Hinh']) && $_FILES['Hinh']['error'] == 0) {
        $filename = $_FILES['Hinh']['name'];
        $tmpname = $_FILES['Hinh']['tmp_name'];
        $path = "Content/images/" . $filename;
        move_uploaded_file($tmpname, $path);

        // Cập nhật với hình mới
        $sql = "UPDATE SinhVien SET HoTen='$HoTen', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', MaNganh='$MaNganh', Hinh='/$path' WHERE MaSV='$MaSV'";
    } else {
        // Cập nhật không đổi hình
        $sql = "UPDATE SinhVien SET HoTen='$HoTen', GioiTinh='$GioiTinh', NgaySinh='$NgaySinh', MaNganh='$MaNganh' WHERE MaSV='$MaSV'";
    }

    if ($conn->query($sql)) {
        echo "<div class='alert alert-success'>✔️ Cập nhật thành công. <a href='students.php'>Quay lại danh sách</a></div>";
        $row = $conn->query("SELECT * FROM SinhVien WHERE MaSV='$MaSV'")->fetch_assoc(); // cập nhật lại $row
    } else {
        echo "<div class='alert alert-danger'>❌ Lỗi: " . $conn->error . "</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Sửa Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>✏️ Sửa sinh viên</h2>

    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">Họ Tên</label>
            <input type="text" class="form-control" name="HoTen" value="<?= $row['HoTen'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Giới Tính</label>
            <input type="text" class="form-control" name="GioiTinh" value="<?= $row['GioiTinh'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Ngày Sinh</label>
            <input type="date" class="form-control" name="NgaySinh" value="<?= $row['NgaySinh'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Mã Ngành</label>
            <input type="text" class="form-control" name="MaNganh" value="<?= $row['MaNganh'] ?>" required>
        </div>

        <div class="mb-3">
            <label class="form-label">Hình hiện tại</label><br>
            <img src="http://localhost/KIEMTRA2<?= $row['Hinh'] ?>" style="max-height: 120px;" class="img-thumbnail">
        </div>

        <div class="mb-3">
            <label class="form-label">Chọn hình mới (nếu muốn thay)</label>
            <input type="file" class="form-control" name="Hinh">
        </div>

        <button type="submit" class="btn btn-primary">Cập nhật</button>
        <a href="students.php" class="btn btn-secondary">← Quay lại</a>
    </form>
</body>
</html>
