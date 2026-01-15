<?php
require 'config.php';

// Security: Admin access only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$message = "";

// Handle Delete Reservation
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $dbh->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Reservation removed successfully.";
}

// Fetch all reservations, newest first
$stmt = $dbh->query("SELECT * FROM reservations ORDER BY reservation_date DESC, reservation_time DESC");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Reservations | GreenLeaf Admin</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/admin-styles.css">
    <link rel="stylesheet" href="assets/css/index-styles.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <aside class="admin-sidebar">
            <div class="admin-logo">
                <img src="assets/img/logo.png" alt="Logo" class="sidebar-logo">
                <h3>Admin Panel</h3>
            </div>
            <nav class="sidebar-nav">
                <a href="dashboard.php">📊 Dashboard</a>
                <a href="manage-reservations.php" class="active">📅 Reservations</a>
                <a href="manage-menu.php">🍛 Menu Items</a>
                <a href="logout.php">🚪 Logout</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="admin-header">
                <h2>Guest Reservations</h2>
                <?php if($message): ?> 
                    <div style="padding:10px; background:#dcfce7; color:#166534; border-radius:8px;">
                        <?php echo $message; ?>
                    </div> 
                <?php endif; ?>
            </header>

            <section class="admin-card">
                <h3>All Bookings</h3>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Guest Name</th>
                                <th>Contact Details</th>
                                <th>Date & Time</th>
                                <th>Guests</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($reservations): ?>
                                <?php foreach ($reservations as $res): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($res['name']); ?></strong></td>
                                    <td>
                                        <small><?php echo htmlspecialchars($res['email']); ?></small><br>
                                        <small><?php echo htmlspecialchars($res['phone']); ?></small>
                                    </td>
                                    <td>
                                        <?php echo date('D, M j, Y', strtotime($res['reservation_date'])); ?><br>
                                        <span style="color:var(--primary-green); font-weight:bold;">
                                            <?php echo $res['reservation_time']; ?>
                                        </span>
                                    </td>
                                    <td><?php echo $res['guests']; ?> People</td>
                                    <td>
                                        <a href="?delete=<?php echo $res['id']; ?>" 
                                           style="color:#ef4444; text-decoration:none;" 
                                           onclick="return confirm('Delete this reservation?')">Cancel/Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="5" style="text-align:center; padding:20px;">No reservations found.</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>