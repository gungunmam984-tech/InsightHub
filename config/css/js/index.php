<?php
require_once 'config/db.php';

// Fetch all posts
$result = $conn->query("SELECT * FROM posts ORDER BY created_at DESC");
$posts  = $result->fetch_all(MYSQLI_ASSOC);
$totalPosts = count($posts);
$featured = $posts[0] ?? null;
$otherPosts = array_slice($posts, 1);

// Emoji icons for cards
$icons = ['📝','💡','🚀','🎨','💻','🌟','📚','✨','🔥','🎯'];

function excerpt($text, $length = 120) {
    $plain = strip_tags($text);
    return strlen($plain) > $length
        ? substr($plain, 0, $length) . '...'
        : $plain;
}

function readTime($text) {
    $words = str_word_count(strip_tags($text));
    $mins  = max(1, ceil($words / 200));
    return $mins . ' min read';
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Luminary Blog — Premium Stories & Insights</title>
    <meta name="description" content="Discover premium articles, deep insights, and inspiring stories on Luminary Blog.">
    <link rel="stylesheet" href="css/style.css">
    <link rel="icon" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 100 100'><text y='.9em' font-size='90'>✦</text></svg>">
</head>
<body>

<!-- LOADER -->
<div class="loader">
    <div class="loader-inner">
        <div class="loader-logo">✦ Luminary</div>
        <div class="loader-bar"><div class="loader-bar-fill"></div></div>
    </div>
</div>

<!-- NAVBAR -->
<nav class="navbar">
    <a href="index.php" class="nav-logo">
        <span class="logo-dot"></span>
        Lumin<span>ary</span>
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
    <div class="hamburger">
        <span></span><span></span><span></span>
    </div>
</nav>

<!-- HERO -->
<section class="hero">
    <div class="hero-glow"></div>
    <div class="hero-content">
        <div class="hero-badge">Premium Blog & Stories</div>
        <h1>Where Ideas<br>Come to <span class="highlight">Life</span></h1>
        <p>Explore thoughtful articles, deep insights, and inspiring stories crafted with passion and purpose.</p>
        <div class="hero-buttons">
            <a href="index.php#blog" class="btn btn-primary">✦ Explore Articles</a>
            <a href="about.php" class="btn btn-outline">Learn About Us</a>
        </div>
    </div>
    <div class="scroll-indicator">
        <div class="scroll-line"></div>
        Scroll
    </div>
</section>

<!-- FEATURED POST -->
<?php if ($featured): ?>
<section class="section featured-section">
    <div class="section-header">
        <div class="section-tag">⭐ Featured</div>
        <h2 class="section-title">Editor's Pick</h2>
        <p class="section-subtitle">Our most celebrated article this week</p>
    </div>
    <a href="post.php?id=<?= $featured['id'] ?>" class="featured-card" style="text-decoration:none;color:inherit;">
        <div class="featured-image">📰</div>
        <div class="featured-content">
            <div class="featured-label">✦ Featured Story</div>
            <h2><?= htmlspecialchars($featured['title']) ?></h2>
            <div class="post-meta">
                <span>📅 <?= date('M d, Y', strtotime($featured['created_at'])) ?></span>
                <span>⏱ <?= readTime($featured['content']) ?></span>
            </div>
            <p><?= excerpt($featured['content'], 160) ?></p>
            <span class="btn btn-primary">Read Article →</span>
        </div>
    </a>
</section>
<?php endif; ?>

<!-- STATS -->
<section class="stats-section">
    <div class="stats-grid">
        <div class="stat-item">
            <h3><span class="counter" data-target="<?= $totalPosts ?>">0</span><span>+</span></h3>
            <p>Articles</p>
        </div>
        <div class="stat-item">
            <h3><span class="counter" data-target="5000">0</span><span>+</span></h3>
            <p>Readers</p>
        </div>
        <div class="stat-item">
            <h3><span class="counter" data-target="50">0</span><span>+</span></h3>
            <p>Topics</p>
        </div>
        <div class="stat-item">
            <h3><span class="counter" data-target="3">0</span><span>+</span></h3>
            <p>Years</p>
        </div>
    </div>
</section>

<!-- BLOG GRID -->
<section class="section blog-section" id="blog">
    <div class="section-header">
        <div class="section-tag">📚 Latest</div>
        <h2 class="section-title">Recent Articles</h2>
        <p class="section-subtitle">Fresh perspectives and ideas published regularly</p>
    </div>

    <?php if (empty($posts)): ?>
        <div style="text-align:center; padding: 80px 20px; color: var(--text-light);">
            <div style="font-size: 4rem; margin-bottom: 20px;">📭</div>
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--primary); margin-bottom: 10px;">No Articles Yet</h3>
            <p>Check back soon — great content is coming!</p>
            <?php if (isset($_SESSION['admin'])): ?>
                <a href="create_post.php" class="btn btn-primary" style="margin-top: 24px;">+ Write First Post</a>
            <?php endif; ?>
        </div>
    <?php else: ?>
        <div class="blog-grid">
            <?php foreach ($otherPosts as $i => $post): ?>
                <a href="post.php?id=<?= $post['id'] ?>" class="post-card">
                    <div class="card-image">
                        <?= $icons[$i % count($icons)] ?>
                        <div class="card-category">Article</div>
                    </div>
                    <div class="card-body">
                        <div class="card-date">
                            📅 <?= date('M d, Y', strtotime($post['created_at'])) ?>
                        </div>
                        <h3 class="card-title"><?= htmlspecialchars($post['title']) ?></h3>
                        <p class="card-excerpt"><?= excerpt($post['content']) ?></p>
                        <div class="card-footer">
                            <span class="read-more">Read More →</span>
                            <span class="read-time">⏱ <?= readTime($post['content']) ?></span>
                        </div>
                    </div>
                </a>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</section>

<!-- NEWSLETTER -->
<section class="newsletter-section">
    <div class="newsletter-box">
        <div class="section-tag" style="background:rgba(255,255,255,0.1); color:#fff; border-color:rgba(255,255,255,0.2);">
            ✉ Newsletter
        </div>
        <h2>Stay in the Loop</h2>
        <p>Get our best articles delivered directly to your inbox. No spam, ever.</p>
        <form class="newsletter-form">
            <input type="email" placeholder="Enter your email address" required>
            <button type="submit" class="btn btn-primary">Subscribe</button>
        </form>
    </div>
</section>

<!-- FOOTER -->
<footer>
    <div class="footer-top">
        <div class="footer-brand">
            <a href="index.php" class="nav-logo">✦ Lumin<span>ary</span></a>
            <p>A premium blog exploring ideas, creativity, and human experience through thoughtful writing.</p>
            <div class="social-links">
                <a href="#" data-tooltip="Twitter">🐦</a>
                <a href="#" data-tooltip="Instagram">📷</a>
                <a href="#" data-tooltip="LinkedIn">💼</a>
                <a href="#" data-tooltip="RSS">📡</a>
            </div>
        </div>
        <div class="footer-col">
            <h4>Navigation</h4>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="index.php#blog">Articles</a></li>
                <li><a href="about.php">About</a></li>
                <li><a href="contact.php">Contact</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>More</h4>
            <ul>
                <li><a href="login.php">Admin Login</a></li>
                <li><a href="#">Privacy Policy</a></li>
                <li><a href="#">Terms of Use</a></li>
                <li><a href="#">Sitemap</a></li>
            </ul>
        </div>
    </div>
    <div class="footer-bottom">
        <p>© <?= date('Y') ?> Luminary Blog. Crafted with ❤️</p>
        <p>Made by <a href="#">Your Name</a></p>
    </div>
</footer>

<!-- BACK TO TOP -->
<button class="back-to-top" aria-label="Back to top">↑</button>

<script src="js/main.js"></script>
</body>
</html>
