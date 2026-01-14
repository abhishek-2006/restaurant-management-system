<?php
require 'config.php';

// Strict Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: ../login.php?msg=admin_only");
    exit();
}

// Fetch Totals for the Dashboard Stats
try {
    $total_res = $dbh->query("SELECT COUNT(*) FROM reservations")->fetchColumn();
    $total_users = $dbh->query("SELECT COUNT(*) FROM users WHERE role='guest'")->fetchColumn();
    $total_menu = $dbh->query("SELECT COUNT(*) FROM menu")->fetchColumn();
    
    // Fetch 5 most recent reservations
    $recent_stmt = $dbh->prepare("SELECT * FROM reservations ORDER BY created_at DESC LIMIT 5");
    $recent_stmt->execute();
    $recent_bookings = $recent_stmt->fetchAll();
} catch (PDOException $e) {
    die("Database Error: " . $e->getMessage());
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel | GreenLeaf</title>
    <link rel="icon" type="image/x-icon" href="../assets/img/favicon.ico">
    <link rel="stylesheet" href="../assets/css/index-styles.css">
    <link rel="stylesheet" href="admin-styles.css">
</head>
<body class="admin-body">

    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <img src="../assets/img/logo.png" alt="Logo" class="sidebar-logo">
                <h3>GreenLeaf Admin</h3>
            </div>
            <nav class="sidebar-nav">
                <a href="index.php" class="active">📊 Dashboard</a>
                <a href="manage-reservations.php">📅 Reservations</a>
                <a href="manage-menu.php">🍛 Menu Items</a>
                <a href="manage-users.php">👥 Users</a>
                <a href="settings.php">⚙️ Settings</a>
                <hr>
                <a href="../logout.php" class="logout-link">🚪 Logout</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="admin-header">
                <h2>Overview Dashboard</h2>
                <div class="admin-profile">
                    <span>Admin: <strong><?php echo $_SESSION['user_name']; ?></strong></span>
                </div>
            </header>

            <div class="stats-grid">
                <div class="stat-card">
                    <h3><?php echo $total_res; ?></h3>
                    <p>Total Reservations</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $total_users; ?></h3>
                    <p>Registered Guests</p>
                </div>
                <div class="stat-card">
                    <h3><?php echo $total_menu; ?></h3>
                    <p>Menu Items</p>
                </div>
            </div>

            <div class="admin-card">
                <h3>Recent Reservations</h3>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Date</th>
                                <th>Time</th>
                                <th>Phone</th>
                                <th>Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach($recent_bookings as $res): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($res['name']); ?></td>
                                <td><?php echo $res['reservation_date']; ?></td>
                                <td><?php echo $res['reservation_time']; ?></td>
                                <td><?php echo $res['phone']; ?></td>
                                <td><span class="badge badge-success">New</span></td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>
</html>