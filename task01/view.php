<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "partials/head.php"; ?>
    <title>TaskMan | Xem nhiệm vụ cá nhân</title>
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <?php include "partials/navbar.php"; ?>
        <?php
            // Hiển thị lỗi
            // error_reporting(E_ALL);
            // Kết nối CSDL
            include "db_connect.php";
            // Lấy id của nhiệm vụ
            $id =(int) $_GET["id"];
            // Phát biểu câu SQL
            $sql = "SELECT * FROM tasks WHERE id=$id";
            // Thực hiện truy vấn
            $task = $conn->query($sql)->fetch_assoc();
        ?>
        <!-- Hiển thị thông tin nhiệm vụ -->
        <div class="card mt-3">
            <div class="card-header"><span class="text-primary fw-bold"><?php echo $task["name"]; ?></span></div>
            <div class="card-body">
                <p>
                Trạng thái: 
                <?php
                switch ($task["status"]) {
                    case '0':
                        echo "<span class='p-1 rounded-3 text-white bg-secondary'>Chưa thực hiện</span>";
                        break;
                    case '1':
                        echo "<span class='p-1 rounded-3 text-white bg-success'>Đang thực hiện</span>";
                        break;
                    case '2':
                        echo "<span class='p-1 rounded-3 text-white bg-primary'>Hoàn thành</span>";
                        break;
                    case '3':
                        echo "<span class='p-1 rounded-3 text-white bg-danger'>Không hoàn thành</span>";
                        break;
                }
                ?>
                </p>
                <p class="text-danger">Thêm các thông tin khác</p>
                <a href="edit.php?id=<?php echo $id; ?>" class="btn btn-warning">Sửa nhiệm vụ</a>
                <a href="delete.php?id=<?php echo $id; ?>" class="btn btn-danger">Xóa nhiệm vụ</a>
            </div>
        </div>
        <!-- Footer -->
        <?php include "partials/footer.php"; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
     <!-- <script src="bootstrap/bootstrap.min.js"></script> -->
</body>
</html>