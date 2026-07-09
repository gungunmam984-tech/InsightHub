<?php require_once 'config/db.php'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact — Luminary Blog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<nav class="navbar">
    <a href="index.php" class="nav-logo"><span class="logo-dot"></span>Lumin<span>ary</span></a>
    <ul class="nav-links">
        <li><a href="index.php">Home</a></li>
        <li><a href="index.php#blog">Articles</a></li>
        <li><a href="about.php">About</a></li>
        <li><a href="contact.php" class="active">Contact</a></li>
        <li><a href="login.php" class="btn-nav">Admin</a></li>
    </ul>
    <div class="hamburger"><span></span><span></span><span></span></div>
</nav>

<section class="page-hero">
    <div class="section-tag">✉ Contact</div>
    <h1>Let's Start a<br>Conversation</h1>
    <p>Have a question, suggestion, or just want to say hello? We'd love to hear from you.</p>
    <div class="breadcrumb"><a href="index.php">Home</a> / <span>Contact</span></div>
</section>

<section class="section" style="background: var(--white);">
    <div class="contact-grid">
        <div class="contact-info">
            <h3>Get in Touch</h3>
            <p>We usually respond within 24 hours. Don't hesitate to reach out — every message is welcome.</p>

            <div class="contact-item">
                <div class="contact-icon">📧</div>
                <div>
                    <small>Email</small>
                    <p>hello@luminary.blog</p>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">🐦</div>
                <div>
                    <small>Twitter</small>
                    <p>@LuminaryBlog</p>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">📍</div>
                <div>
                    <small>Location</small>
                    <p>Available Worldwide</p>
                </div>
            </div>
            <div class="contact-item">
                <div class="contact-icon">⏰</div>
                <div>
                    <small>Response Time</small>
                    <p>Within 24 Hours</p>
                </div>
            </div>
        </div>

        <div class="form-card">
            <h3 style="font-family: 'Playfair Display', serif; font-size: 1.5rem; color: var(--primary); margin-bottom: 24px;">
                Send a Message
            </h3>
            <form id="contactForm">
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 16px;">
                    <div class="form-group">
                        <label>First Name</label>
                        <input type="text" placeholder="John" required>
                    </div>
                    <div class="form-group">
                        <label>Last Name</label>
                        <input type="text" placeholder="Doe" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" placeholder="john@example.com" required>
                </div>
                <div class="form-group">
                    <label>Subject</label>
                    <input type="text" placeholder="What's this about?" required>
                </div>
                <div class="form-group">
                    <label>Message</label>
                    <textarea placeholder="Tell us everything..." required></textarea>
                </div>
                <button type="submit" class="btn btn-primary" style="width: 100%; justify-content: center;">
                    Send Message →
                </button>
            </form>
        </div>
    </div>
</section>

<footer>
    <div class="footer-bottom" style="padding: 30px 5%;">
        <p>© <?= date('Y') ?> Luminary Blog</p>
        <a href="index.php" style="color: var(--accent);">← Back Home</a>
    </div>
</footer>

<button class="back-to-top">↑</button>
<script src="js/main.js"></script>
</body>
</html>
