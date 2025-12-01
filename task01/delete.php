<?php
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