<?php
require 'config.php';
$activePage = 'dashboard';

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
    $recent_stmt = $dbh->prepare("SELECT * FROM reservations ORDER BY created_at DESC");
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