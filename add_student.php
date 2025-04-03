<?php
include 'db.php';
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['MaSV'];
    $HoTen = $_POST['HoTen'];
    $GioiTinh = $_POST['GioiTinh'];
    $NgaySinh = $_POST['NgaySinh'];
    $MaNganh = $_POST['MaNganh'];
    $target_dir = "Content/images/";
    $image_name = basename($_FILES["Hinh"]["name"]);
    $target_file = $target_dir . $image_name;

    if (move_uploaded_file($_FILES["Hinh"]["tmp_name"], $target_file)) {
        $Hinh = "/Content/images/" . $image_name;
        $sql = "INSERT INTO SinhVien (MaSV, HoTen, GioiTinh, NgaySinh, Hinh, MaNganh)
                VALUES ('$MaSV', '$HoTen', '$GioiTinh', '$NgaySinh', '$Hinh', '$MaNganh')";
        if ($conn->query($sql)) {
            echo "<div class='alert alert-success'>✔️ Thêm thành công. <a href='students.php'>Về danh sách</a></div>";
        } else {
            echo "<div class='alert alert-danger'>❌ Lỗi: " . $conn->error . "</div>";
        }
    } else {
        echo "<div class='alert alert-danger'>❌ Upload ảnh thất bại.</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thêm Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">
    <h2>➕ Thêm sinh viên</h2>
    <form method="post" enctype="multipart/form-data">
        <div class="mb-3">
            <label class="form-label">MaSV</label>
            <input type="text" class="form-control" name="MaSV" required>
        </div>
        <div class="mb-3">
            <label class="form-label">HoTen</label>
            <input type="text" class="form-control" name="HoTen" required>
        </div>
        <div class="mb-3">
            <label class="form-label">GioiTinh</label>
            <input type="text" class="form-control" name="GioiTinh">
        </div>
        <div class="mb-3">
            <label class="form-label">NgaySinh</label>
            <input type="date" class="form-control" name="NgaySinh">
        </div>
        <div class="mb-3">
            <label class="form-label">Hinh</label>
            <input type="file" class="form-control" name="Hinh">
        </div>
        <div class="mb-3">
            <label class="form-label">MaNganh</label>
            <input type="text" class="form-control" name="MaNganh">
        </div>
        <button type="submit" class="btn btn-success">Create</button>
        <a href="students.php" class="btn btn-secondary">← Quay lại</a>
    </form>
</body>
</html>
