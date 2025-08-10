# Blog Mini - Hệ thống Blog với Phân quyền Admin/Client

## Mô tả
Blog Mini là một hệ thống blog đơn giản với phân quyền rõ ràng giữa Admin và Client. Chỉ Admin mới có quyền tạo, chỉnh sửa và xóa bài viết.

## Tính năng

### Trang Client (Người dùng thường)
- Xem danh sách bài viết
- Xem chi tiết bài viết
- Tìm kiếm bài viết
- Đăng ký/Đăng nhập
- Quản lý hồ sơ cá nhân
- Bình luận bài viết

### Trang Admin (Quản trị viên)
- **Quản lý bài viết**: Tạo, chỉnh sửa, xóa bài viết
- **Quản lý danh mục**: Tạo, chỉnh sửa, xóa danh mục
- **Quản lý bình luận**: Xem và quản lý bình luận
- **Quản lý người dùng**: Xem danh sách người dùng
- **Upload hình ảnh**: Chỉ admin mới được upload hình ảnh cho bài viết

## Cài đặt

### 1. Cấu hình Database
- Tạo database MySQL
- Import file `database.sql` để tạo bảng
- Cập nhật thông tin database trong `config/database.php`

### 2. Tạo tài khoản Admin
Chạy script để tạo tài khoản admin mẫu:
```bash
php create_admin.php
```

Thông tin tài khoản admin mặc định:
- Username: `admin`
- Password: `admin123`
- Email: `admin@example.com`

### 3. Cấu hình Web Server
- Đặt thư mục `public` làm document root
- Đảm bảo thư mục `public/uploads/images/` có quyền ghi

## Cấu trúc thư mục

```
Mini-4/
├── config/
│   └── database.php          # Cấu hình database
├── controllers/
│   ├── admin/               # Controllers cho Admin
│   │   ├── PostController.php
│   │   ├── CategoryController.php
│   │   ├── CommentController.php
│   │   ├── UserController.php
│   │   └── DashboardController.php
│   └── client/              # Controllers cho Client
│       ├── HomeController.php
│       ├── PostController.php
│       ├── AuthController.php
│       ├── ProfileController.php
│       └── SearchController.php
├── core/                    # Core classes
│   ├── Controller.php
│   ├── Model.php
│   ├── Database.php
│   └── Router.php
├── models/                  # Models
│   ├── Post.php
│   ├── User.php
│   ├── Category.php
│   └── Comment.php
├── views/
│   ├── admin/              # Views cho Admin
│   │   ├── posts/
│   │   ├── categories/
│   │   ├── comments/
│   │   └── users/
│   └── client/             # Views cho Client
│       ├── home.php
│       ├── login.php
│       ├── register.php
│       └── post_detail.php
├── public/                 # Document root
│   ├── index.php
│   ├── css/
│   ├── js/
│   └── uploads/
└── create_admin.php        # Script tạo admin
```

## Phân quyền

### Client (User thường)
- ✅ Xem bài viết
- ✅ Tìm kiếm bài viết
- ✅ Bình luận bài viết
- ✅ Quản lý hồ sơ cá nhân
- ❌ Tạo bài viết
- ❌ Chỉnh sửa bài viết
- ❌ Xóa bài viết
- ❌ Upload hình ảnh

### Admin
- ✅ Tất cả quyền của Client
- ✅ Tạo bài viết
- ✅ Chỉnh sửa bài viết
- ✅ Xóa bài viết
- ✅ Upload hình ảnh
- ✅ Quản lý danh mục
- ✅ Quản lý bình luận
- ✅ Quản lý người dùng

## Routes

### Client Routes
- `GET /` - Trang chủ
- `GET /post/{id}` - Chi tiết bài viết
- `GET /search` - Tìm kiếm
- `GET /login` - Đăng nhập
- `GET /register` - Đăng ký
- `GET /profile` - Hồ sơ cá nhân

### Admin Routes
- `GET /admin` - Dashboard
- `GET /admin/posts` - Quản lý bài viết
- `GET /admin/posts/create` - Tạo bài viết
- `POST /admin/posts` - Lưu bài viết
- `GET /admin/posts/{id}/edit` - Chỉnh sửa bài viết
- `POST /admin/posts/{id}` - Cập nhật bài viết
- `POST /admin/posts/{id}/delete` - Xóa bài viết
- `GET /admin/categories` - Quản lý danh mục
- `GET /admin/comments` - Quản lý bình luận
- `GET /admin/users` - Quản lý người dùng

## Bảo mật

- Kiểm tra quyền admin trước khi cho phép truy cập các trang admin
- Validation dữ liệu đầu vào
- Sanitize output để tránh XSS
- Upload file an toàn với kiểm tra extension
- Mật khẩu được hash bằng `password_hash()`

## Sử dụng

1. **Đăng nhập với tài khoản admin**:
   - Truy cập `/Mini-4/public/login`
   - Đăng nhập với username: `admin`, password: `admin123`
   - Admin sẽ được chuyển hướng đến `/Mini-4/public/admin`

2. **Tạo bài viết**:
   - Vào Admin Panel → Bài viết → Tạo bài viết mới
   - Chỉ admin mới thấy nút "Tạo bài viết" trong sidebar

3. **Quản lý nội dung**:
   - Admin có thể tạo, chỉnh sửa, xóa bài viết
   - Upload hình ảnh cho bài viết
   - Quản lý danh mục và bình luận

4. **User thường**:
   - Chỉ có thể xem bài viết, tìm kiếm, bình luận
   - Không thể tạo hoặc chỉnh sửa bài viết
   - Nếu cố gắng truy cập trang tạo bài viết sẽ bị chuyển hướng về trang chủ với thông báo lỗi

## Lưu ý

- Đảm bảo thư mục `public/uploads/images/` có quyền ghi (chmod 755)
- Backup database thường xuyên
- Thay đổi mật khẩu admin mặc định sau khi cài đặt
- Kiểm tra logs để phát hiện hoạt động bất thường 