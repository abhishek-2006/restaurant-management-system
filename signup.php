<?php 
include 'config.php';
$message = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = htmlspecialchars(trim($_POST['full_name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $phone = htmlspecialchars(trim($_POST['phone']));

    try {
        $stmt = $dbh->prepare("INSERT INTO users (full_name, email, password, phone) VALUES (?, ?, ?, ?)");
        $stmt->execute([$full_name, $email, $password, $phone]);
        $message = "Account created successfully! <a href='login.php'>Login here</a>";
    } catch (PDOException $e) {
        $message = "Error: Email might already be registered.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Join GreenLeaf | Sign Up</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/reservation-styles.css" type="text/css">
</head>
<body>

    <div class="reservation-wrapper">
        <header class="page-intro">
            <h1 class="main-title">Create Account 🌿</h1>
            <p class="subtitle">Join us for a personalized dining experience.</p>
        </header>

        <main class="form-container">
            <?php if($message): ?>
                <div class="message-box success"><?php echo $message; ?></div>
            <?php endif; ?>

            <form method="post" class="reservation-form">
                <div class="form-group">
                    <label>Full Name</label>
                    <input type="text" name="full_name" required>
                </div>
                <div class="form-group">
                    <label>Email</label>
                    <input type="email" name="email" required>
                </div>
                <div class="form-group">
                    <label>Phone</label>
                    <input type="tel" name="phone">
                </div>
                <div class="form-group">
                    <label>Password</label>
                    <input type="password" name="password" required>
                </div>
                <button type="submit" class="submit-btn">Sign Up</button>
            </form>
            <p style="margin-top:1rem; text-align:center;">Already have an account? <a href="login.php" style="color:var(--color-primary-green);">Login</a></p>
        </main>
    </div>

</body>
</html>