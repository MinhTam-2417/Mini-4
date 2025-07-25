<?php
ob_start();
?>
<h2>Danh sách bài viết</h2>
<?php foreach ($post as $post): ?>
    <article>
        <h3><a href="/post/<?php echo $post['id']; ?>"><?php echo htmlspecialchars($post['title']); ?></a></h3>
        <p><?php echo htmlspecialchars($post['excerpt']); ?></p>
        <p>Ngày đăng: <?php echo $post['created_at']; ?></p>
    </article>
    <?php endforeach; ?>
    <?php
    $content = ob_get_clean();
    require_once 'layouts/main.php';
?>