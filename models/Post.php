<?php
require_once __DIR__ . '/../core/Model.php';

class Post extends Model {
    public function __construct(){
        parent::__construct('posts');
    }

    // Lấy tất cả bài viết đã publish với thông tin user và category
    public function getAllPublished() {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name 
                FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.status = 'published' 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql);
    }

    // Lấy bài viết theo ID với thông tin user và category
    public function findWithDetails($id) {
        $sql = "SELECT p.*, u.username as author_name, u.full_name as author_full_name, 
                       c.name as category_name, c.slug as category_slug
                FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.id = ? AND p.status = 'published'";
        $result = $this->db->query($sql, [$id]);
        return $result ? $result[0] : null;
    }

    // Tăng lượt xem bài viết
    public function incrementViewCount($id) {
        $sql = "UPDATE posts SET view_count = view_count + 1 WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }

    // Lấy bài viết liên quan (cùng category)
    public function getRelatedPosts($categoryId, $currentPostId, $limit = 3) {
        $sql = "SELECT p.*, u.username as author_name 
                FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id 
                WHERE p.category_id = ? AND p.id != ? AND p.status = 'published' 
                ORDER BY p.created_at DESC 
                LIMIT " . (int)$limit;
        return $this->db->query($sql, [$categoryId, $currentPostId]);
    }

    // Lấy bài viết theo category
    public function getByCategory($categoryId) {
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name 
                FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE p.category_id = ? AND p.status = 'published' 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql, [$categoryId]);
    }

    // Tìm kiếm bài viết
    public function search($keyword) {
        $keyword = "%{$keyword}%";
        $sql = "SELECT p.*, u.username as author_name, c.name as category_name 
                FROM posts p 
                LEFT JOIN users u ON p.user_id = u.id 
                LEFT JOIN categories c ON p.category_id = c.id 
                WHERE (p.title LIKE ? OR p.content LIKE ? OR p.excerpt LIKE ?) 
                AND p.status = 'published' 
                ORDER BY p.created_at DESC";
        return $this->db->query($sql, [$keyword, $keyword, $keyword]);
    }
}
?>