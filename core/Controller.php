<?php
class Controller {
    //hiển thị view
    protected function view($view, $data = []) {
        extract($data);
        $viewPath = __DIR__ . "/../views/{$view}.php";
        if (!file_exists($viewPath)) {
            die("View file not found: $viewPath");
        }
        
        // Kiểm tra xem có phải admin view không
        if (strpos($view, 'admin/') === 0) {
            // Sử dụng admin layout với biến $view
            require_once __DIR__ . "/../views/admin/layouts/main.php";
        } else {
            // Sử dụng client layout chung
            ob_start();
            require_once $viewPath;
            $content = ob_get_clean();
            require_once __DIR__ . "/../views/client/layout/main.php";
        }
    }
    
    // chuyển hướng 
    protected function redirect($url) {
        header("Location: {$url}");
        exit();
    }
    
    // kiểm tra đăng nhập
    protected function isAuthenticated($role = null) {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }
        if ($role && $_SESSION['role'] !== $role) {
            $this->redirect('/');
        }
    }
}
?>