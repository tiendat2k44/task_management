<?php
if (session_status() === PHP_SESSION_NONE) session_start();
session_unset();
session_destroy();
session_start();
$_SESSION['flash'] = ['type' => 'success', 'message' => 'Bạn đã đăng xuất.'];
header('Location: login.php');
exit;
?>