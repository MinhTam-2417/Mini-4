<?php

namespace client;

class AuthController extends \Controller {
    
    public function __construct() {
        // No need to call parent constructor
    }
    
    public function login() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: /Mini-4/public/');
            exit;
        }
        
        $this->view('client/login');
    }
    
    public function doLogin() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/login');
            exit;
        }
        
        $username = $_POST['username'] ?? '';
        $password = $_POST['password'] ?? '';
        
        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
            header('Location: /Mini-4/public/login');
            exit;
        }
        
        $userModel = new \User();
        $user = $userModel->findByUsername($username);
        
        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['username'] = $user['username'];
            $_SESSION['role'] = $user['role'];
            
            // Redirect admin to admin panel
            if ($user['role'] === 'admin') {
                header('Location: /Mini-4/public/admin');
            } else {
                header('Location: /Mini-4/public/');
            }
            exit;
        } else {
            $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không đúng';
            header('Location: /Mini-4/public/login');
            exit;
        }
    }
    
    public function register() {
        // Check if user is already logged in
        if (isset($_SESSION['user_id'])) {
            header('Location: /Mini-4/public/');
            exit;
        }
        
        $this->view('client/register');
    }
    
    public function doRegister() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/register');
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
            header('Location: /Mini-4/public/register');
            exit;
        }
        
        if ($password !== $confirm_password) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không khớp';
            header('Location: /Mini-4/public/register');
            exit;
        }
        
        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            header('Location: /Mini-4/public/register');
            exit;
        }
        
        $userModel = new \User();
        
        // Check if username or email already exists
        if ($userModel->findByUsername($username)) {
            $_SESSION['error'] = 'Tên đăng nhập đã tồn tại';
            header('Location: /Mini-4/public/register');
            exit;
        }
        
        if ($userModel->findByEmail($email)) {
            $_SESSION['error'] = 'Email đã tồn tại';
            header('Location: /Mini-4/public/register');
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
            header('Location: /Mini-4/public/login');
            exit;
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra, vui lòng thử lại';
            header('Location: /Mini-4/public/register');
            exit;
        }
    }
    
    public function logout() {
        session_destroy();
        header('Location: /Mini-4/public/');
        exit;
    }
}
