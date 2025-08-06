<?php
class Controller {
    //hiển thị view
    protected function view($view, $data = []) {
        extract($data);
        $viewPath = __DIR__ . "/../views/{$view}.php";
        if (!file_exists($viewPath)) {
            die("View file not found: $viewPath");
        }
        require_once $viewPath;
    }
    
    // chuyển hướng 
    protected function redirect($url) {
        header("Location: {$url}");
        exit();
    }
    
    // kiểm tra đăng nhập
    protected function isAuthenticated($role = null) {
        session_start();
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        if ($role && $_SESSION['role'] !== $role) {
            $this->redirect('/');
        }
    }
}
?>