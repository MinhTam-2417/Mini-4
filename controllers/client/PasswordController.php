<?php

namespace client;

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/User.php';

class PasswordController extends \Controller {
    private $userModel;
    
    public function __construct() {
        // No need to call parent constructor
        $this->userModel = new \User();
    }
    
    // Hiển thị trang quên mật khẩu
    public function showForgotPassword() {
        $this->view('client/forgot_password', [
            'current_page' => 'forgot_password',
            'page_title' => 'Quên mật khẩu'
        ]);
    }
    
    // Xử lý yêu cầu quên mật khẩu
    public function forgotPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/forgot-password');
            exit;
        }
        
        $email = trim($_POST['email'] ?? '');
        
        if (empty($email)) {
            $_SESSION['error'] = 'Vui lòng nhập email';
            header('Location: /Mini-4/public/forgot-password');
            exit;
        }
        
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $_SESSION['error'] = 'Email không hợp lệ';
            header('Location: /Mini-4/public/forgot-password');
            exit;
        }
        
        // Kiểm tra email có tồn tại không
        $user = $this->userModel->findByEmail($email);
        
        if (!$user) {
            // Không cho biết email có tồn tại hay không (bảo mật)
            $_SESSION['success'] = 'Nếu email tồn tại, chúng tôi đã gửi link đặt lại mật khẩu';
            header('Location: /Mini-4/public/forgot-password');
            exit;
        }
        
        // Tạo token reset password
        $token = bin2hex(random_bytes(32));
        $expires = date('Y-m-d H:i:s', strtotime('+1 hour'));
        
        // Lưu token vào database
        $result = $this->userModel->saveResetToken($user['id'], $token, $expires);
        
        if ($result) {
            // Gửi email (trong thực tế sẽ gửi email thật)
            $resetLink = "http://localhost/Mini-4/public/reset-password?token=" . $token;
            
            // Log để test (trong production sẽ gửi email)
            error_log("Reset password link for {$email}: {$resetLink}");
            
            $_SESSION['success'] = 'Link đặt lại mật khẩu đã được gửi đến email của bạn. Vui lòng kiểm tra hộp thư.';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
        }
        
        header('Location: /Mini-4/public/forgot-password');
        exit;
    }
    
    // Hiển thị trang đặt lại mật khẩu
    public function showResetPassword() {
        $token = $_GET['token'] ?? '';
        
        if (empty($token)) {
            $_SESSION['error'] = 'Token không hợp lệ';
            header('Location: /Mini-4/public/login');
            exit;
        }
        
        // Kiểm tra token có hợp lệ không
        $user = $this->userModel->findByResetToken($token);
        
        if (!$user) {
            $_SESSION['error'] = 'Token không hợp lệ hoặc đã hết hạn';
            header('Location: /Mini-4/public/login');
            exit;
        }
        
        // Kiểm tra token có hết hạn không
        if (strtotime($user['reset_token_expires']) < time()) {
            $_SESSION['error'] = 'Token đã hết hạn. Vui lòng yêu cầu link mới.';
            header('Location: /Mini-4/public/forgot-password');
            exit;
        }
        
        $this->view('client/reset_password', [
            'current_page' => 'reset_password',
            'page_title' => 'Đặt lại mật khẩu',
            'token' => $token
        ]);
    }
    
    // Xử lý đặt lại mật khẩu
    public function resetPassword() {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/login');
            exit;
        }
        
        $token = $_POST['token'] ?? '';
        $password = $_POST['password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';
        
        if (empty($token) || empty($password) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin';
            header('Location: /Mini-4/public/reset-password?token=' . urlencode($token));
            exit;
        }
        
        if ($password !== $confirmPassword) {
            $_SESSION['error'] = 'Mật khẩu không khớp';
            header('Location: /Mini-4/public/reset-password?token=' . urlencode($token));
            exit;
        }
        
        if (strlen($password) < 6) {
            $_SESSION['error'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            header('Location: /Mini-4/public/reset-password?token=' . urlencode($token));
            exit;
        }
        
        // Kiểm tra token có hợp lệ không
        $user = $this->userModel->findByResetToken($token);
        
        if (!$user) {
            $_SESSION['error'] = 'Token không hợp lệ';
            header('Location: /Mini-4/public/login');
            exit;
        }
        
        // Kiểm tra token có hết hạn không
        if (strtotime($user['reset_token_expires']) < time()) {
            $_SESSION['error'] = 'Token đã hết hạn. Vui lòng yêu cầu link mới.';
            header('Location: /Mini-4/public/forgot-password');
            exit;
        }
        
        // Cập nhật mật khẩu mới
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
        $result = $this->userModel->updatePassword($user['id'], $hashedPassword);
        
        if ($result) {
            // Xóa token reset
            $this->userModel->clearResetToken($user['id']);
            
            $_SESSION['success'] = 'Mật khẩu đã được đặt lại thành công. Vui lòng đăng nhập với mật khẩu mới.';
            header('Location: /Mini-4/public/login');
            exit;
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra. Vui lòng thử lại sau.';
            header('Location: /Mini-4/public/reset-password?token=' . urlencode($token));
            exit;
        }
    }
}
