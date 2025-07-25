<?php

class Database {
    private $conn;
    private $config;
    public function __construct() {
        $this->config = require_once '../config/database.php';
        try {
            $dsn = "mysql:host={$this->config['host']};dbname={$this->config['database']};charset={$this->config['charset']}";
            $this->conn = new PDO($dsn, $this->config['username'], $this->config['password']);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        catch (PDOException $e) {
            die("Connection failed: " . $e->getMessage());
        }
    }

    public function query($sql, $param = []){
        try {
            $stmt = $this->conn->prepare($sql);
            $stmt->execute($param);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        }
        catch (PDOException $e) {
            die ("query failed: " . $e->getMessage());
        }
    }

    public function execute($sql, $param = []) {
        try {
            $stmt = $this->conn->prepare($sql);
            return $stmt->execute($param);
        }catch (PDOException $e) {
            die ("execute faild: " . $e->getMessage());
        }
    }

    public function lastInsertID() {
        return $this->conn->lastInsertId();
    }
}