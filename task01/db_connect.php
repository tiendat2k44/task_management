<?php
// Khai báo thông tin kết nối CSDL
$server = "localhost"; // Tên máy chủ
$user = "root"; // Tên người dùng CSDL
$pwd = "1508"; // Mật khẩu người dùng CSDL
$db_name = "task_management"; // Tên CSDL

// Bật reporting dưới dạng exception để bắt nhiều lỗi hơn có kiểm soát
mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

try {
    // Tạo kết nối
    $conn = new mysqli($server, $user, $pwd, $db_name);
    // Thiết lập charset an toàn
    $conn->set_charset('utf8mb4');
    // Kết nối thành công
} catch (mysqli_sql_exception $e) {
    // Ghi lại log nội bộ (không hiển thị ra client)
    error_log("[db_connect] Kết nối CSDL thất bại: " . $e->getMessage());

    // Thông báo thân thiện cho người dùng (không hiển thị chi tiết bảo mật)
    echo "Không thể kết nối cơ sở dữ liệu. Vui lòng thử lại sau.";
    // Ngoài ra có thể exit hoặc throw tiếp tùy nghiệp vụ
    exit;
}
// echo "Kết nối CSDL thành công!";