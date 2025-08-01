<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin - Blog Mini</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="/css/style.css">
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
            <div class="container">
                <a class="navbar-brand" href="/admin">Admin Panel</a>
                <div class="navbar-nav">
                    <a class="nav-link" href="/admin/posts">Bài viết</a>
                    <a class="nav-link" href="/admin/categories">Danh mục</a>
                    <a class="nav-link" href="/admin/comments">Bình luận</a>
                    <a class="nav-link" href="/admin/users">Người dùng</a>
                    <a class="nav-link" href="/logout">Đăng xuất</a>
                </div>
            </div>
        </nav>
    </header>
    <main class="container mt-4">
        <?php require_once $view; ?>
    </main>
    <footer class="bg-light text-center py-3">
        <p>© 2025 Blog Mini</p>
    </footer>
    <script src="/js/script.js"></script>
</body>
</html>