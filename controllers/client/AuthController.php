<?php

namespace client;

class AuthController extends \Controller {
    
    public function __construct() {
        parent::__construct();
    }
    
    public function login() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
        
        $this->view('client/login');
    }
    
    public function doLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /login');
            exit;
        }
        
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($email) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
            header('Location: /login');
            exit;
        }
        
        $userModel = new \User();
        $user = $userModel->findByEmail($email);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            header('Location: /');
            exit;
        } else {
            $_SESSION['error'] = 'Email hoặc mật khẩu không đúng';
            header('Location: /login');
            exit;
        }
    }
    
    public function register() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: /');
            exit;
        }
        
        $this->view('client/register');
    }
    
    public function doRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /register');
            exit;
        }
        
        $username = $_POST['username'] ?? '';
        $email = $_POST['email'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirm_password = $_POST['confirm_password'] ?? '';
        $full_name = $_POST['full_name'] ?? '';
        
        // Validation
        if (empty($username) || empty($email) || empty($password) || empty($confirm_password)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
            header('Location: /register');
            exit;
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp';
            header('Location: /register');
            exit;
        }
        
        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            header('Location: /register');
            exit;
        }
        
        $userModel = new \User();
        
        // Check if username or email already exists
        if ($userModel->findByUsername($username)) {
            $_SESSION['error'] = 'Tên đăng nhập đã tồn tại';
            header('Location: /register');
            exit;
        }
        
        if ($userModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email đã tồn tại';
            header('Location: /register');
            exit;
        }
        
        // Create user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $userId = $userModel->create([
            'username' => $username,
            'email' => $email,
            'password' => $hashedPassword,
            'full_name' => $full_name,
            'role' => 'user'
        ]);
        
        if ($userId) {
            $_SESSION['success'] = 'Đăng ký thành công! Vui lòng đăng nhập';
            header('Location: /login');
            exit;
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
            header('Location: /register');
            exit;
        }
    }
    
    public function logout() {
        session_destroy();
        header('Location: /');
        exit;
    }
}
