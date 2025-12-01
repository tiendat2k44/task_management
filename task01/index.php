<!DOCTYPE html>
<html lang="en">
<head>
    <?php include "partials/head.php"; ?>
    <title>TaskMan | Hệ thống quản lý nhiệm vụ cá nhân</title>
</head>
<body>
    <div class="container">
        <!-- Navbar -->
        <?php include "partials/navbar.php"; ?>
        <!-- Kết nối CSDL -->
        <?php
            include "db_connect.php";
            // Phát biểu câu SQL
            $sql = "SELECT tasks.id, tasks.name AS taskName, tasks.status, tasks.due_date, categories.name AS categoryName FROM tasks JOIN categories ON tasks.category_id = categories.id";
            // Thực hiện truy vấn
            $result = $conn->query($sql);
        ?>
        <!-- Content -->
        <h2 class="text-primary mt-3">Danh sách nhiệm vụ cá nhân</h2>
        <a href="add.php" class="btn btn-success float-end mb-2">Thêm nhiệm vụ</a>
        <?php
            // Trình bày kết quả
            if ($result->num_rows > 0) {
                # Hiển thị bảng các nhiệm vụ
        ?>
        <table class="table table-bordered table-hover">
            <tr class="table-primary">
                <th class="text-center">#</th>
                <th>Tên nhiệm vụ</th>
                <th class="text-center">Trạng thái</th>
                <th class="text-center">Thời hạn</th>
                <th class="text-center">Danh mục</th>
                <th class="text-center">Thao tác</th>
            </tr>
        <?php
                // Lặp với từng nhiệm vụ
                while ($task = $result->fetch_assoc()) {
        ?>
                <tr>
                    <td class="text-center"><?php echo $task["id"]; ?></td>
                    <td><?php echo $task["taskName"]; ?></td>
                    <td class="text-center">
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
                    </td>
                    <td class="text-center"><?php echo date("d/m/Y", strtotime($task["due_date"])); ?></td>
                    <td class="text-center"><?php echo $task["categoryName"]; ?></td>
                    <td class="text-center">
                        <a href="view.php?id=<?php echo $task["id"]; ?>"><i class="fa-solid fa-eye"></i></a>
                        <a href="edit.php?id=<?php echo $task["id"]; ?>" class="text-warning"><i class="fa-solid fa-pencil"></i></a>
                        <a href="delete.php?id=<?php echo $task["id"]; ?>" class="text-danger"><i class="fa-solid fa-trash" onclick="return confirm('Bạn có chắc chắn muốn xóa nhiệm vụ này không?')"></i></a>
                    </td>
                </tr>
        <?php
                }
        ?>
        </table>
        <?php
            } else {
                # Hiển thị không có nhiệm vụ
        ?>
        <p class="text-secondary">Chưa có nhiệm vụ nào!</p>
        <?php
            }
        ?>
        <!-- Footer -->
        <?php include "partials/footer.php"; ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.8/dist/js/bootstrap.bundle.min.js" integrity="sha384-FKyoEForCGlyvwx9Hj09JcYn3nv7wiPVlz7YYwJrWVcXK/BmnVDxM+D2scQbITxI" crossorigin="anonymous"></script>
     <!-- <script src="bootstrap/bootstrap.min.js"></script> -->
</body>
</html>