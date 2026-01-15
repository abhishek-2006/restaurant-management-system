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
    <title>Admin Login | GreenLeaf</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css">
</head>
<body class="admin-login-body">

    <div class="login-container">
        <div class="login-box">
            <img src="assets/img/logo.png" alt="GreenLeaf Logo" class="login-logo">
            
            <h2 class="login-title">Admin Access</h2>
            <p class="login-subtitle">Secure management portal</p>

            <?php if($error): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="admin@greenleaf.com" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" placeholder="••••••••" required>
                </div>
                <button type="submit" class="login-btn">Sign In</button>
            </form>
            
            <a href="../index.php" class="back-home">← Back to Site</a>
        </div>
    </div>

</body>
</html>