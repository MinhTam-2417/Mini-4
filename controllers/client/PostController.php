<?php

namespace client;
require_once __DIR__ . '/../../core/Controller.php';
require_once __DIR__ . '/../../models/Post.php';
require_once __DIR__ . '/../../models/Category.php';
require_once __DIR__ . '/../../models/Comment.php';
require_once __DIR__ . '/../../models/Tag.php';

class PostController extends \Controller {
    private $postModel;
    private $categoryModel;
    private $commentModel;
    private $tagModel;

    public function __construct() {
        $this->postModel = new \Post();
        $this->categoryModel = new \Category();
        $this->commentModel = new \Comment();
        $this->tagModel = new \Tag();
    }

    // Hiển thị trang tạo bài viết - CHO PHÉP TẤT CẢ USER ĐÃ ĐĂNG NHẬP
    public function create() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để tạo bài viết.';
            header('Location: /Mini-4/public/login');
            exit;
        }

        $categories = $this->categoryModel->getAll();
        $tags = $this->tagModel->getAll();
        $this->view('client/post/create', [
            'categories' => $categories,
            'tags' => $tags,
            'current_page' => 'create',
            'page_title' => 'Tạo bài viết'
        ]);
    }

    // Lưu bài viết mới - CHO PHÉP TẤT CẢ USER ĐÃ ĐĂNG NHẬP
    public function store() {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để tạo bài viết.';
            header('Location: /Mini-4/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/post/create');
            exit;
        }

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $excerpt = $_POST['excerpt'] ?? '';
        $categoryId = $_POST['category_id'] ?? '';
        $action = $_POST['action'] ?? 'draft';
        $status = ($action === 'publish') ? 'published' : 'draft';
        $imageFit = $_POST['image_fit'] ?? 'contain';

        // Validation
        if (empty($title) || empty($content)) {
            $_SESSION['error'] = 'Vui lòng nhập tiêu đề và nội dung bài viết';
            header('Location: /Mini-4/public/post/create');
            exit;
        }

        // Tạo slug từ title
        $slug = $this->createSlug($title);

        // Tạo excerpt nếu không có
        if (empty($excerpt)) {
            $excerpt = substr(strip_tags($content), 0, 200) . '...';
        }

        // Xử lý upload hình ảnh
        $featuredImage = null;
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/images/';
            $fileExtension = strtolower(pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadPath)) {
                    $featuredImage = 'uploads/images/' . $fileName;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi upload hình ảnh';
                    header('Location: /Mini-4/public/post/create');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Chỉ chấp nhận file hình ảnh (JPG, PNG, GIF, WebP)';
                header('Location: /Mini-4/public/post/create');
                exit;
            }
        }

        $postData = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'featured_image' => $featuredImage,
            'image_fit' => $imageFit,
            'category_id' => $categoryId ?: null,
            'user_id' => $_SESSION['user_id'],
            'status' => $status
        ];

        $postId = $this->postModel->create($postData);

        if ($postId) {
            // Xử lý tags
            if (isset($_POST['tags']) && is_array($_POST['tags'])) {
                $tagIds = array_filter($_POST['tags']); // Loại bỏ giá trị rỗng
                if (!empty($tagIds)) {
                    $this->tagModel->addTagsToPost($postId, $tagIds);
                }
            }

            $_SESSION['success'] = 'Bài viết đã được tạo thành công!';
            header('Location: /Mini-4/public/post/' . $postId);
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi tạo bài viết';
            header('Location: /Mini-4/public/post/create');
        }
        exit;
    }

    // Hiển thị chi tiết bài viết
    public function show($id) {
        $userId = $_SESSION['user_id'] ?? null;
        $post = $this->postModel->findWithLikeInfo($id, $userId);
        if (!$post) {
            http_response_code(404);
            echo "Bài viết không tồn tại";
            return;
        }

        // Lấy tags của bài viết
        $post['tags'] = $this->tagModel->getTagsByPost($id);

        // Tăng lượt xem
        $this->postModel->incrementViews($id);

        // Lấy comments
        $comments = $this->commentModel->getByPostId($id);
        
        // Lấy bài viết liên quan
        $relatedPosts = $this->postModel->getRelatedPosts($post['category_id'], $id, 3);

        $this->view('client/post_detail', [
            'post' => $post,
            'comments' => $comments,
            'relatedPosts' => $relatedPosts,
            'current_page' => 'post',
            'page_title' => $post['title']
        ]);
    }

    // Thêm comment
    public function comment($postId) {
        if (!isset($_SESSION['user_id'])) {
            header('Location: /Mini-4/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/post/' . $postId);
            exit;
        }

        $content = $_POST['content'] ?? '';
        if (empty($content)) {
            $_SESSION['error'] = 'Vui lòng nhập nội dung bình luận';
            header('Location: /Mini-4/public/post/' . $postId);
            exit;
        }

        $commentData = [
            'content' => $content,
            'user_id' => $_SESSION['user_id'],
            'post_id' => $postId,
            'status' => 'approved'
        ];

        $commentId = $this->commentModel->create($commentData);
        
        if ($commentId) {
            header('Location: /Mini-4/public/post/' . $postId);
            exit;
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi gửi bình luận';
            header('Location: /Mini-4/public/post/' . $postId);
            exit;
        }
    }

    // Hiển thị form chỉnh sửa bài viết - CHO PHÉP USER CHỈNH SỬA BÀI VIẾT CỦA MÌNH
    public function edit($id) {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để chỉnh sửa bài viết.';
            header('Location: /Mini-4/public/login');
            exit;
        }

        $post = $this->postModel->findById($id);
        if (!$post) {
            $_SESSION['error'] = 'Không tìm thấy bài viết';
            header('Location: /Mini-4/public/');
            exit;
        }

        // Kiểm tra quyền: chỉ cho phép tác giả hoặc admin chỉnh sửa
        if ($post['user_id'] != $_SESSION['user_id'] && (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')) {
            $_SESSION['error'] = 'Bạn không có quyền chỉnh sửa bài viết này';
            header('Location: /Mini-4/public/post/' . $id);
            exit;
        }
        
        $categories = $this->categoryModel->getAll();
        $tags = $this->tagModel->getAll();
        $postTags = $this->tagModel->getTagsByPost($id);
        $this->view('client/post/edit', [
            'post' => $post, 
            'categories' => $categories,
            'tags' => $tags,
            'postTags' => $postTags,
            'current_page' => 'edit',
            'page_title' => 'Chỉnh sửa bài viết'
        ]);
    }

    // Cập nhật bài viết - CHO PHÉP USER CẬP NHẬT BÀI VIẾT CỦA MÌNH
    public function update($id) {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để cập nhật bài viết.';
            header('Location: /Mini-4/public/login');
            exit;
        }

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Location: /Mini-4/public/post/' . $id . '/edit');
            exit;
        }

        $post = $this->postModel->findById($id);
        if (!$post) {
            $_SESSION['error'] = 'Không tìm thấy bài viết';
            header('Location: /Mini-4/public/');
            exit;
        }

        // Kiểm tra quyền: chỉ cho phép tác giả hoặc admin cập nhật
        if ($post['user_id'] != $_SESSION['user_id'] && (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')) {
            $_SESSION['error'] = 'Bạn không có quyền cập nhật bài viết này';
            header('Location: /Mini-4/public/post/' . $id);
            exit;
        }

        $title = $_POST['title'] ?? '';
        $content = $_POST['content'] ?? '';
        $excerpt = $_POST['excerpt'] ?? '';
        $categoryId = $_POST['category_id'] ?? '';
        $action = $_POST['action'] ?? 'draft';
        $status = ($action === 'publish') ? 'published' : 'draft';
        $imageFit = $_POST['image_fit'] ?? 'contain';

        // Validation
        if (empty($title) || empty($content)) {
            $_SESSION['error'] = 'Vui lòng nhập tiêu đề và nội dung bài viết';
            header('Location: /Mini-4/public/post/' . $id . '/edit');
            exit;
        }

        // Tạo slug từ title
        $slug = $this->createSlug($title);

        // Tạo excerpt nếu không có
        if (empty($excerpt)) {
            $excerpt = substr(strip_tags($content), 0, 200) . '...';
        }

        // Xử lý upload hình ảnh mới
        $featuredImage = $post['featured_image']; // Giữ lại hình cũ
        if (isset($_FILES['featured_image']) && $_FILES['featured_image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = __DIR__ . '/../../public/uploads/images/';
            $fileExtension = strtolower(pathinfo($_FILES['featured_image']['name'], PATHINFO_EXTENSION));
            $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            
            if (in_array($fileExtension, $allowedExtensions)) {
                $fileName = uniqid() . '_' . time() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;
                
                if (move_uploaded_file($_FILES['featured_image']['tmp_name'], $uploadPath)) {
                    // Xóa hình cũ nếu có
                    if ($post['featured_image'] && file_exists(__DIR__ . '/../../public/' . $post['featured_image'])) {
                        unlink(__DIR__ . '/../../public/' . $post['featured_image']);
                    }
                    $featuredImage = 'uploads/images/' . $fileName;
                } else {
                    $_SESSION['error'] = 'Có lỗi xảy ra khi upload hình ảnh';
                    header('Location: /Mini-4/public/post/' . $id . '/edit');
                    exit;
                }
            } else {
                $_SESSION['error'] = 'Chỉ chấp nhận file hình ảnh (JPG, PNG, GIF, WebP)';
                header('Location: /Mini-4/public/post/' . $id . '/edit');
                exit;
            }
        }

        $postData = [
            'title' => $title,
            'slug' => $slug,
            'content' => $content,
            'excerpt' => $excerpt,
            'featured_image' => $featuredImage,
            'image_fit' => $imageFit,
            'category_id' => $categoryId ?: null,
            'status' => $status
        ];

        if ($this->postModel->update($id, $postData)) {
            // Xử lý tags
            if (isset($_POST['tags']) && is_array($_POST['tags'])) {
                $tagIds = array_filter($_POST['tags']); // Loại bỏ giá trị rỗng
                $this->tagModel->addTagsToPost($id, $tagIds);
            } else {
                // Nếu không có tags được chọn, xóa tất cả tags
                $this->tagModel->removeTagsFromPost($id);
            }

            $_SESSION['success'] = 'Bài viết đã được cập nhật thành công!';
            header('Location: /Mini-4/public/post/' . $id);
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi cập nhật bài viết';
            header('Location: /Mini-4/public/post/' . $id . '/edit');
        }
        exit;
    }

    // Xóa bài viết - CHO PHÉP USER XÓA BÀI VIẾT CỦA MÌNH
    public function delete($id) {
        // Kiểm tra đăng nhập
        if (!isset($_SESSION['user_id'])) {
            $_SESSION['error'] = 'Bạn cần đăng nhập để xóa bài viết.';
            header('Location: /Mini-4/public/login');
            exit;
        }

        $post = $this->postModel->findById($id);
        if (!$post) {
            $_SESSION['error'] = 'Không tìm thấy bài viết';
            header('Location: /Mini-4/public/');
            exit;
        }

        // Kiểm tra quyền: chỉ cho phép tác giả hoặc admin xóa
        if ($post['user_id'] != $_SESSION['user_id'] && (!isset($_SESSION['role']) || $_SESSION['role'] !== 'admin')) {
            $_SESSION['error'] = 'Bạn không có quyền xóa bài viết này';
            header('Location: /Mini-4/public/post/' . $id);
            exit;
        }

        // Xóa hình ảnh nếu có
        if ($post['featured_image'] && file_exists(__DIR__ . '/../../public/' . $post['featured_image'])) {
            unlink(__DIR__ . '/../../public/' . $post['featured_image']);
        }

        // Xóa comments của bài viết
        $this->commentModel->deleteByPostId($id);

        // Xóa bài viết
        if ($this->postModel->delete($id)) {
            $_SESSION['success'] = 'Bài viết đã được xóa thành công!';
            header('Location: /Mini-4/public/');
        } else {
            $_SESSION['error'] = 'Có lỗi xảy ra khi xóa bài viết';
            header('Location: /Mini-4/public/post/' . $id);
        }
        exit;
    }

    // Tạo slug từ title
    private function createSlug($title) {
        $slug = strtolower(trim($title));
        $slug = preg_replace('/[^a-z0-9-]/', '-', $slug);
        $slug = preg_replace('/-+/', '-', $slug);
        $slug = trim($slug, '-');
        
        // Thêm timestamp để đảm bảo unique
        $slug .= '-' . time();
        
        return $slug;
    }
}
?>
