# Chức năng Like Bài Viết

## Tổng quan
Chức năng like bài viết cho phép người dùng đã đăng nhập thích/bỏ thích các bài viết trên blog. Hệ thống sẽ theo dõi số lượt like và hiển thị trạng thái like của từng user.

## Tính năng chính

### 1. Like/Unlike bài viết
- Người dùng đã đăng nhập có thể like/unlike bài viết
- Mỗi user chỉ có thể like một bài viết một lần
- Có thể unlike bài viết đã like trước đó

### 2. Hiển thị số lượt like
- Hiển thị tổng số lượt like của mỗi bài viết
- Cập nhật real-time khi có like/unlike mới

### 3. Trạng thái like của user
- Hiển thị trạng thái like của user hiện tại
- Icon trái tim đầy/rỗng tùy theo trạng thái
- Màu sắc khác biệt cho bài viết đã like

### 4. Tooltip hiển thị người đã like
- Hover vào số lượt like để xem danh sách người đã like
- Hiển thị tên người dùng đã like bài viết

## Cấu trúc Database

### Bảng `likes`
```sql
CREATE TABLE likes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    post_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_user_post (user_id, post_id),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE
);
```

## Files đã thêm/sửa đổi

### Models
- `models/Like.php` - Model xử lý like
- `models/Post.php` - Thêm phương thức lấy thông tin like

### Controllers
- `controllers/client/LikeController.php` - Controller xử lý like

### Views
- `views/client/home.php` - Thêm nút like cho danh sách bài viết
- `views/client/post_detail.php` - Thêm nút like cho trang chi tiết

### JavaScript
- `public/js/like.js` - Xử lý tương tác like

### Routes
- `public/index.php` - Thêm routes cho like

## API Endpoints

### POST `/like/toggle`
Toggle like/unlike bài viết
```json
{
    "success": true,
    "liked": true,
    "like_count": 5,
    "message": "Đã like bài viết"
}
```

### POST `/like/add`
Thêm like cho bài viết
```json
{
    "success": true,
    "liked": true,
    "like_count": 5,
    "message": "Đã like bài viết"
}
```

### POST `/like/remove`
Xóa like bài viết
```json
{
    "success": true,
    "liked": false,
    "like_count": 4,
    "message": "Đã unlike bài viết"
}
```

### GET `/like/count/{post_id}`
Lấy số lượt like của bài viết
```json
{
    "success": true,
    "like_count": 5
}
```

### GET `/like/users/{post_id}`
Lấy danh sách user đã like bài viết
```json
{
    "success": true,
    "users": [
        {
            "id": 1,
            "username": "user1",
            "full_name": "User One"
        }
    ]
}
```

## Cách sử dụng

### 1. Cài đặt database
Chạy script tạo bảng likes:
```bash
php create_likes_table.php
```

### 2. Đăng nhập
Chỉ user đã đăng nhập mới có thể like bài viết.

### 3. Like bài viết
- Trên trang chủ: Click nút like bên cạnh mỗi bài viết
- Trên trang chi tiết: Click nút "Thích" trong phần header bài viết

### 4. Xem thông tin like
- Số lượt like hiển thị bên cạnh mỗi bài viết
- Hover vào số lượt like để xem danh sách người đã like

## Tính năng bảo mật

1. **Xác thực user**: Chỉ user đã đăng nhập mới có thể like
2. **Ràng buộc unique**: Mỗi user chỉ có thể like một bài viết một lần
3. **Validation**: Kiểm tra bài viết tồn tại trước khi like
4. **CSRF Protection**: Sử dụng POST request với form data

## Giao diện

### Nút like
- Icon trái tim rỗng: Chưa like
- Icon trái tim đầy màu đỏ: Đã like
- Hiệu ứng hover và animation mượt mà

### Thông báo
- Toast notification khi like/unlike thành công
- Thông báo lỗi nếu chưa đăng nhập

### Responsive
- Giao diện tương thích với mobile
- Nút like có kích thước phù hợp trên mọi thiết bị

## Troubleshooting

### Lỗi thường gặp

1. **"Vui lòng đăng nhập để like bài viết"**
   - Giải pháp: Đăng nhập vào hệ thống

2. **"Bài viết không tồn tại"**
   - Giải pháp: Kiểm tra lại ID bài viết

3. **"Bạn đã like bài viết này rồi"**
   - Giải pháp: Sử dụng nút unlike để bỏ thích

### Debug
- Kiểm tra console browser để xem lỗi JavaScript
- Kiểm tra network tab để xem request/response
- Kiểm tra database để xem dữ liệu likes

## Tương lai

Có thể mở rộng thêm các tính năng:
- Like comment
- Dislike bài viết
- Thông báo khi có người like bài viết
- Thống kê bài viết được like nhiều nhất
- Export danh sách người đã like

