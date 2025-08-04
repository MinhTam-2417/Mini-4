<?php
require_once __DIR__ . '/Database.php';

class Model  {
    protected $db;
    protected $table;

        //khởi tạo với kết nối CSDL
    public function __construct($table) {
        $this->db = new Database();
        $this->table = $table;
    }
    //lấy tất cả bản ghi
    public function all(){
        return $this->db->query("SELECT * FROM {$this->table}");
    }
    //lấy bản ghi theo id
    public function find($id){
        $return = $this-> db->query("SELECT * FROM {$this->table} WHERE id = ?", [$id]);
        return $return ? $return[0] : null;
    }

    // Thêm bản ghi mới
    public function create($data){
        $columns = implode(', ' , array_keys($data));
        $placeholders = implode(', ' , array_fill(0, count($data), '?' ));
        $values = array_values($data);
        $sql = "INSERT INTO {$this->table} ({$columns}) VALUES ({$placeholders})";
        $this->db->execute($sql, $values);
        return $this->db->lastInsertID();
    }

    //Cập nhật bản ghi
    public function update($id, $data){
        $set = implode(', ' , array_map(fn($key)=>"$key = ?", array_keys($data)));
        $values = array_values($data);
        $values[] = $id;
        $sql = "UPDATE {$this->table} SET {$set} WHERE id = ?";
        return $this->db->execute($sql, $values);
    }

    //Xóa bản ghi
    public function delete($id){
        return $this->db->execute("DELETE FROM {$this->table} WHERE id = ?", [$id]);
    }
}
