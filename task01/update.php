<?php
if (session_status() === PHP_SESSION_NONE) session_start();

$id = (int) ($_POST["id"] ?? 0);
$name = $_POST["name"] ?? '';
$status = $_POST["status"] ?? '0';
$due_date = !empty($_POST['due_date']) ? date('Y-m-d H:i:s', strtotime($_POST['due_date'])) : null;
$category_id = (int) ($_POST['category_id'] ?? 0);

include __DIR__ . '/db_connect.php';

if ($id <= 0 || $name === '' || $category_id <= 0 || $due_date === null) {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Dữ liệu không hợp lệ.'];
    header('Location: edit.php?id=' . $id);
    exit;
}

try {
    // Giữ logic, chỉ thêm updated_at = NOW()
    $name_esc = $conn->real_escape_string($name);
    $status_esc = $conn->real_escape_string($status);
    $due_date_esc = $conn->real_escape_string($due_date);
    $sql = "UPDATE tasks SET name='$name_esc', status='$status_esc', due_date='$due_date_esc', category_id=$category_id, updated_at = NOW() WHERE id=$id";

    if ($conn->query($sql) === TRUE) {
        $_SESSION['flash'] = ['type' => 'success', 'message' => 'Cập nhật thành công.'];
        header('Location: index.php');
        exit;
    } else {
        error_log('[update] ' . $conn->error);
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Cập nhật thất bại: ' . $conn->error];
        header('Location: edit.php?id=' . $id);
        exit;
    }
} catch (Exception $e) {
    error_log('[update][Exception] ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Cập nhật thất bại, vui lòng thử lại.'];
    header('Location: edit.php?id=' . $id);
    exit;
}
?>