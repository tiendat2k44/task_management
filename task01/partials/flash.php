<?php
// partials/flash.php
// Hiển thị 1 flash message được lưu trong $_SESSION['flash']
// Cấu trúc $_SESSION['flash'] = ['type'=>'success'|'danger'|'info'|'warning', 'message'=>'...']

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!empty($_SESSION['flash'])) {
    $f = $_SESSION['flash'];
    $type = $f['type'] ?? 'info';
    $msg  = $f['message'] ?? '';
    // Xóa ngay để không hiển thị lại sau reload
    unset($_SESSION['flash']);
    echo '<div class="container mt-3"><div class="alert alert-' . htmlspecialchars($type) . ' alert-dismissible fade show" role="alert">'
        . htmlspecialchars($msg) .
        '<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>'
        . '</div></div>';
}
?>