<?php 
require 'config.php';
$activePage = 'dashboard';

// Protect the page: only logged-in users
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$activePage = 'dashboard';
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// Fetch user-specific reservations
$stmt = $dbh->prepare("SELECT * FROM reservations WHERE user_id = ? ORDER BY reservation_date DESC");
$stmt->execute([$user_id]);
$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | GreenLeaf Veg Restaurant</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/dashboard-styles.css" type="text/css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="dashboard-wrapper">
        <header class="page-intro">
            <h1 class="main-title">Welcome, <?php echo htmlspecialchars($user_name); ?>! 🌿</h1>
            <p class="subtitle">Manage your table reservations and account settings.</p>
        </header>

        <?php if (isset($_GET['msg'])): ?>
            <div class="message-box <?php echo ($_GET['msg'] == 'cancelled') ? 'success' : 'error'; ?>">
                <?php 
                    echo ($_GET['msg'] == 'cancelled') ? "Reservation successfully cancelled." : "Something went wrong. Please try again."; 
                ?>
            </div>
        <?php endif; ?>

        <div class="dashboard-grid">
            <section class="dashboard-card">
                <h3>Your Bookings</h3>
                <div class="table-container" style="overflow-x: auto;">
                    <table style="width:100%; border-collapse: collapse; margin-top: 1rem;">
                        <tr style="background: #f0f7f0; text-align: left;">
                            <th style="padding: 12px;">Date</th>
                            <th style="padding: 12px;">Time</th>
                            <th style="padding: 12px;">Guests</th>
                            <th style="padding: 12px;">Action</th>
                        </tr>
                        <?php if($bookings): ?>
                            <?php foreach($bookings as $row): ?>
                            <tr style="border-bottom: 1px solid #eee;">
                                <td style="padding: 12px;"><?php echo $row['reservation_date']; ?></td>
                                <td style="padding: 12px;"><?php echo $row['reservation_time']; ?></td>
                                <td style="padding: 12px;"><?php echo $row['guests']; ?></td>
                                <td style="padding: 12px;"><a href="cancel-booking.php?id=<?php echo $row['id']; ?>" 
                                    onclick="return confirm('Are you sure you want to cancel this reservation?');" 
                                    style="color: #e63946; font-weight: bold; text-decoration: none;">
                                    Cancel
                                    </a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="padding: 20px; text-align: center;">No bookings yet. <a href="reservation.php" class="text-link" style="text-decoration-line: underline;">Book a table now!</a></td></tr>
                        <?php endif; ?>
                    </table>
                </div>
            </section>

            <aside class="dashboard-card">
                <h3>Quick Actions</h3>
                <ul style="list-style: none; padding: 0; margin-top: 1rem;">
                    <li style="margin-bottom: 10px;"><a href="menu.php" style="text-decoration: none; color: var(--color-primary-green);">📖 View Today's Menu</a></li>
                    <li style="margin-bottom: 10px;"><a href="reservation.php" style="text-decoration: none; color: var(--color-primary-green);">📅 Reserve a Table</a></li>
                    <li style="margin-bottom: 10px;"><a href="contact.php" style="text-decoration: none; color: var(--color-primary-green);">💬 Help & Support</a></li>
                </ul>
                <hr style="margin: 1.5rem 0; border: 0; border-top: 1px solid #eee;">
                <a href="logout.php" class="nav-btn logout-btn" style="display: block; text-align: center;">Logout</a>
            </aside>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>