<?php
require_once __DIR__ . '/../core/Model.php';

class Comment extends Model {
    public function __construct(){
        parent::__construct('comments');
    }

    // Lấy comments theo post_id với thông tin user
    public function getByPostId($postId) {
        $sql = "SELECT c.*, u.username, u.full_name 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.post_id = ? AND c.status = 'approved' 
                ORDER BY c.created_at ASC";
        return $this->db->query($sql, [$postId]);
    }

    // Lấy comments theo post_id (cho admin - bao gồm cả pending)
    public function getByPostIdForAdmin($postId) {
        $sql = "SELECT c.*, u.username, u.full_name 
                FROM comments c 
                LEFT JOIN users u ON c.user_id = u.id 
                WHERE c.post_id = ? 
                ORDER BY c.created_at DESC";
        return $this->db->query($sql, [$postId]);
    }

    // Duyệt comment
    public function approve($id) {
        return $this->update($id, ['status' => 'approved']);
    }

    // Từ chối comment
    public function reject($id) {
        return $this->update($id, ['status' => 'spam']);
    }

    // Đếm số comment của một bài viết
    public function countByPostId($postId) {
        $sql = "SELECT COUNT(*) as count FROM comments WHERE post_id = ? AND status = 'approved'";
        $result = $this->db->query($sql, [$postId]);
        return $result ? $result[0]['count'] : 0;
    }

    // Lấy comments theo user
    public function getCommentsByUser($userId) {
        $sql = "SELECT c.*, p.title as post_title, p.id as post_id 
                FROM comments c 
                LEFT JOIN posts p ON c.post_id = p.id 
                WHERE c.user_id = ? 
                ORDER BY c.created_at DESC";
        return $this->db->query($sql, [$userId]);
    }

    // Tạo comment mới
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (content, user_id, post_id, status, created_at) 
                VALUES (?, ?, ?, ?, NOW())";
        
        $this->db->execute($sql, [
            $data['content'],
            $data['user_id'],
            $data['post_id'],
            $data['status']
        ]);
        
        return $this->db->lastInsertID();
    }

    // Thêm comment mới (wrapper cho create)
    public function addComment($userId, $postId, $content) {
        $data = [
            'content' => $content,
            'user_id' => $userId,
            'post_id' => $postId,
            'status' => 'approved' // Tự động approve cho user đã đăng nhập
        ];
        
        return $this->create($data);
    }

    public function getTotalComments() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }

    public function getRecentComments($limit = 5) {
        $sql = "SELECT c.*, u.username, p.title as post_title 
                FROM {$this->table} c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN posts p ON c.post_id = p.id 
                ORDER BY c.created_at DESC 
                LIMIT " . (int)$limit;
        return $this->db->query($sql);
    }

    public function getAllCommentsWithDetails() {
        $sql = "SELECT c.*, u.username, p.title as post_title 
                FROM {$this->table} c 
                LEFT JOIN users u ON c.user_id = u.id 
                LEFT JOIN posts p ON c.post_id = p.id 
                ORDER BY c.created_at DESC";
        return $this->db->query($sql);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    // Xóa tất cả comments của một bài viết
    public function deleteByPostId($postId) {
        $sql = "DELETE FROM {$this->table} WHERE post_id = ?";
        return $this->db->execute($sql, [$postId]);
    }
}
?>
