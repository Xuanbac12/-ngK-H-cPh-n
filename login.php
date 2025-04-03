<?php
session_start();
include 'db.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $MaSV = $_POST['username'];
    $MatKhau = $_POST['password'];

    // Chuẩn bị truy vấn
    $stmt = $conn->prepare("SELECT * FROM SinhVien WHERE MaSV = ? AND MatKhau = ?");
    
    if (!$stmt) {
        die("Lỗi prepare: " . $conn->error); // Nếu lỗi câu lệnh SQL
    }

    $stmt->bind_param("ss", $MaSV, $MatKhau);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result && $result->num_rows == 1) {
        $_SESSION['MaSV'] = $MaSV;
        header("Location: students.php"); // Đăng nhập thành công
        exit();
    } else {
        $error = "❌ Sai mã sinh viên hoặc mật khẩu!";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .login-container {
            width: 400px;
            margin: 100px auto;
            border: 1px solid #ccc;
            padding: 30px;
            border-radius: 10px;
            background-color: #f9f9f9;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h3 class="text-center mb-4">🎓 Đăng nhập</h3>

        <?php if ($error): ?>
            <div class="alert alert-danger"><?= $error ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="mb-3">
                <label class="form-label">Mã sinh viên</label>
                <input type="text" name="username" class="form-control" required placeholder="Nhập mã sinh viên">
            </div>
            <div class="mb-3">
                <label class="form-label">Mật khẩu</label>
                <input type="password" name="password" class="form-control" required placeholder="Nhập mật khẩu">
            </div>
            <button type="submit" class="btn btn-primary w-100">Đăng nhập</button>
        </form>
    </div>
</body>
</html>
