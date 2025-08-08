<?php

namespace client;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/User.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/Comment.php';

class ProfileController extends \Controller {
    private $userModel;
    private $postModel;
    private $commentModel;

    public function __construct() {
        $this->userModel = new \User();
        $this->postModel = new \Post();
        $this->commentModel = new \Comment();
    }

    // Hiển thị hồ sơ người dùng
    public function index() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Mini-4/public/login');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);
        $userPosts = $this->postModel->getPostsByUser($userId);
        $userComments = $this->commentModel->getCommentsByUser($userId);

        $this->view('client/profile', [
            'user' => $user,
            'posts' => $userPosts,
            'comments' => $userComments
        ]);
    }

    // Cập nhật hồ sơ
    public function update() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Mini-4/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/profile');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $fullName = $_POST['full_name'] ?? '';
        $email = $_POST['email'] ?? '';
        $bio = $_POST['bio'] ?? '';

        // Validation
        if (empty($fullName) || empty($email)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin bắt buộc';
            header('Location: /Mini-4/public/profile');
            exit;
        }

        // Kiểm tra email đã tồn tại chưa (trừ user hiện tại)
        $existingUser = $this->userModel->findByEmail($email);
        if ($existingUser && $existingUser['id'] != $userId) {
            $_SESSION['error'] = 'Email đã được sử dụng bởi tài khoản khác';
            header('Location: /Mini-4/public/profile');
            exit;
        }

        // Cập nhật thông tin
        $updateData = [
            'full_name' => $fullName,
            'email' => $email,
            'bio' => $bio
        ];

        if ($this->userModel->update($userId, $updateData)) {
            $_SESSION['success'] = 'Cập nhật hồ sơ thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật hồ sơ';
        }

        header('Location: /Mini-4/public/profile');
        exit;
    }

    // Đổi mật khẩu
    public function changePassword() {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Mini-4/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/profile');
            exit;
        }

        $userId = $_SESSION['user_id'];
        $currentPassword = $_POST['current_password'] ?? '';
        $newPassword = $_POST['new_password'] ?? '';
        $confirmPassword = $_POST['confirm_password'] ?? '';

        // Validation
        if (empty($currentPassword) || empty($newPassword) || empty($confirmPassword)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ thông tin';
            header('Location: /Mini-4/public/profile');
            exit;
        }

        if ($newPassword !== $confirmPassword) {
            $_SESSION['error'] = 'Mật khẩu mới không khớp';
            header('Location: /Mini-4/public/profile');
            exit;
        }

        if (strlen($newPassword) < 6) {
            $_SESSION['error'] = 'Mật khẩu phải có ít nhất 6 ký tự';
            header('Location: /Mini-4/public/profile');
            exit;
        }

        // Kiểm tra mật khẩu hiện tại
        $user = $this->userModel->findById($userId);
        if (!password_verify($currentPassword, $user['password'])) {
            $_SESSION['error'] = 'Mật khẩu hiện tại không đúng';
            header('Location: /Mini-4/public/profile');
            exit;
        }

        // Cập nhật mật khẩu
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
        if ($this->userModel->updatePassword($userId, $hashedPassword)) {
            $_SESSION['success'] = 'Đổi mật khẩu thành công!';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi đổi mật khẩu';
        }

        header('Location: /Mini-4/public/profile');
        exit;
    }
}
?> 