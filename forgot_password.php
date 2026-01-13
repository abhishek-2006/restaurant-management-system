<?php 
include 'config.php';
$activePage = 'forgot-password'; 
$message = "";
$message_class = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = htmlspecialchars(trim($_POST['email']));

    // Check if the email exists in the database
    $stmt = $dbh->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if ($user) {
        // In a real application, you would generate a token and send an email here.
        $message = "A password reset link has been sent to your email address.";
        $message_class = "success";
    } else {
        $message = "No account found with that email address.";
        $message_class = "error";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password | GreenLeaf Veg Restaurant</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/reservation-styles.css" type="text/css">
</head>
<body>
    <div class="reservation-wrapper">
        <header class="page-intro">
            <h1 class="main-title">Reset Password</h1>
            <p class="subtitle">Enter your email to receive a reset link.</p>
        </header>

        <main class="form-container" style="max-width: 500px; margin: 0 auto;">
            <?php if($message): ?>
                <div class="message-box <?php echo $message_class; ?>">
                    <?php echo $message; ?>
                </div>
            <?php endif; ?>

            <form method="post" class="reservation-form">
                <div class="form-group">
                    <label>Email Address</label>
                    <input type="email" name="email" placeholder="email@example.com" required>
                </div>
                <button type="submit" class="submit-btn">Send Reset Link</button>
            </form>
            
            <p style="margin-top:1.5rem; text-align:center;">
                Remembered your password? <a href="login.php" style="color:var(--color-primary-green); font-weight:600;">Back to Login</a>
            </p>
        </main>
    </div>
</body>
</html>