<?php
// auth.php - include ở đầu các trang cần bảo vệ (phải trước mọi output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
if (empty($_SESSION['user'])) {
    $_SESSION['return_to'] = $_SERVER['REQUEST_URI'] ?? 'index.php';
    header('Location: login.php');
    exit;
}
?>