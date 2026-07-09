<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About — Luminary Blog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="nav-logo"><span class="logo-dot"></span>Lumin<span>ary</span></a>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php#blog">Articles</a></li>
        <li><a href="about.php" class="active">About</a></li>
        <li><a href="contact.php">Contact</a></li>
        <li><a href="login.php" class="btn-nav">Admin</a></li>
    </ul>
    <div class="hamburger"><span></span><span></span><span></span></div>
</nav>

<section class="page-hero">
    <div class="section-tag">👋 About Us</div>
    <h1>The Story Behind<br>Luminary</h1>
    <p>Passionate about words, ideas, and connecting people through storytelling.</p>
    <div class="breadcrumb">
        <a href="index.php">Home</a> / <span>About</span>
    </div>
</section>

<section class="section" style="background: var(--white);">
    <div class="about-grid">
        <div class="about-image-box">✍️</div>
        <div class="about-text">
            <div class="section-tag">Our Mission</div>
            <h2>Writing That<br>Inspires Action</h2>
            <p>Luminary Blog was born from a simple belief: that great writing has the power to change perspectives, spark ideas, and bring people together.</p>
            <p>We cover topics ranging from technology and design to philosophy and everyday life — always with depth, care, and authenticity.</p>
            <p>Every article is crafted with the reader in mind, delivering value without fluff. We believe in quality over quantity, and substance over style.</p>
            <div class="skills">
                <span class="skill-tag">✍ Writing</span>
                <span class="skill-tag">💡 Ideas</span>
                <span class="skill-tag">🎨 Design</span>
                <span class="skill-tag">💻 Tech</span>
                <span class="skill-tag">🌍 Culture</span>
                <span class="skill-tag">📚 Books</span>
                <span class="skill-tag">🔥 Lifestyle</span>
            </div>
            <a href="contact.php" class="btn btn-primary" style="margin-top: 30px; display: inline-flex;">
                Get in Touch →
            </a>
        </div>
    </div>
</section>

<!-- VALUES -->
<section class="section" style="background: var(--light);">
    <div class="section-header">
        <div class="section-tag">💎 Values</div>
        <h2 class="section-title">What We Stand For</h2>
    </div>
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 24px; max-width: 1000px; margin: 0 auto;">
        <?php
        $values = [
            ['🎯', 'Authenticity', 'Real voices, real stories, no filler content or fluff.'],
            ['💡', 'Clarity',     'Complex ideas made simple, without losing depth.'],
            ['❤️', 'Empathy',     'We write with readers in mind, always.'],
            ['🚀', 'Growth',      'Continuously improving and exploring new ideas.'],
        ];
        foreach ($values as $v): ?>
        <div class="stat-card">
            <div class="stat-icon red" style="font-size: 1.8rem; width: 60px; height: 60px;"><?= $v[0] ?></div>
            <div>
                <h4 style="font-family: 'Playfair Display', serif; font-size: 1.1rem; color: var(--primary); margin-bottom: 6px;"><?= $v[1] ?></h4>
                <p style="color: var(--text-light); font-size: 0.88rem;"><?= $v[2] ?></p>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>

<footer>
    <div class="footer-top">
        <div class="footer-brand">
            <a href="index.php" class="nav-logo">✦ Lumin<span>ary</span></a>
            <p>A premium blog for curious minds.</p>
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
    </div>
    <div class="footer-bottom">
        <p>© <?= date('Y') ?> Luminary Blog</p>
        <a href="index.php">← Back Home</a>
    </div>
</footer>

<button class="back-to-top">↑</button>
<script src="js/main.js"></script>
</body>
</html>
