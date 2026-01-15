<?php
require 'config.php';

// Already logged-in admin → dashboard
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    // Fetch user by email (ANY role)
    $stmt = $dbh->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);

    if ($user && password_verify($password, $user['password'])) {

        $_SESSION['user_id'] = $user['user_id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];

        // Role-based redirect
        if ($user['role'] === 'admin') {
            header("Location: dashboard.php");
            exit();
        } else if ($user['role'] === 'guest') {
            header("Location: ../dashboard.php");
            exit();
        }

    } else if ($user) {
        // Email exists but password is wrong
        $error = "Invalid credentials.";
    } else {
        // Email not found
        $error = "Access denied.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Secure Admin Access | GreenLeaf</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css">
</head>
<body class="admin-login-body">
    <div class="login-container">
        <div class="login-box animate-in">
            <div class="login-header">
                <img src="assets/img/logo.png" alt="GreenLeaf Logo" class="login-logo">
                <h2 class="login-title">Admin Portal</h2>
                <p class="login-subtitle">Please enter your credentials to manage GreenLeaf.</p>
            </div>

            <?php if($error): ?>
                <div class="error-msg">
                    <span class="icon">⚠️</span> <?php echo $error; ?>
                </div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label for="email">Email Address</label>
                    <div class="input-wrapper">
                        <input type="email" id="email" name="email" placeholder="admin@example.com" required autofocus>
                    </div>
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <div class="input-wrapper">
                        <input type="password" id="password" name="password" placeholder="••••••••" required>
                    </div>
                </div>
                <button type="submit" class="login-btn">
                    Authorize & Sign In
                </button>
            </form>
            <div class="login-footer">
                <a href="../index.php" class="back-home">← Return to Public Site</a>
            </div>
        </div>
        <p class="copyright-text">&copy; 2026 GreenLeaf Management System</p>
    </div>
</body>
</html>