<?php
require 'config.php';

// Admin Security Guard
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$activePage = 'reservations';
$message = "";
$today = date('Y-m-d');

// 1. AUTO-LOGIC: Cancel pending bookings from past dates
$dbh->prepare("UPDATE reservations SET status = 'cancelled' 
               WHERE reservation_date < ? AND status = 'pending'")
    ->execute([$today]);

// 2. ACTION: Handle Status Updates (Check-in / Complete / Cancel)
if (isset($_GET['update_id']) && isset($_GET['new_status'])) {
    $id = intval($_GET['update_id']);
    $status = $_GET['new_status'];
    
    $stmt = $dbh->prepare("UPDATE reservations SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    $message = "Reservation updated to " . ucfirst($status);
}

// 3. FETCH: Get all reservations sorted by date
$stmt = $dbh->query("SELECT * FROM reservations ORDER BY reservation_date DESC, reservation_time ASC");
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Reservations | GreenLeaf Admin</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/admin-styles.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <div class="header-title">
                    <h2>Reservation Intelligence</h2>
                    <p class="subtitle">Manage the lifecycle of guest bookings</p>
                </div>

                <div class="header-actions">
                    <a href="print-reservations.php" target="_blank" class="admin-login-btn" style="text-decoration:none; background:#64748b; display:flex; align-items:center; gap:8px;">
                        <span>🖨️</span> Print Daily Log
                    </a>
                </div>
            </header>

            <?php if($message): ?> 
                <div class="trend-badge positive" style="margin-bottom:20px; display:inline-block; padding:10px 20px;">
                    ✨ <?php echo $message; ?>
                </div> 
            <?php endif; ?>

            <section class="admin-card glass-morph">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Guest</th>
                                <th>Status</th>
                                <th>Date & Time</th>
                                <th>Party</th>
                                <th style="text-align:right;">Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($reservations as $res): ?>
                            <tr class="table-row-hover">
                                <td>
                                    <strong><?php echo htmlspecialchars($res['name']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($res['email']); ?></small>
                                </td>
                                <td>
                                    <span class="badge badge-<?php echo $res['status']; ?>">
                                        <?php echo ucfirst($res['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <?php echo $res['reservation_date']; ?><br>
                                    <small><?php echo date('h:i A', strtotime($res['reservation_time'])); ?></small>
                                </td>
                                <td><strong><?php echo $res['guests']; ?></strong> Guests</td>
                                <td style="text-align:right;">
                                    <?php if($res['status'] == 'pending'): ?>
                                        <a href="?update_id=<?php echo $res['id']; ?>&new_status=ongoing" class="action-btn checkin">Check-in</a>
                                        <a href="?update_id=<?php echo $res['id']; ?>&new_status=cancelled" class="action-btn cancel" onclick="return confirm('Cancel this booking?')">Cancel</a>
                                    
                                    <?php elseif($res['status'] == 'ongoing'): ?>
                                        <a href="?update_id=<?php echo $res['id']; ?>&new_status=completed" class="action-btn complete">Complete Service</a>
                                    
                                    <?php else: ?>
                                        <span style="color:#94a3b8; font-size:0.8rem;">No actions</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>