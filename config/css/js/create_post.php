<?php
require_once 'config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$success = $error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title   = trim($_POST['title'] ?? '');
    $content = trim($_POST['content'] ?? '');

    if ($title && $content) {
        $stmt = $conn->prepare("INSERT INTO posts (title, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $title, $content);
        if ($stmt->execute()) {
            $success = '✓ Post published successfully!';
        } else {
            $error = 'Failed to create post. Please try again.';
        }
    } else {
        $error = 'Title and content are required.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Post — Luminary Blog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard-layout">
    <aside class="sidebar">
        <div class="sidebar-logo">
            <a href="index.php" class="nav-logo" style="font-size: 1.3rem;">✦ Lumin<span>ary</span></a>
        </div>
        <ul class="sidebar-nav">
            <li><a href="dashboard.php"><span class="nav-icon">🏠</span> Dashboard</a></li>
            <li><a href="create_post.php" class="active"><span class="nav-icon">✏️</span> New Post</a></li>
            <li><a href="index.php" target="_blank"><span class="nav-icon">👁</span> View Blog</a></li>
            <div class="nav-divider"></div>
            <li class="danger"><a href="logout.php"><span class="nav-icon">🚪</span> Logout</a></li>
        </ul>
    </aside>

    <main class="dashboard-main">
        <div class="dashboard-header">
            <h1>Create New Post</h1>
            <p>Write and publish a new article to your blog.</p>
        </div>

        <?php if ($success): ?>
            <div class="alert alert-success"><?= $success ?></div>
        <?php endif; ?>
        <?php if ($error): ?>
            <div class="alert alert-error">⚠ <?= $error ?></div>
        <?php endif; ?>

        <div class="form-card">
            <form method="POST">
                <div class="form-group">
                    <label>Post Title *</label>
                    <input type="text" name="title" placeholder="Enter a compelling title..."
                           value="<?= htmlspecialchars($_POST['title'] ?? '') ?>" required>
                </div>
                <div class="form-group">
                    <label>Content *</label>
                    <textarea name="content" placeholder="Write your article here..." required
                              style="min-height: 400px;"><?= htmlspecialchars($_POST['content'] ?? '') ?></textarea>
                </div>
                <div style="display: flex; gap: 16px; flex-wrap: wrap;">
                    <button type="submit" class="btn btn-primary">✦ Publish Post</button>
                    <a href="dashboard.php" class="btn btn-dark">← Cancel</a>
                </div>
            </form>
        </div>
    </main>
</div>

<script src="js/main.js"></script>
</body>
</html>
