<?php
// Hiển thị lỗi
error_reporting();
// Lấy thông tin từ form thêm nhiệm vụ
$id = (int) $_POST["id"];
$name = $_POST["name"];
$status = $_POST["status"];
$due_date = date('Y-m-d H:i:s', strtotime($_POST['due_date']));
$category_id = (int) $_POST['category_id'];
$user_id = 1; // Chưa xử lý, lấy id của admin

// Kết nối CSDL
include "db_connect.php";
// Phát biểu câu SQL thêm bản ghi
$sql = "UPDATE tasks SET name='$name', status='$status', due_date='$due_date', category_id='$category_id' WHERE id=$id";
// Thực hiện truy vấn và kiểm tra
if ($conn->query($sql) === TRUE) {
  echo "Đã sửa nhiệm vụ.";
} else {
  echo "Lỗi: " . $sql . "<br>" . $conn->error;
}