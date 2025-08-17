# Tính năng Quản lý Thẻ (Tags) - Blog Mini

## Tổng quan

Tính năng quản lý thẻ (tags) cho phép admin tạo, chỉnh sửa, xóa và quản lý các thẻ để phân loại bài viết. Mỗi thẻ có thể được gán cho nhiều bài viết và mỗi bài viết có thể có nhiều thẻ.

## Cấu trúc Database

### Bảng `tags`
- `id`: ID tự động tăng
- `name`: Tên thẻ (bắt buộc)
- `slug`: URL-friendly version của tên thẻ (tự động tạo)
- `description`: Mô tả thẻ (tùy chọn)
- `color`: Màu sắc hiển thị thẻ (mặc định: #007bff)
- `created_at`: Thời gian tạo
- `updated_at`: Thời gian cập nhật

### Bảng `post_tags` (quan hệ nhiều-nhiều)
- `id`: ID tự động tăng
- `post_id`: ID bài viết
- `tag_id`: ID thẻ
- `created_at`: Thời gian tạo

## Cài đặt

### 1. Cập nhật Database
Chạy file `database.sql` để tạo các bảng mới:
```sql
-- Bảng tags
CREATE TABLE tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    slug VARCHAR(100) UNIQUE NOT NULL,
    description TEXT,
    color VARCHAR(7) DEFAULT '#007bff',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Bảng post_tags
CREATE TABLE post_tags (
    id INT AUTO_INCREMENT PRIMARY KEY,
    post_id INT NOT NULL,
    tag_id INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE KEY unique_post_tag (post_id, tag_id),
    FOREIGN KEY (post_id) REFERENCES posts(id) ON DELETE CASCADE,
    FOREIGN KEY (tag_id) REFERENCES tags(id) ON DELETE CASCADE
);
```

### 2. Thêm dữ liệu mẫu
Chạy file `sample_tags.sql` để thêm dữ liệu mẫu:
```bash
mysql -u username -p database_name < sample_tags.sql
```

## Sử dụng

### Admin Panel

#### 1. Truy cập quản lý Tags
- Đăng nhập vào admin panel
- Click vào menu "Thẻ" trong navigation bar
- URL: `/admin/tags`

#### 2. Xem danh sách Tags
- Hiển thị tất cả tags với thông tin:
  - Tên thẻ (với màu sắc)
  - Slug
  - Mô tả
  - Số lượng bài viết sử dụng
  - Các thao tác (Sửa/Xóa)

#### 3. Tạo Tag mới
- Click nút "Thêm Thẻ Mới"
- Điền thông tin:
  - **Tên thẻ**: Bắt buộc, sẽ tự động tạo slug
  - **Mô tả**: Tùy chọn
  - **Màu sắc**: Chọn màu hiển thị
- Xem trước thẻ sẽ hiển thị như thế nào
- Click "Tạo Thẻ"

#### 4. Chỉnh sửa Tag
- Click nút "Sửa" bên cạnh tag
- Thay đổi thông tin cần thiết
- Click "Cập nhật Thẻ"

#### 5. Xóa Tag
- Click nút "Xóa" bên cạnh tag
- Xác nhận xóa
- **Lưu ý**: Không thể xóa tag đang được sử dụng trong bài viết

#### 6. Tìm kiếm Tags
- Sử dụng ô tìm kiếm để tìm tags theo tên hoặc mô tả

### API Endpoints

#### Lấy danh sách tags (JSON)
```
GET /admin/tags/api
GET /admin/tags/api?q=keyword
```

## Model Methods

### Tag Model

```php
// Tạo tag mới
$tagId = $tagModel->create($data);

// Lấy tất cả tags với số lượng bài viết
$tags = $tagModel->getAllWithPostCount();

// Tìm tag theo slug
$tag = $tagModel->findBySlug($slug);

// Tìm kiếm tags
$tags = $tagModel->search($keyword);

// Lấy tags phổ biến
$tags = $tagModel->getPopularTags($limit);

// Lấy tags của bài viết
$tags = $tagModel->getTagsByPost($postId);

// Thêm tags cho bài viết
$tagModel->addTagsToPost($postId, $tagIds);

// Xóa tags khỏi bài viết
$tagModel->removeTagsFromPost($postId);
```

### Post Model

```php
// Lấy bài viết với tags
$post = $postModel->findWithTags($id);

// Lấy tất cả bài viết với tags
$posts = $postModel->getAllPublishedWithTags($userId);

// Lấy bài viết theo tag
$posts = $postModel->getByTag($tagId);

// Lấy tags của bài viết
$tags = $postModel->getTagsByPost($postId);
```

## Tính năng nâng cao

### 1. Tự động tạo Slug
- Slug được tạo tự động từ tên thẻ
- Hỗ trợ tiếng Việt và ký tự đặc biệt
- Tự động thêm số nếu slug đã tồn tại

### 2. Validation
- Tên thẻ không được để trống
- Tên thẻ không được trùng lặp
- Màu sắc phải đúng định dạng hex

### 3. Bảo mật
- Kiểm tra quyền admin trước khi thao tác
- Không cho phép xóa tag đang được sử dụng
- Sanitize input để tránh XSS

### 4. Hiệu suất
- Sử dụng JOIN để lấy dữ liệu hiệu quả
- Index trên các trường thường query
- Cache kết quả tìm kiếm

## Test

Chạy script test để kiểm tra tính năng:
```bash
php test_tags.php
```

## Troubleshooting

### Lỗi thường gặp

1. **"Tag không tìm thấy"**
   - Kiểm tra ID tag có đúng không
   - Kiểm tra database connection

2. **"Không thể xóa tag"**
   - Tag đang được sử dụng trong bài viết
   - Cần xóa liên kết trước khi xóa tag

3. **"Slug đã tồn tại"**
   - Hệ thống sẽ tự động thêm số vào slug
   - Kiểm tra tên tag có trùng không

### Debug

Thêm logging để debug:
```php
error_log("Creating tag: " . $tagName);
error_log("Generated slug: " . $slug);
```

## Tương lai

Các tính năng có thể phát triển thêm:
- Import/Export tags
- Tag cloud widget
- Auto-suggest tags
- Tag analytics
- Bulk operations
- Tag hierarchy (parent-child tags)


