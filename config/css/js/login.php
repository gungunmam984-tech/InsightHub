<?php
require_once 'config/db.php';

if (isset($_SESSION['admin'])) {
    header("Location: dashboard.php");
    exit;
}

$error = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = trim($_POST['username'] ?? '');
    $password = trim($_POST['password'] ?? '');

    if ($username && $password) {
        $stmt = $conn->prepare("SELECT * FROM admin WHERE username = ?");
        $stmt->bind_param("s", $username);
        $stmt->execute();
        $admin = $stmt->get_result()->fetch_assoc();

        // NOTE: Use password_verify() with hashed passwords in production
        if ($admin && $admin['password'] === $password) {
            $_SESSION['admin'] = $admin['id'];
            $_SESSION['admin_name'] = $admin['username'];
            header("Location: dashboard.php");
            exit;
        } else {
            $error = 'Invalid username or password.';
        }
    } else {
        $error = 'Please fill in all fields.';
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login — Luminary Blog</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>

<div class="login-page">
    <div class="login-card">
        <div class="login-logo">
            <a href="index.php" class="nav-logo" style="color: var(--primary); gap: 8px;">
                ✦ Lumin<span>ary</span>
            </a>
            <p>Admin Dashboard Login</p>
        </div>

        <?php if ($error): ?>
            <div class="alert alert-error">⚠ <?= htmlspecialchars($error) ?></div>
        <?php endif; ?>

        <form method="POST">
            <div class="form-group">
                <label>Username</label>
                <input type="text" name="username" placeholder="Enter username"
                       value="<?= htmlspecialchars($_POST['username'] ?? '') ?>" required autofocus>
            </div>
            <div class="form-group">
                <label>Password</label>
                <input type="password" name="password" placeholder="Enter password" required>
            </div>
            <button type="submit" class="btn btn-primary" style="width:100%; justify-content:center; margin-top: 8px;">
                Login to Dashboard →
            </button>
        </form>

        <div style="text-align: center; margin-top: 24px;">
            <a href="index.php" style="color: var(--text-light); font-size: 0.85rem; text-decoration: none;">
                ← Back to Blog
            </a>
        </div>
    </div>
</div>

<script src="js/main.js"></script>
</body>
</html>
