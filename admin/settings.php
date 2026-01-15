<?php
require 'config.php';

// Security: Admin access only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$activePage = 'settings';
$message = "";

// Handle Settings Update
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_settings'])) {
    $total_tables = intval($_POST['total_tables']);
    
    try {
        $stmt = $dbh->prepare("UPDATE settings SET total_tables = ? WHERE id = 1");
        $stmt->execute([$total_tables]);
        $message = "System parameters updated successfully!";
    } catch (PDOException $e) {
        $message = "Update failed: " . $e->getMessage();
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
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>System Settings | GreenLeaf Admin</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"> <link rel="stylesheet" href="assets/css/admin-styles.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <div class="header-title">
                    <h2>System Configuration</h2>
                    <p class="subtitle">Global parameters for restaurant operations</p>
                </div>
                <?php if($message): ?> 
                    <div class="trend-badge positive" style="padding: 10px 20px; font-size: 0.9rem;">
                        ⚙️ <?php echo $message; ?>
                    </div> 
                <?php endif; ?>
            </header>

            <div style="display: flex; justify-content: center; margin-top: 2rem;">
                <section class="admin-card glass-morph" style="max-width: 600px; width: 100%;">
                    <div class="card-header" style="margin-bottom: 1.5rem;">
                        <h3 style="margin:0;">Restaurant Capacity</h3>
                    </div>
                    
                    <p style="color: var(--text-muted); font-size: 0.9rem; margin-bottom: 2rem; line-height: 1.6;">
                        Adjusting the <strong>Total Tables</strong> directly impacts real-time availability. 
                        The system uses this value to calculate if a time slot is fully booked on the guest reservation page.
                    </p>

                    <form method="POST">
                        <div class="form-group" style="margin-bottom: 2rem;">
                            <label style="font-size: 0.75rem; letter-spacing: 0.05em; color: var(--text-main);">
                                Maximum Table Capacity
                            </label>
                            <input type="number" name="total_tables" 
                                   value="<?php echo htmlspecialchars($settings['total_tables']); ?>" 
                                   min="1" max="100" required
                                   style="background: rgba(255,255,255,0.8); font-size: 1.2rem; font-weight: 700; text-align: center;">
                        </div>
                        
                        <button type="submit" name="update_settings" class="admin-login-btn" style="width: 100%; font-size: 1rem;">
                            Save System Configuration
                        </button>
                    </form>

                    <div style="margin-top: 2.5rem; padding-top: 1.5rem; border-top: 1px solid #e2e8f0;">
                        <h4 style="font-size: 0.8rem; text-transform: uppercase; color: var(--text-muted); margin-bottom: 10px;">
                            Quick Tip
                        </h4>
                        <p style="font-size: 0.85rem; color: var(--text-muted);">
                            If you are hosting a private event, you can temporarily set the tables to <strong>0</strong> to block all online bookings.
                        </p>
                    </div>
                </section>
            </div>
        </main>
    </div>
</body>
</html> 