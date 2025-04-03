<?php
session_start();
if (!isset($_SESSION['MaSV'])) {
    header("Location: login.php");
    exit();
}

include 'db.php';
include 'header.php';
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Trang Sinh Viên</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body class="container mt-4">

    <h2 class="mb-3 text-primary">
        📋 Danh sách sinh viên
    </h2>

    <a href="add_student.php" class="btn btn-success mb-3">+ Thêm sinh viên</a>

    <table class="table table-bordered table-striped align-middle">
        <thead class="table-dark">
            <tr>
                <th>MaSV</th>
                <th>HoTen</th>
                <th>GioiTinh</th>
                <th>NgaySinh</th>
                <th>Hinh</th>
                <th>MaNganh</th>
                <th>Thao tác</th>
            </tr>
        </thead>
        <tbody>
        <?php
        // Phân trang
        $limit = 4;
        $page = $_GET['page'] ?? 1;
        $offset = ($page - 1) * $limit;

        $sql = "SELECT * FROM SinhVien LIMIT $limit OFFSET $offset";
        $result = $conn->query($sql);

        while ($row = $result->fetch_assoc()) {
            echo "<tr>
                    <td>{$row['MaSV']}</td>
                    <td>{$row['HoTen']}</td>
                    <td>{$row['GioiTinh']}</td>
                    <td>" . date('d/m/Y', strtotime($row['NgaySinh'])) . "</td>
                    <td><img src='http://localhost/KIEMTRA2{$row["Hinh"]}' class='img-thumbnail' style='max-width: 120px; height: auto;'></td>
                    <td>{$row['MaNganh']}</td>
                    <td>
                        <a class='btn btn-sm btn-primary' href='edit_student.php?MaSV={$row['MaSV']}'>Edit</a>
                        <a class='btn btn-sm btn-info text-white' href='view_student.php?MaSV={$row['MaSV']}'>Details</a>
                        <a class='btn btn-sm btn-danger' href='delete_student.php?MaSV={$row['MaSV']}' onclick=\"return confirm('Bạn có chắc muốn xóa?');\">Delete</a>
                    </td>
                  </tr>";
        }

        // Tổng số trang
        $total_rows = $conn->query("SELECT COUNT(*) AS total FROM SinhVien")->fetch_assoc()['total'];
        $total_pages = ceil($total_rows / $limit);
        ?>
        </tbody>
    </table>

    <!-- Phân trang -->
    <nav>
      <ul class="pagination">
        <?php for ($i = 1; $i <= $total_pages; $i++): ?>
          <li class="page-item <?= ($i == $page) ? 'active' : '' ?>">
            <a class="page-link" href="?page=<?= $i ?>"><?= $i ?></a>
          </li>
        <?php endfor; ?>
      </ul>
    </nav>

</body>
</html>
