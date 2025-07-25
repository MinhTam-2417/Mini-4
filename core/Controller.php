<?php
class Controller {
    //hiển thị view
    protected function render($view, $data = []) {
        extract($data);
        require_once "views/{$view}.php";
    }
    // chuyển hướng 
    protected function redirect($url) {
        header("Location: {$url}");
        exit();}
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