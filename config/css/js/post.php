<?php
require_once 'config/db.php';

$id   = intval($_GET['id'] ?? 0);
$stmt = $conn->prepare("SELECT * FROM posts WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$post = $stmt->get_result()->fetch_assoc();

if (!$post) {
    header("Location: index.php");
    exit;
}

// Related posts
$related = $conn->query("SELECT * FROM posts WHERE id != $id ORDER BY RAND() LIMIT 3")->fetch_all(MYSQLI_ASSOC);

function readTime($text) {
    $words = str_word_count(strip_tags($text));
    return max(1, ceil($words / 200)) . ' min read';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($post['title']) ?> — Luminary Blog</title>
    <link rel="stylesheet" href="css/style.css">
    <style>
        .reading-progress-bar {
            position: fixed;
            top: 0;
            left: 0;
            height: 3px;
            background: linear-gradient(90deg, var(--accent), var(--gold));
            z-index: 9999;
            transition: width 0.1s;
        }
    </style>
</head>
<body>

<div class="reading-progress-bar reading-progress" style="width:0%"></div>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="index.php" class="nav-logo">
        <span class="logo-dot"></span>Lumin<span>ary</span>
    </a>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php#blog">Articles</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <?php if (isset($_SESSION['admin'])): ?>
            <li><a href="dashboard.php" class="btn-nav">Dashboard</a></li>
        <?php else: ?>
            <li><a href="login.php" class="btn-nav">Admin</a></li>
        <?php endif; ?>
    </ul>
    <div class="hamburger"><span></span><span></span><span></span></div>
</nav>

<!-- POST HERO -->
<section class="post-hero">
    <div class="section-tag">📝 Article</div>
    <h1><?= htmlspecialchars($post['title']) ?></h1>
    <div class="post-meta">
        <span>📅 <?= date('F d, Y', strtotime($post['created_at'])) ?></span>
        <span>•</span>
        <span>⏱ <?= readTime($post['content']) ?></span>
        <span>•</span>
        <span>✍ Admin</span>
    </div>
    <div class="breadcrumb">
        <a href="index.php">Home</a> /
        <a href="index.php#blog">Articles</a> /
        <span><?= htmlspecialchars(substr($post['title'], 0, 30)) ?>...</span>
    </div>
</section>

<!-- POST BODY -->
<div class="post-body">
    <div class="post-content">
        <?= nl2br(htmlspecialchars($post['content'])) ?>
    </div>

    <!-- SHARE -->
    <div style="margin: 50px 0; padding: 30px; background: var(--light); border-radius: 16px; text-align: center;">
        <p style="font-weight: 600; margin-bottom: 16px; color: var(--primary);">✦ Enjoyed this article?</p>
        <div style="display: flex; gap: 12px; justify-content: center; flex-wrap: wrap;">
            <a href="https://twitter.com/intent/tweet?text=<?= urlencode($post['title']) ?>&url=<?= urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']) ?>"
               target="_blank" class="btn btn-dark" style="padding: 10px 20px; font-size: 0.85rem;">🐦 Share on Twitter</a>
            <a href="index.php" class="btn btn-outline" style="color: var(--primary); border-color: var(--border); padding: 10px 20px; font-size: 0.85rem;">← More Articles</a>
            <?php if (isset($_SESSION['admin'])): ?>
                <a href="edit_post.php?id=<?= $post['id'] ?>" class="btn btn-primary" style="padding: 10px 20px; font-size: 0.85rem;">✏ Edit Post</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- RELATED POSTS -->
<?php if (!empty($related)): ?>
<section class="section blog-section" style="padding-top: 0;">
    <div class="section-header">
        <div class="section-tag">📚 More</div>
        <h2 class="section-title">Related Articles</h2>
    </div>
    <div class="blog-grid">
        <?php foreach ($related as $rel): ?>
            <a href="post.php?id=<?= $rel['id'] ?>" class="post-card">
                <div class="card-image">📝<div class="card-category">Article</div></div>
                <div class="card-body">
                    <div class="card-date">📅 <?= date('M d, Y', strtotime($rel['created_at'])) ?></div>
                    <h3 class="card-title"><?= htmlspecialchars($rel['title']) ?></h3>
                    <div class="card-footer">
                        <span class="read-more">Read More →</span>
                    </div>
                </div>
            </a>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<footer>
    <div class="footer-bottom" style="border-top: 1px solid rgba(255,255,255,0.1); padding-top: 30px;">
        <p>© <?= date('Y') ?> Luminary Blog. Crafted with ❤️</p>
        <a href="index.php" style="color: var(--accent);">← Back to Home</a>
    </div>
</footer>

<button class="back-to-top">↑</button>
<script src="js/main.js"></script>
</body>
</html>
