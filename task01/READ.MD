Tiêu đề: [Nộp bài] Bài thực hành Task Management — Thêm chức năng đăng nhập và session flash

Nội dung:
Mình đã thực hiện các yêu cầu:
1. Thêm tính năng đăng nhập cho hệ thống:
   - login.php: form đăng nhập.
   - login_process.php: xử lý đăng nhập, hỗ trợ migrate mật khẩu SHA1/plain sang password_hash.
   - logout.php: đăng xuất và set flash message.
   - auth.php: kiểm tra session, redirect về login.php nếu chưa đăng nhập.

2. Bảo vệ trang:
   - Đã chuẩn hoá include bằng __DIR__. Bạn có thể bật auth cho "tất cả các trang" bằng cách thêm require_once __DIR__ . '/auth.php'; ở đầu mọi file (index.php, add.php, edit.php, view.php, insert.php, update.php, delete.php). 

3. Hiển thị thông tin đăng nhập ở bên phải Navbar:
   - partials/navbar.php đã hiển thị tên người dùng (full_name hoặc username) và link Đăng xuất khi đã login.

4. Session flash messages:
   - partials/flash.php hiển thị thông báo success/danger. Các thao tác CRUD (insert.php, update.php, delete.php) và login_process.php, logout.php đều set $_SESSION['flash'] thích hợp trước khi redirect.

Hướng dẫn test:
- Tạo DB bằng SQL đính kèm (hoặc dùng DB hiện tại). Tài khoản mặc định theo dump: admin / 123456 (mật khẩu SHA1, code sẽ migrate).
- Mở /task01/login.php để đăng nhập, sau đó thử thêm/sửa/xóa nhiệm vụ để thấy flash messages.
- Lưu ý xóa file debug trước khi nộp.

Các file đính kèm (nén vào task01-auth.zip):
- auth.php, login.php, login_process.php, logout.php
- partials/head.php (cập nhật), partials/navbar.php (cập nhật), partials/flash.php (mới)
- insert.php, update.php, delete.php (cập nhật)

Ghi chú bảo mật:
- Sau migrate, nên xoá/clear cột password (nếu trước đó lưu plain/SHA1) và chỉ lưu password_hash.
- Không để các file debug công khai.

Cảm ơn.