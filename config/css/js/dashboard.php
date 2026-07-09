<?php
require_once 'config/db.php';

if (!isset($_SESSION['admin'])) {
    header("Location: login.php");
    exit;
}

$posts  = $conn->query("SELECT * FROM posts ORDER BY created_at DESC")->fetch_all(MYSQLI_ASSOC);
$total  = count($posts);
$recent = count(array_filter($posts, fn($p) => strtotime($p['created_at']) > strtotime('-7 days')));

function excerpt($text, $len = 60) {
    $plain = strip_tags($text);
    return strlen($plain) > $len ? substr($plain, 0, $len) . '...' : $plain;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard — Luminary Blog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="dashboard-layout">
    <!-- SIDEBAR -->
    <aside class="sidebar">
        <div class="sidebar-logo">
            <a href="index.php" class="nav-logo" style="font-size: 1.3rem;">✦ Lumin<span>ary</span></a>
            <p style="color: rgba(255,255,255,0.4); font-size: 0.78rem; margin-top: 6px;">
                Welcome, <?= htmlspecialchars($_SESSION['admin_name'] ?? 'Admin') ?> 👋
            </p>
        </div>
        <ul class="sidebar-nav">
            <li><a href="dashboard.php" class="active"><span class="nav-icon">🏠</span> Dashboard</a></li>
            <li><a href="create_post.php"><span class="nav-icon">✏️</span> New Post</a></li>
            <li><a href="index.php" target="_blank"><span class="nav-icon">👁</span> View Blog</a></li>
            <div class="nav-divider"></div>
            <li><a href="about.php" target="_blank"><span class="nav-icon">ℹ️</span> About Page</a></li>
            <li><a href="contact.php" target="_blank"><span class="nav-icon">✉️</span> Contact Page</a></li>
            <div class="nav-divider"></div>
            <li class="danger"><a href="logout.php"><span class="nav-icon">🚪</span> Logout</a></li>
        </ul>
    </aside>

    <!-- MAIN -->
    <main class="dashboard-main">
        <div class="dashboard-header">
            <h1>Dashboard</h1>
            <p>Manage your blog posts and content.</p>
        </div>

        <!-- STATS -->
        <div class="stats-row">
            <div class="stat-card">
                <div class="stat-icon red">📝</div>
                <div class="stat-info">
                    <h3><?= $total ?></h3>
                    <p>Total Posts</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon blue">🆕</div>
                <div class="stat-info">
                    <h3><?= $recent ?></h3>
                    <p>This Week</p>
                </div>
            </div>
            <div class="stat-card">
                <div class="stat-icon gold">⭐</div>
                <div class="stat-info">
                    <h3><?= $total > 0 ? $posts[0]['id'] : 0 ?></h3>
                    <p>Latest ID</p>
                </div>
            </div>
        </div>

        <!-- POSTS TABLE -->
        <div class="posts-table-card">
            <div class="table-header">
                <h3>All Posts</h3>
                <a href="create_post.php" class="btn btn-primary" style="padding: 10px 22px; font-size: 0.85rem;">
                    + New Post
                </a>
            </div>
            <?php if (empty($posts)): ?>
                <div style="padding: 60px; text-align: center; color: var(--text-light);">
                    <div style="font-size: 3rem; margin-bottom: 16px;">📭</div>
                    <p>No posts yet. <a href="create_post.php" style="color: var(--accent);">Create your first post</a></p>
                </div>
            <?php else: ?>
                <div style="overflow-x: auto;">
                    <table>
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>Title</th>
                                <th>Excerpt</th>
                                <th>Date</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($posts as $post): ?>
                                <tr>
                                    <td><strong><?= $post['id'] ?></strong></td>
                                    <td>
                                        <a href="post.php?id=<?= $post['id'] ?>"
                                           style="color: var(--primary); text-decoration: none; font-weight: 600;"
                                           target="_blank">
                                            <?= htmlspecialchars(substr($post['title'], 0, 40)) ?>...
                                        </a>
                                    </td>
                                    <td style="color: var(--text-light);"><?= excerpt($post['content']) ?></td>
                                    <td style="color: var(--text-light); white-space: nowrap;">
                                        <?= date('M d, Y', strtotime($post['created_at'])) ?>
                                    </td>
                                    <td>
                                        <div class="action-buttons">
                                            <a href="edit_post.php?id=<?= $post['id'] ?>" class="btn-sm btn-edit">✏ Edit</a>
                                            <a href="delete_post.php?id=<?= $post['id'] ?>"
                                               class="btn-sm btn-delete"
                                               onclick="return confirm('Delete this post?')">🗑 Delete</a>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </main>
</div>

<script src="js/main.js"></script>
</body>
</html>
