<?php
session_start();         // Bắt đầu session (nếu chưa có)
session_unset();         // Xóa tất cả biến session
session_destroy();       // Hủy phiên session

header("Location: login.php"); // Chuyển hướng về trang đăng nhập
exit();
