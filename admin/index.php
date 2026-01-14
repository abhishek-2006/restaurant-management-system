<?php
require 'config.php';

// If already logged in as admin, skip login and go to dashboard
if (isset($_SESSION['user_id']) && $_SESSION['role'] === 'admin') {
    header("Location: dashboard.php");
    exit();
}

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    // Verify admin credentials strictly
    $stmt = $dbh->prepare("SELECT * FROM users WHERE email = ? AND role = 'admin'");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['user_name'] = $user['full_name'];
        $_SESSION['role'] = $user['role'];
        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Access Denied: Invalid Credentials.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | GreenLeaf</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css">
</head>
<body class="admin-login-body">

    <div class="login-container">
        <div class="login-box">
            <img src="../assets/img/logo.png" alt="GreenLeaf Logo" class="login-logo">
            
            <h2 class="login-title">Admin Access</h2>
            <p class="login-subtitle">Secure management portal</p>

            <?php if($error): ?>
                <div class="error-msg"><?php echo $error; ?></div>
            <?php endif; ?>

            <form method="POST" class="login-form">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" required placeholder="admin@greenleaf.com">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required placeholder="••••••••">
                </div>
                <button type="submit" class="login-btn">Sign In</button>
            </form>
            
            <a href="../index.php" class="back-home">← Back to Site</a>
        </div>
    </div>

</body>
</html>