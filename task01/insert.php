<?php
// Lấy thông tin từ form thêm nhiệm vụ
$name = $_POST["name"];
$status = $_POST["status"];
$due_date = date('Y-m-d H:i:s', strtotime($_POST['due_date']));
$category_id = (int) $_POST['category_id'];
$user_id = 1; // Chưa xử lý, lấy id của admin

// Kết nối CSDL
include "db_connect.php";
// Phát biểu câu SQL thêm bản ghi
$sql = "INSERT INTO tasks (name, status, due_date, category_id, user_id) VALUES ('$name', '$status','$due_date','$category_id', '$user_id')";
// Thực hiện truy vấn và kiểm tra
if ($conn->query($sql) === TRUE) {
  echo "Đã thêm nhiệm vụ.";
} else {
  echo "Lỗi: " . $sql . "<br>" . $conn->error;
}