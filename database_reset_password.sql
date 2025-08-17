-- Thêm cột cho chức năng reset password
ALTER TABLE users 
ADD COLUMN reset_token VARCHAR(255) NULL,
ADD COLUMN reset_token_expires DATETIME NULL;

-- Tạo index cho reset_token để tìm kiếm nhanh hơn
CREATE INDEX idx_users_reset_token ON users(reset_token);

-- Cập nhật cột updated_at nếu chưa có
ALTER TABLE users 
MODIFY COLUMN updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP;


