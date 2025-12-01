<?php
// auth.php - include ở đầu các trang cần bảo vệ (phải trước mọi output)
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Nếu chưa đăng nhập, lưu lại URL hiện tại và chuyển về login.php
if (empty($_SESSION['user'])) {
    // Lưu trang hiện tại để redirect về sau khi login
    $_SESSION['return_to'] = $_SERVER['REQUEST_URI'] ?? 'index.php';
    header('Location: login.php');
    exit;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "partials/head.php"; ?>
    <title>Thêm nhiệm vụ mới | TaskMan</title>
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <?php include "partials/navbar.php"; ?>
        <!-- Form thêm nhiệm vụ mới -->
         <h2 class="mt-3">Thêm nhiệm vụ mới</h2>
         <form action="insert.php" method="post">
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Tên nhiệm vụ <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                <!-- Mã hóa bằng code (KHÔNG KHUYÊN DÙNG) -->
                <select class="form-control" id="status" name="status">
                    <option value="0">Chưa thực hiện</option>
                    <option value="1">Đang thực hiện</option>
                    <option value="2">Hoàn thành</option>
                    <option value="3">Không hoàn thành</option>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="due_date" class="form-label">Thời hạn hoàn thành <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="due_date" name="due_date" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="category_id" class="form-label">Danh mục <span class="text-danger">*</span></label>
                <!-- Truy vấn tất cả danh mục (KHUYÊN DÙNG) -->
                <?php
                    include "db_connect.php";
                    // Phát biểu câu SQL
                    $sql = "SELECT * FROM categories";
                    // Thực hiện truy vấn
                    $result = $conn->query($sql);
                ?>
                <select class="form-control" id="category_id" name="category_id">
                    <?php
                        // Lặp với từng danh mục
                        while ($category = $result->fetch_assoc()) {
                    ?>
                    <option value="<?php echo $category["id"]; ?>"><?php echo $category["name"]; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <input type="submit" value="Thêm" class="btn btn-success">
                <input type="reset" value="Nhập lại" class="btn btn-secondary">
            </div>
         </form>
        <!-- Footer -->
        <?php include "partials/footer.php"; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
     <!-- <script src="bootstrap/bootstrap.min.js"></script> -->
</body>
</html>