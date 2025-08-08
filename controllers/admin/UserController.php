<?php

namespace admin;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/User.php';

class UserController extends \Controller {
    private $userModel;

    public function __construct() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /Mini-4/public/login');
            exit;
        }

        $this->userModel = new \User();
    }

    // Hiển thị danh sách người dùng
    public function index() {
        $users = $this->userModel->getAllUsers();
        $this->view('admin/users/index', ['users' => $users]);
    }

    // Hiển thị chi tiết người dùng
    public function show($id) {
        $user = $this->userModel->findById($id);
        $this->view('admin/users/show', ['user' => $user]);
    }

    // Hiển thị form sửa người dùng
    public function edit($id) {
        $user = $this->userModel->findById($id);
        $this->view('admin/users/edit', ['user' => $user]);
    }

    // Cập nhật người dùng
    public function update($id) {
        // Implementation sẽ thêm sau
        header('Location: /Mini-4/public/admin/users');
        exit;
    }

    // Xóa người dùng
    public function delete($id) {
        // Implementation sẽ thêm sau
        header('Location: /Mini-4/public/admin/users');
        exit;
    }
}
