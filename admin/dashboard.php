<?php
require 'config.php';
$activePage = 'dashboard';

// Strict Admin-only access
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Fetch Totals for the Dashboard Stats
try {
    $total_res = $dbh->query("SELECT COUNT(*) FROM reservations")->fetchColumn();
    $total_users = $dbh->query("SELECT COUNT(*) FROM users WHERE role='guest'")->fetchColumn();
    $total_menu = $dbh->query("SELECT COUNT(*) FROM menu")->fetchColumn();
    
    $today_date = date('Y-m-d');
    $stmt_today = $dbh->prepare("SELECT COUNT(*) FROM reservations WHERE reservation_date = ?");
    $stmt_today->execute([$today_date]);
    $new_today = $stmt_today->fetchColumn();
    $new_users = $dbh->query("SELECT COUNT(*) FROM users WHERE created_at >= NOW() - INTERVAL 1 DAY")->fetchColumn();
    
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
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css">
    <link rel="stylesheet" href="assets/css/admin-styles.css">
</head>
<body class="admin-body">

    <div class="admin-container">
        <?php include 'sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h2>Overview Dashboard</h2>
                <div class="admin-profile">
                    <span>Admin: <strong><?php echo $_SESSION['user_name']; ?></strong></span>
                </div>
            </header>

            <div class="stats-grid">
                <div class="stat-card glass-morph">
                    <div class="stat-header">
                        <div class="icon-box res-bg">📅</div>
                        <?php if($new_today > 0): ?>
                            <span class="trend-badge positive">+<?php echo $new_today; ?> Today</span>
                        <?php else: ?>
                            <span class="trend-badge neutral">No new bookings</span>
                        <?php endif; ?>
                    </div>
                    <div class="stat-content">
                        <h2 class="stat-number"><?php echo number_format($total_res); ?></h2>
                        <p class="stat-label">Total Reservations</p>
                    </div>
                </div>
                <div class="stat-card glass-morph">
                    <div class="stat-header">
                        <div class="icon-box user-bg">👥</div>
                        <span class="trend-badge <?php echo ($new_users > 0) ? 'positive' : 'neutral'; ?>">
                            <?php echo ($new_users > 0) ? "+$new_users New Guests" : "Stable"; ?>
                        </span>
                    </div>
                    <div class="stat-content">
                        <h2 class="stat-number"><?php echo number_format($total_users); ?></h2>
                        <p class="stat-label">Registered Members</p>
                    </div>
                </div>
                <div class="stat-card glass-morph">
                    <div class="stat-header">
                        <div class="icon-box menu-bg">🍛</div>
                        <a href="manage-menu.php" class="quick-action-link">Update Menu &rarr;</a>
                    </div>
                    <div class="stat-content">
                        <h2 class="stat-number"><?php echo $total_menu; ?></h2>
                        <p class="stat-label">Live Dishes</p>
                    </div>
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