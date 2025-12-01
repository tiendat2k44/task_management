<?php
if (session_status() === PHP_SESSION_NONE) session_start();
// Lấy thông tin từ form thêm nhiệm vụ (giữ giống mẫu)
$name = $_POST["name"] ?? '';
$status = $_POST["status"] ?? '0';
$due_date = !empty($_POST['due_date']) ? date('Y-m-d H:i:s', strtotime($_POST['due_date'])) : null;
$category_id = (int) ($_POST['category_id'] ?? 0);
$user_id = $_SESSION['user']['id'] ?? 1; // nếu có session user thì lấy, còn không giữ 1

include __DIR__ . '/db_connect.php';

if ($name === '' || $category_id <= 0 || $due_date === null) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Dữ liệu không hợp lệ.'];
    header('Location: add.php');
    exit;
}

try {
    // Giữ cấu trúc SQL giống mẫu nhưng thêm created_at, updated_at = NOW()
    $name_esc = $conn->real_escape_string($name);
    $status_esc = $conn->real_escape_string($status);
    $due_date_esc = $conn->real_escape_string($due_date);
    $sql = "INSERT INTO tasks (name, status, due_date, category_id, user_id, created_at, updated_at) VALUES ('$name_esc', '$status_esc', '$due_date_esc', $category_id, $user_id, NOW(), NOW())";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đã thêm nhiệm vụ.'];
        header('Location: index.php');
        exit;
    } else {
        error_log('[insert] ' . $conn->error);
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Thêm thất bại: ' . $conn->error];
        header('Location: add.php');
        exit;
    }
} catch (Exception $e) {
    error_log('[insert][Exception] ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Thêm thất bại, vui lòng thử lại.'];
    header('Location: add.php');
    exit;
}
?>