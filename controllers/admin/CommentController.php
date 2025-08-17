<?php

namespace admin;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Comment.php';

class CommentController extends \Controller {
    private $commentModel;

    public function __construct() {
        // Kiểm tra quyền admin
        if (!isset($_SESSION['user_id']) || !isset($_SESSION['role']) || $_SESSION['role'] !== 'admin') {
            header('Location: /Mini-4/public/login');
            exit;
        }

        $this->commentModel = new \Comment();
    }

    // Hiển thị danh sách bình luận
    public function index() {
        $comments = $this->commentModel->getAllCommentsWithDetails();
        $this->view('admin/comments/index', ['comments' => $comments]);
    }

    // Duyệt bình luận
    public function approve($id) {
        $this->commentModel->approve($id);
        header('Location: /Mini-4/public/admin/comments');
        exit;
    }

    // Từ chối bình luận
    public function reject($id) {
        $this->commentModel->reject($id);
        header('Location: /Mini-4/public/admin/comments');
        exit;
    }

    // Xóa bình luận
    public function delete($id) {
        if ($this->commentModel->delete($id)) {
            $_SESSION['success'] = 'Đã xóa bình luận thành công!';
        } else {
            $_SESSION['error'] = 'Không thể xóa bình luận. Vui lòng thử lại!';
        }
        header('Location: /Mini-4/public/admin/comments');
        exit;
    }
}
