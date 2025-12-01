<?php
// login_process.php - tự động tạo cột password_hash nếu thiếu, hỗ trợ migrate SHA1/plain -> password_hash
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Lấy POST
$username = trim($_POST['username'] ?? '');
$password = $_POST['password'] ?? '';

if ($username === '' || $password === '') {
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Vui lòng nhập tên đăng nhập và mật khẩu.'];
    header('Location: login.php');
    exit;
}

require_once __DIR__ . '/db_connect.php';

try {
    // Kiểm tra và tạo cột password_hash nếu chưa tồn tại
    try {
        $colCheck = $conn->query("SHOW COLUMNS FROM `users` LIKE 'password_hash'");
        if ($colCheck === false) {
            // nếu trả false, log và tiếp tục (mysqli_report có thể ném exception)
            error_log('[login_process] SHOW COLUMNS trả false: ' . $conn->error);
        } else {
            if ($colCheck->num_rows === 0) {
                // tạo cột
                $conn->query("ALTER TABLE `users` ADD COLUMN `password_hash` VARCHAR(255) NULL");
                error_log('[login_process] Đã thêm cột password_hash vào bảng users.');
            }
            $colCheck->free();
        }
    } catch (Exception $e) {
        // Log nhưng không dừng toàn bộ quá trình (tránh lặp error gây UX tệ)
        error_log('[login_process] Exception khi kiểm tra/tạo cột password_hash: ' . $e->getMessage());
    }

    // Chuẩn bị truy vấn lấy user
    $stmt = $conn->prepare("SELECT * FROM `users` WHERE username = ? LIMIT 1");
    if ($stmt === false) {
        error_log('[login_process] Prepare failed: ' . $conn->error);
        throw new Exception('Lỗi truy vấn (prepare).');
    }
    $stmt->bind_param('s', $username);
    if (!$stmt->execute()) {
        error_log('[login_process] Execute failed: ' . $stmt->error);
        throw new Exception('Không thực thi được truy vấn.');
    }

    // Lấy kết quả
    $user = null;
    if (method_exists($stmt, 'get_result')) {
        $res = $stmt->get_result();
        $user = $res->fetch_assoc();
        if ($res) $res->free();
    } else {
        // fallback bind_result (nếu get_result không khả dụng)
        $meta = $stmt->result_metadata();
        if ($meta) {
            $row = [];
            $bindParams = [];
            while ($field = $meta->fetch_field()) {
                $row[$field->name] = null;
                $bindParams[] = &$row[$field->name];
            }
            call_user_func_array([$stmt, 'bind_result'], $bindParams);
            if ($stmt->fetch()) {
                $user = $row;
            }
        }
    }

    if (!$user) {
        $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.'];
        header('Location: login.php');
        exit;
    }

    // 1) Nếu có password_hash -> dùng password_verify
    if (!empty($user['password_hash'])) {
        if (password_verify($password, $user['password_hash'])) {
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'] ?? $user['username'],
            ];
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đăng nhập thành công.'];
            $dest = $_SESSION['return_to'] ?? 'index.php';
            unset($_SESSION['return_to']);
            header('Location: ' . $dest);
            exit;
        }
    }

    // 2) Nếu có cột password -> kiểm tra SHA1 hoặc plain
    if (isset($user['password'])) {
        // SHA1 check (độ dài 40)
        if (strlen($user['password']) === 40 && hash('sha1', $password) === $user['password']) {
            // migrate -> lưu password_hash (nếu cột tồn tại)
            try {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $up = $conn->prepare("UPDATE `users` SET password_hash = ? WHERE id = ?");
                if ($up !== false) {
                    $up->bind_param('si', $newHash, $user['id']);
                    $up->execute();
                    $up->close();
                } else {
                    error_log('[login_process] Update password_hash prepare failed: ' . $conn->error);
                }
            } catch (Exception $e) {
                error_log('[login_process] Exception khi cập nhật password_hash: ' . $e->getMessage());
            }

            // login success after migration
            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'] ?? $user['username'],
            ];
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đăng nhập thành công.'];
            $dest = $_SESSION['return_to'] ?? 'index.php';
            unset($_SESSION['return_to']);
            header('Location: ' . $dest);
            exit;
        }

        // Plain-text fallback (không khuyến nghị)
        if ($password === $user['password']) {
            try {
                $newHash = password_hash($password, PASSWORD_DEFAULT);
                $up = $conn->prepare("UPDATE `users` SET password_hash = ? WHERE id = ?");
                if ($up !== false) {
                    $up->bind_param('si', $newHash, $user['id']);
                    $up->execute();
                    $up->close();
                } else {
                    error_log('[login_process] Update password_hash prepare failed: ' . $conn->error);
                }
            } catch (Exception $e) {
                error_log('[login_process] Exception khi cập nhật password_hash: ' . $e->getMessage());
            }

            $_SESSION['user'] = [
                'id' => $user['id'],
                'username' => $user['username'],
                'full_name' => $user['full_name'] ?? $user['username'],
            ];
            $_SESSION['flash'] = ['type' => 'success', 'message' => 'Đăng nhập thành công.'];
            $dest = $_SESSION['return_to'] ?? 'index.php';
            unset($_SESSION['return_to']);
            header('Location: ' . $dest);
            exit;
        }
    }

    // Nếu tới đây thì sai password
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Tên đăng nhập hoặc mật khẩu không đúng.'];
    header('Location: login.php');
    exit;

} catch (mysqli_sql_exception $me) {
    error_log('[login_process][mysqli_sql_exception] ' . $me->getMessage());
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Lỗi hệ thống, vui lòng thử lại. (DB)'];
    header('Location: login.php');
    exit;
} catch (Exception $e) {
    error_log('[login_process][Exception] ' . $e->getMessage());
    $_SESSION['flash'] = ['type' => 'danger', 'message' => 'Lỗi hệ thống, vui lòng thử lại.'];
    header('Location: login.php');
    exit;
}
?>