<?php
require 'config.php';
$activePage = 'settings';

// Security: Admin access only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$message = "";

// Handle Settings Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_settings'])) {
    $total_tables = intval($_POST['total_tables']);
    
    try {
        $stmt = $dbh->prepare("UPDATE settings SET total_tables = ? WHERE id = 1");
        $stmt->execute([$total_tables]);
        $message = "Settings updated successfully!";
    } catch (PDOException $e) {
        $message = "Error updating settings: " . $e->getMessage();
    }
}

// Fetch current settings
$stmt = $dbh->query("SELECT total_tables FROM settings WHERE id = 1");
$settings = $stmt->fetch(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>System Settings | GreenLeaf Admin</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/admin-styles.css">
    <link rel="stylesheet" href="assets/css/index-styles.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h2>System Configuration</h2>
                <?php if($message): ?> 
                    <div style="padding:10px; background:#dcfce7; color:#166534; border-radius:8px;">
                        <?php echo $message; ?>
                    </div> 
                <?php endif; ?>
            </header>

            <section class="admin-card" style="max-width: 600px;">
                <h3 style="margin-bottom: 10px;">Restaurant Capacity</h3>
                <p style="color: #64748b; margin-bottom: 20px;">
                    Adjust the total number of tables available for reservation. 
                    This number is used to calculate slot availability in real-time.
                </p>

                <form method="POST">
                    <div class="form-group">
                        <label>Total Tables in Restaurant</label>
                        <input type="number" name="total_tables" 
                               value="<?php echo htmlspecialchars($settings['total_tables']); ?>" 
                               min="1" max="100" required
                               style="width: 100%; padding: 12px; border: 1px solid #cbd5e1; border-radius: 8px;">
                    </div>
                    
                    <button type="submit" name="update_settings" class="admin-login-btn">
                        Save Changes
                    </button>
                </form>
            </section>
        </main>
    </div>
</body>
</html>