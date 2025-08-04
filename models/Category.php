<?php
require_once __DIR__ . '/../core/Model.php';

class Category extends Model {
    public function __construct(){
        parent::__construct('categories');
    }

    // Lấy tất cả categories
    public function getAll() {
        $sql = "SELECT * FROM {$this->table} ORDER BY name ASC";
        return $this->db->query($sql);
    }

    // Lấy category theo slug
    public function findBySlug($slug) {
        $sql = "SELECT * FROM {$this->table} WHERE slug = ?";
        $result = $this->db->query($sql, [$slug]);
        return $result ? $result[0] : null;
    }

    // Lấy category theo ID
    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $result = $this->db->query($sql, [$id]);
        return $result ? $result[0] : null;
    }

    // Tạo category mới
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (name, slug, description, created_at) 
                VALUES (?, ?, ?, NOW())";
        
        $this->db->execute($sql, [
            $data['name'],
            $data['slug'],
            $data['description'] ?? ''
        ]);
        
        return $this->db->lastInsertID();
    }

    // Cập nhật category
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                name = ?, 
                slug = ?, 
                description = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        
        return $this->db->execute($sql, [
            $data['name'],
            $data['slug'],
            $data['description'] ?? '',
            $id
        ]);
    }

    // Xóa category
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
}
?>
