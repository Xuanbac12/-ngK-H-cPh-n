<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Test1</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Bootstrap 5 JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark bg-dark">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Test1</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav"
      aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav me-auto mb-2 mb-lg-0">
        <li class="nav-item">
          <a class="nav-link" href="students.php">Sinh Viên</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="courses.php">Học Phần</a>
        </li>
        <li class="nav-item">
  <a class="nav-link" href="cart.php">🛒 Đăng Kí (Giỏ)</a>
</li>

        <li class="nav-item">
          <a class="nav-link" href="login.php">Đăng Nhập</a>
        </li>
      </ul>
      <?php if (isset($_SESSION['MaSV'])): ?>
        <span class="navbar-text text-white me-3">
          Xin chào: <strong><?= $_SESSION['MaSV'] ?></strong>
        </span>
        <a href="logout.php" class="btn btn-outline-light btn-sm">Đăng xuất</a>
      <?php endif; ?>
    </div>
  </div>
</nav>

<div class="container mt-4">
