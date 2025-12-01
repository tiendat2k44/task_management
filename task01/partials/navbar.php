<?php
// head.php đã start session; kiểm tra an toàn
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>
<nav class="navbar navbar-expand-sm bg-success navbar-dark">
    <div class="container-fluid">
        <a class="navbar-brand" href="index.php">TaskMan</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#collapsibleNavbar">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="collapsibleNavbar">
            <ul class="navbar-nav me-auto">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Nhiệm vụ</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="add.php">Thêm nhiệm vụ mới</a></li>
                        <li><a class="dropdown-item" href="#">Quản lý Nhiệm vụ</a></li>
                        <li><a class="dropdown-item" href="#">Quản lý Danh mục</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown">Người dùng</a>
                    <ul class="dropdown-menu">
                        <li><a class="dropdown-item" href="#">Thêm người dùng</a></li>
                        <li><a class="dropdown-item" href="#">Quản lý người dùng</a></li>
                    </ul>
                </li>
            </ul>

            <!-- Phần hiển thị ở bên phải -->
            <ul class="navbar-nav ms-auto">
                <?php if (!empty($_SESSION['user'])): ?>
                    <li class="nav-item">
                        <span class="nav-link">Xin chào, <?php echo htmlspecialchars($_SESSION['user']['full_name'] ?? $_SESSION['user']['username']); ?></span>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="logout.php">Đăng xuất</a>
                    </li>
                <?php else: ?>
                    <li class="nav-item">
                        <a class="nav-link" href="login.php">Đăng nhập</a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>