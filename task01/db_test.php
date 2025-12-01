<?php
// db_test.php — test nhanh kết nối DB và truy vấn users
// Dán vào task01/, mở trình duyệt tới http://your-host/path/task01/db_test.php

// Bật lỗi tạm thời (chỉ trong dev)
ini_set('display_errors', 1);
error_reporting(E_ALL);

require_once __DIR__ . '/db_connect.php';

echo "<h3>Test kết nối DB</h3>";

if (!isset($conn) || !($conn instanceof mysqli)) {
    echo "<p style='color:red'>\$conn không tồn tại hoặc không phải mysqli.</p>";
    echo "<pre>Kiểm tra file db_connect.php: ensure \$conn = new mysqli(...);</pre>";
    exit;
}

if ($conn->connect_errno) {
    echo "<p style='color:red'>Kết nối thất bại: (" . $conn->connect_errno . ") " . htmlspecialchars($conn->connect_error) . "</p>";
    exit;
}

echo "<p style='color:green'>Kết nối DB thành công.</p>";

// Thử truy vấn đơn giản
$res = $conn->query("SELECT 1 as ok");
if ($res === false) {
    echo "<p style='color:red'>Query test thất bại: " . htmlspecialchars($conn->error) . "</p>";
} else {
    echo "<p style='color:green'>Query test OK.</p>";
    $res->free();
}

// Thử lấy 1 user
if ($res2 = $conn->query("SELECT id, username, password, password_hash, full_name FROM users LIMIT 1")) {
    echo "<h4>users table sample row:</h4>";
    $row = $res2->fetch_assoc();
    if ($row) {
        echo "<pre>" . htmlspecialchars(print_r($row, true)) . "</pre>";
    } else {
        echo "<p>Không có bản ghi trong bảng users.</p>";
    }
    $res2->free();
} else {
    echo "<p style='color:red'>Truy vấn lấy users thất bại: " . htmlspecialchars($conn->error) . "</p>";
}

echo "<p>PHP error_log path: <strong>" . htmlspecialchars(ini_get('error_log')) . "</strong></p>";
?>