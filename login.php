<?php 
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));
    $password = $_POST['password'];

    $stmt = $dbh->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user && password_verify($password, $user['password'])) {
        if ($user['role'] === 'guest') {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            header("Location: dashboard.php");
            exit();
        } elseif ($user['role'] === 'admin') {
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_name'] = $user['full_name'];
            $_SESSION['role'] = $user['role'];
            header("Location: admin/index.php");
            exit();
        }
    } else {
        $error = "Invalid email or password.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login | GreenLeaf Veg Restaurant</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/reservation-styles.css" type="text/css">
</head>
<body>
    <div class="reservation-wrapper">
        <header class="page-intro">
            <h1 class="main-title">Welcome Back</h1>
            <p class="subtitle">Login to manage your reservations.</p>
        </header>

        <main class="form-container" style="max-width: 500px; margin: 0 auto;">
            <?php if (isset($_GET['msg']) && $_GET['msg'] == 'login_required'): ?>
                <div class="message-box error">Please login to book a table.</div>
            <?php endif; ?>

            <form method="post" class="reservation-form">
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                    <a href="forgot_password.php" class="text-link" style="margin-top: 0.5rem; display: block; text-align: right;">Forgot Password?</a>
                </div>
                <button type="submit" class="submit-btn">Login</button>
            </form>
            <p style="margin-top:1rem; text-align:center;">New guest? <a href="signup.php" style="color:var(--color-primary-green);">Create an account</a></p>
        </main>
    </div>
</body>
</html>