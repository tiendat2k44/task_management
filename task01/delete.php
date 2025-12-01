<?php
// auth.php - include ở đầu các trang cần bảo vệ (phải trước mọi output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu chưa đăng nhập, lưu lại URL hiện tại và chuyển về login.php
if (empty($_SESSION['user'])) {
    // Lưu trang hiện tại để redirect về sau khi login
    $_SESSION['return_to'] = $_SERVER['REQUEST_URI'] ?? 'index.php';
    header('Location: login.php');
    exit;
}
// Lấy thông tin từ form thêm nhiệm vụ
$id = (int) $_GET["id"];

// Kết nối CSDL
include "db_connect.php";
// Phát biểu câu SQL thêm bản ghi
$sql = "DELETE FROM tasks WHERE id=$id";
// Thực hiện truy vấn và kiểm tra
if ($conn->query($sql) === TRUE) {
  echo "Đã xóa nhiệm vụ.";
} else {
  echo "Lỗi: " . $sql . "<br>" . $conn->error;
}