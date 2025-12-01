<?php
// login.php
// Không include auth.php ở đây (tránh redirect vòng lặp).
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// Nếu đã đăng nhập thì về index
if (!empty($_SESSION['user'])) {
    header('Location: index.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="vi">
<head>
    <?php include __DIR__ . '/partials/head.php'; ?>
    <title>Đăng nhập | TaskMan</title>
</head>
<body>
    <div class="container">
        <?php include __DIR__ . '/partials/navbar.php'; ?>
        <?php include __DIR__ . '/partials/flash.php'; ?>

        <div class="row justify-content-center">
            <div class="col-md-6">
                <h3 class="mt-4">Đăng nhập</h3>
                <!-- CHÚ Ý: method="post" và action trỏ đúng file xử lý -->
                <form action="login_process.php" method="post" autocomplete="off" novalidate>
                    <div class="mb-3">
                        <label for="username" class="form-label">Tên đăng nhập</label>
                        <input type="text" class="form-control" id="username" name="username" required autofocus />
                    </div>
                    <div class="mb-3">
                        <label for="password" class="form-label">Mật khẩu</label>
                        <input type="password" class="form-control" id="password" name="password" required />
                    </div>
                    <button type="submit" class="btn btn-primary">Đăng nhập</button>
                </form>
            </div>
        </div>

        <?php include __DIR__ . '/partials/footer.php'; ?>
    </div>
</body>
</html>