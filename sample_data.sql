-- Thêm dữ liệu mẫu
INSERT INTO users (username, email, password, full_name, role) VALUES
('admin', 'admin@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Administrator', 'admin'),
('user1', 'user1@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Nguyễn Văn A', 'user'),
('user2', 'user2@example.com', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'Trần Thị B', 'user');

INSERT INTO categories (name, slug, description) VALUES
('Công nghệ', 'cong-nghe', 'Các bài viết về công nghệ mới nhất'),
('Du lịch', 'du-lich', 'Khám phá những điểm đến thú vị'),
('Ẩm thực', 'am-thuc', 'Các món ăn ngon và công thức nấu ăn'),
('Thể thao', 'the-thao', 'Tin tức thể thao và các sự kiện thể thao');

INSERT INTO posts (title, slug, content, excerpt, user_id, category_id, status) VALUES
('Laravel Framework - Framework PHP hiện đại', 'laravel-framework-framework-php-hien-dai', 
'Laravel là một framework PHP hiện đại được phát triển bởi Taylor Otwell. Framework này cung cấp một cú pháp đẹp và rõ ràng, giúp cho việc phát triển web trở nên dễ dàng và thú vị hơn.

Laravel có nhiều tính năng mạnh mẽ như:
- Eloquent ORM
- Blade Template Engine
- Artisan CLI
- Authentication & Authorization
- Database Migrations
- And much more...

Với Laravel, bạn có thể xây dựng các ứng dụng web phức tạp một cách nhanh chóng và hiệu quả.',
'Laravel là một framework PHP hiện đại với nhiều tính năng mạnh mẽ giúp phát triển web nhanh chóng và hiệu quả.',
1, 1, 'published'),

('Hà Nội - Thủ đô nghìn năm văn hiến', 'ha-noi-thu-do-nghin-nam-van-hien',
'Hà Nội, thủ đô của Việt Nam, là một thành phố có lịch sử lâu đời với hơn 1000 năm tuổi. Thành phố này nổi tiếng với những di tích lịch sử, văn hóa và ẩm thực đặc trưng.

Những điểm đến không thể bỏ qua khi đến Hà Nội:
- Văn Miếu - Quốc Tử Giám
- Hồ Hoàn Kiếm
- Phố cổ Hà Nội
- Chùa Một Cột
- Lăng Chủ tịch Hồ Chí Minh

Hà Nội còn nổi tiếng với ẩm thực phong phú như phở, bún chả, chả cá Lã Vọng...',
'Hà Nội - thành phố nghìn năm văn hiến với những di tích lịch sử và ẩm thực đặc trưng.',
1, 2, 'published'),

('Phở Hà Nội - Món ăn truyền thống Việt Nam', 'pho-ha-noi-mon-an-truyen-thong-viet-nam',
'Phở là một món ăn truyền thống của Việt Nam, đặc biệt nổi tiếng với phở Hà Nội. Món ăn này được làm từ bánh phở, nước dùng và thịt bò hoặc gà.

Cách nấu phở Hà Nội truyền thống:
1. Chuẩn bị nước dùng từ xương bò
2. Thêm các gia vị như gừng, hành, quế, thảo quả
3. Nấu trong nhiều giờ để có nước dùng ngọt
4. Thái thịt bò mỏng
5. Trụng bánh phở
6. Thêm rau thơm và gia vị

Phở Hà Nội có hương vị đặc trưng với nước dùng trong, bánh phở dai và thịt bò tươi ngon.',
'Phở Hà Nội - món ăn truyền thống với nước dùng trong, bánh phở dai và thịt bò tươi ngon.',
1, 3, 'published'),

('Bóng đá Việt Nam - Những thành tựu đáng tự hào', 'bong-da-viet-nam-nhung-thanh-tuu-dang-tu-hao',
'Bóng đá Việt Nam trong những năm gần đây đã có những bước tiến vượt bậc, đạt được nhiều thành tựu đáng tự hào trên đấu trường quốc tế.

Những thành tựu nổi bật:
- Vô địch AFF Cup 2018
- Lọt vào vòng loại World Cup 2022
- Đội tuyển U23 lọt vào chung kết U23 Châu Á 2018
- Các cầu thủ Việt Nam thi đấu tại các giải đấu châu Âu

Đội tuyển Việt Nam với những cầu thủ tài năng như Quang Hải, Văn Hậu, Đức Chinh... đã mang lại niềm tự hào cho người hâm mộ bóng đá Việt Nam.',
'Bóng đá Việt Nam đã đạt được nhiều thành tựu đáng tự hào trên đấu trường quốc tế.',
1, 4, 'published');

INSERT INTO comments (content, user_id, post_id, status) VALUES
('Bài viết rất hay và bổ ích!', 2, 1, 'approved'),
('Cảm ơn tác giả đã chia sẻ thông tin chi tiết về Laravel', 3, 1, 'approved'),
('Hà Nội thật đẹp, tôi rất muốn được đến thăm!', 2, 2, 'approved'),
('Phở Hà Nội ngon nhất Việt Nam!', 3, 3, 'approved'),
('Việt Nam cố lên! Chúng ta sẽ vô địch!', 2, 4, 'approved'); 