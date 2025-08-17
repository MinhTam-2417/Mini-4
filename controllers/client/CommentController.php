<?php
namespace client;

require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Comment.php';

class CommentController extends \Controller {
    private $commentModel;

    public function __construct() {
        $this->commentModel = new \Comment();
    }

    // Thêm bình luận mới
    public function add() {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('/');
        }

        $postId = $_POST['post_id'] ?? null;
        $content = trim($_POST['content'] ?? '');

        if (!$postId || empty($content)) {
            $_SESSION['error'] = 'Vui lòng nhập nội dung bình luận';
            $this->redirect("/Mini-4/public/post/{$postId}");
        }

        $userId = $_SESSION['user_id'];
        
        try {
            $result = $this->commentModel->addComment($userId, $postId, $content);
            
            if ($result) {
                $_SESSION['success'] = 'Đã thêm bình luận thành công';
            } else {
                $_SESSION['error'] = 'Có lỗi xảy ra khi thêm bình luận';
            }
        } catch (Exception $e) {
            $_SESSION['error'] = 'Có lỗi xảy ra: ' . $e->getMessage();
        }

        $this->redirect("/Mini-4/public/post/{$postId}");
    }

    // Xóa bình luận (chỉ user đã tạo hoặc admin)
    public function delete($commentId) {
        if (!isset($_SESSION['user_id'])) {
            $this->redirect('/login');
        }

        $comment = $this->commentModel->findById($commentId);
        
        if (!$comment) {
            $_SESSION['error'] = 'Bình luận không tồn tại';
            $this->redirect('/');
        }

        $userId = $_SESSION['user_id'];
        $isAdmin = isset($_SESSION['role']) && $_SESSION['role'] === 'admin';
        
        // Chỉ cho phép xóa nếu là người tạo hoặc admin
        if ($comment['user_id'] != $userId && !$isAdmin) {
            $_SESSION['error'] = 'Bạn không có quyền xóa bình luận này';
            $this->redirect("/Mini-4/public/post/{$comment['post_id']}");
        }

        $result = $this->commentModel->deleteById($commentId);
        
        if ($result) {
            $_SESSION['success'] = 'Đã xóa bình luận thành công';
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa bình luận';
        }

        $this->redirect("/Mini-4/public/post/{$comment['post_id']}");
    }
}
?>
