<?php 
require 'config.php';
$activePage = 'dashboard';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];

// 1. Fetch Active Bookings
$stmtActive = $dbh->prepare("SELECT * FROM reservations WHERE user_id = ? AND status IN ('pending', 'ongoing') ORDER BY reservation_date ASC");
$stmtActive->execute([$user_id]);
$activeBookings = $stmtActive->fetchAll();

// 2. Fetch History (Last 3 for the 'Recent Activity' feed)
$stmtHistory = $dbh->prepare("SELECT * FROM reservations WHERE user_id = ? AND status IN ('completed', 'cancelled') ORDER BY reservation_date DESC LIMIT 3");
$stmtHistory->execute([$user_id]);
$historyBookings = $stmtHistory->fetchAll();

// Fetch Active Offers
$stmtOffers = $dbh->query("SELECT * FROM offers WHERE is_active = 1 AND (expiry_date >= CURDATE() OR expiry_date IS NULL) LIMIT 3");
$offers = $stmtOffers->fetchAll();

// 3. Stats Calculation
$totalBookings = $dbh->prepare("SELECT COUNT(*) FROM reservations WHERE user_id = ? AND status = 'completed'");
$totalBookings->execute([$user_id]);
$visitCount = $totalBookings->fetchColumn();
$points = $visitCount * 10;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard | The GreenLeaf</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"> 
    <link rel="stylesheet" href="assets/css/index-styles.css">
    <link rel="stylesheet" href="assets/css/dashboard-styles.css">
</head>
<body>
    <?php include 'header.php'; ?>

    <div class="dashboard-wrapper">
        <header class="dashboard-banner animate-up">
            <div class="profile-header">
                <div class="avatar-circle"><?php echo strtoupper(substr($user_name, 0, 1)); ?></div>
                <div class="welcome-text">
                    <h1>Namaste, <?php echo htmlspecialchars($user_name); ?>! 🌿</h1>
                    <p>Member since <?php echo date('Y'); ?></p>
                </div>
            </div>
            <div class="banner-actions">
                <a href="reservation.php" class="btn-primary-small">Book New Table</a>
            </div>
        </header>

        <?php if ($offers): ?>
            <section class="offers-carousel animate-up" style="animation-delay: 0.05s;">
                <div class="carousel-track">
                    <?php foreach ($offers as $offer): ?>
                    <div class="offer-slide">
                        <div class="offer-content">
                            <span class="promo-badge">Limited Offer</span>
                            <h2><?php echo htmlspecialchars($offer['title']); ?></h2>
                            <p><?php echo htmlspecialchars($offer['description']); ?></p>
                            <?php if ($offer['discount_code']): ?>
                                <div class="coupon">Code: <strong><?php echo htmlspecialchars($offer['discount_code']); ?></strong></div>
                            <?php endif; ?>
                        </div>
                        <?php if ($offer['image_url']): ?>
                            <div class="offer-image">
                                <img src="<?php echo $offer['image_url']; ?>" alt="Promo">
                            </div>
                        <?php endif; ?>
                    </div>
                    <?php endforeach; ?>
                </div>
            </section>
            <?php endif; ?>

        <div class="bento-grid">
            <div class="bento-card loyalty-card animate-up" style="animation-delay: 0.1s;">
                <h3>Loyalty Status</h3>
                <div class="points-display">
                    <span class="points-number"><?php echo $points; ?></span>
                    <span class="points-label">GLeaf Points</span>
                </div>
                <div class="progress-container">
                    <div class="progress-bar" style="width: <?php echo ($points % 100); ?>%;"></div>
                </div>
                <p class="small-text"><?php echo (100 - ($points % 100)); ?> points until your next reward!</p>
            </div>

            <div class="bento-card activity-card animate-up" style="animation-delay: 0.2s;">
                <h3>Recent Activity</h3>
                <div class="activity-mini-list">
                    <?php foreach($historyBookings as $hb): ?>
                        <div class="mini-item">
                            <span class="dot <?php echo $hb['status']; ?>"></span>
                            <p><?php echo ucfirst($hb['status']); ?> visit on <?php echo date('M j', strtotime($hb['reservation_date'])); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <div class="bento-card promo-card animate-up" style="animation-delay: 0.3s;">
                <h3>Spread the Green 🌿</h3>
                <p>Share GreenLeaf with friends and get a free dessert on your next visit!</p>
                <div class="referral-code">
                    <code>GLEAF-<?php echo strtoupper(substr($user_name, 0, 3)) . $user_id; ?></code>
                </div>
            </div>

            <div class="bento-card table-card animate-up" style="animation-delay: 0.4s;">
                <div class="card-header">
                    <h3>Your Upcoming Reservations</h3>
                </div>
                <div class="table-wrapper">
                    <table class="modern-table">
                        <thead>
                            <tr>
                                <th>Schedule</th>
                                <th>Party Size</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($activeBookings): ?>
                                <?php foreach($activeBookings as $res): ?>
                                <tr>
                                    <td>
                                        <span class="d-block font-bold"><?php echo date('D, d M', strtotime($res['reservation_date'])); ?></span>
                                        <span class="text-muted"><?php echo date('h:i A', strtotime($res['reservation_time'])); ?></span>
                                    </td>
                                    <td><?php echo $res['guests']; ?> Guests</td>
                                    <td><span class="status-pill <?php echo $res['status']; ?>"><?php echo ucfirst($res['status']); ?></span></td>
                                    <td>
                                        <?php if($res['status'] == 'pending'): ?>
                                            <a href="cancel-booking.php?id=<?php echo $res['id']; ?>" class="btn-text-danger" onclick="return confirm('Cancel this visit?')">Cancel</a>
                                        <?php else: ?>
                                            <span class="locked-text">Arrived</span>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr><td colspan="4" class="empty-state">No pending visits. Time for a feast?</td></tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <?php include 'footer.php'; ?>
</body>
</html>