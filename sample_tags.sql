-- Dữ liệu mẫu cho bảng tags
INSERT INTO tags (name, slug, description, color) VALUES
('Công nghệ', 'cong-nghe', 'Các bài viết về công nghệ, phần mềm, và phát triển', '#007bff'),
('Giải trí', 'giai-tri', 'Nội dung giải trí, phim ảnh, âm nhạc', '#28a745'),
('Thể thao', 'the-thao', 'Tin tức thể thao, bóng đá, các môn thể thao khác', '#dc3545'),
('Du lịch', 'du-lich', 'Kinh nghiệm du lịch, địa điểm đẹp', '#ffc107'),
('Ẩm thực', 'am-thuc', 'Công thức nấu ăn, món ngon', '#fd7e14'),
('Sức khỏe', 'suc-khoe', 'Chăm sóc sức khỏe, dinh dưỡng', '#6f42c1'),
('Giáo dục', 'giao-duc', 'Kiến thức, học tập, giáo dục', '#20c997'),
('Kinh doanh', 'kinh-doanh', 'Tin tức kinh doanh, tài chính', '#6c757d'),
('Thời trang', 'thoi-trang', 'Xu hướng thời trang, làm đẹp', '#e83e8c'),
('Xe cộ', 'xe-co', 'Tin tức xe hơi, xe máy', '#495057');

-- Dữ liệu mẫu cho bảng post_tags (gán tags cho một số bài viết)
-- Lưu ý: Cần thay đổi post_id và tag_id theo dữ liệu thực tế trong database
INSERT INTO post_tags (post_id, tag_id) VALUES
(1, 1), -- Bài viết 1 - Tag Công nghệ
(1, 7), -- Bài viết 1 - Tag Giáo dục
(2, 2), -- Bài viết 2 - Tag Giải trí
(2, 9), -- Bài viết 2 - Tag Thời trang
(3, 3), -- Bài viết 3 - Tag Thể thao
(3, 8), -- Bài viết 3 - Tag Kinh doanh
(4, 4), -- Bài viết 4 - Tag Du lịch
(4, 5), -- Bài viết 4 - Tag Ẩm thực
(5, 6), -- Bài viết 5 - Tag Sức khỏe
(5, 10); -- Bài viết 5 - Tag Xe cộ


