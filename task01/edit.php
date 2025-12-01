<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "partials/head.php"; ?>
    <title>Sửa nhiệm vụ | TaskMan</title>
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <?php include "partials/navbar.php"; ?>
        <?php
        // Lấy id nhiệm vụ
        $id =(int) $_GET["id"];
        // Kết nối CSDL
        include "db_connect.php";
        // Phát biểu câu SQL
        $sql = "SELECT * FROM tasks WHERE id=$id";
        // Thực hiện truy vấn
        $task = $conn->query($sql)->fetch_assoc();
        ?>
        <!-- Form thêm nhiệm vụ mới -->
         <h2 class="mt-3">Sửa nhiệm vụ</h2>
         <form action="update.php" method="post">
            <input type="hidden" name="id" value="<?php echo $id; ?>">
            <div class="mb-3 mt-3">
                <label for="name" class="form-label">Tên nhiệm vụ <span class="text-danger">*</span></label>
                <input type="text" class="form-control" id="name" name="name" value="<?php echo $task["name"]; ?>" required>
            </div>
            <div class="mb-3 mt-3">
                <label for="status" class="form-label">Trạng thái <span class="text-danger">*</span></label>
                <!-- Mã hóa bằng code (KHÔNG KHUYÊN DÙNG) -->
                <select class="form-control" id="status" name="status">
                    <option value="0" <?php echo ($task["status"] == "0") ? "selected" : ""; ?>>Chưa thực hiện</option>
                    <option value="1" <?php echo ($task["status"] == "1") ? "selected" : ""; ?>>Đang thực hiện</option>
                    <option value="2" <?php echo ($task["status"] == "2") ? "selected" : ""; ?>>Hoàn thành</option>
                    <option value="3" <?php echo ($task["status"] == "3") ? "selected" : ""; ?>>Không hoàn thành</option>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <label for="due_date" class="form-label">Thời hạn hoàn thành <span class="text-danger">*</span></label>
                <input type="date" class="form-control" id="due_date" name="due_date" value="<?php echo date("Y-m-d", strtotime($task["due_date"])); ?>" required>
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
                    <option value="<?php echo $category["id"]; ?>" <?php echo ($task["category_id"] == $category["id"]) ? "selected" : ""; ?>><?php echo $category["name"]; ?></option>
                    <?php
                        }
                    ?>
                </select>
            </div>
            <div class="mb-3 mt-3">
                <input type="submit" value="Cập nhật" class="btn btn-success">
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