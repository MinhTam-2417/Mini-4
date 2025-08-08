<?php

class User extends Model {
    
    public function __construct() {
        parent::__construct('users');
    }
    
    public function findByEmail($email) {
        $sql = "SELECT * FROM {$this->table} WHERE email = ?";
        $result = $this->db->query($sql, [$email]);
        return $result ? $result[0] : null;
    }
    
    public function findByUsername($username) {
        $sql = "SELECT * FROM {$this->table} WHERE username = ?";
        $result = $this->db->query($sql, [$username]);
        return $result ? $result[0] : null;
    }
    
    public function findById($id) {
        $sql = "SELECT * FROM {$this->table} WHERE id = ?";
        $result = $this->db->query($sql, [$id]);
        return $result ? $result[0] : null;
    }
    
    public function getAllUsers() {
        $sql = "SELECT * FROM {$this->table} ORDER BY created_at DESC";
        return $this->db->query($sql);
    }
    
    public function create($data) {
        $sql = "INSERT INTO {$this->table} (username, email, password, full_name, role, created_at) 
                VALUES (?, ?, ?, ?, ?, NOW())";
        
        $this->db->execute($sql, [
            $data['username'],
            $data['email'],
            $data['password'],
            $data['full_name'],
            $data['role'] ?? 'user'
        ]);
        
        return $this->db->lastInsertID();
    }
    
    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                email = ?, 
                full_name = ?, 
                bio = ?, 
                updated_at = NOW() 
                WHERE id = ?";
        
        return $this->db->execute($sql, [
            $data['email'],
            $data['full_name'],
            $data['bio'] ?? '',
            $id
        ]);
    }
    
    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE id = ?";
        return $this->db->execute($sql, [$id]);
    }
    
    public function updatePassword($id, $hashedPassword) {
        $sql = "UPDATE {$this->table} SET password = ?, updated_at = NOW() WHERE id = ?";
        return $this->db->execute($sql, [$hashedPassword, $id]);
    }

    public function getTotalUsers() {
        $sql = "SELECT COUNT(*) as total FROM {$this->table}";
        $result = $this->db->query($sql);
        return $result[0]['total'] ?? 0;
    }
}
