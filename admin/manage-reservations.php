<?php
require 'config.php';

// Security: Admin access only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

// Check total records in table (ignoring search)
$total_count = $dbh->query("SELECT COUNT(*) FROM reservations")->fetchColumn();

$activePage = 'reservations';
$search = isset($_GET['search']) ? htmlspecialchars(trim($_GET['search'])) : '';
$filter_date = isset($_GET['filter_date']) ? $_GET['filter_date'] : '';

if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $dbh->prepare("DELETE FROM reservations WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage-reservations.php");
    exit();
}

$query = "SELECT * FROM reservations WHERE 1=1";
$params = [];

if (!empty($search)) {
    $query .= " AND (name LIKE ? OR email LIKE ? OR phone LIKE ?)";
    $params[] = "%$search%";
    $params[] = "%$search%";
    $params[] = "%$search%";
}

if (!empty($filter_date)) {
    $query .= " AND reservation_date = ?";
    $params[] = $filter_date;
}

$query .= " ORDER BY reservation_date DESC, reservation_time DESC";
$stmt = $dbh->prepare($query);
$stmt->execute($params);
$reservations = $stmt->fetchAll(PDO::FETCH_ASSOC);

$today = date('Y-m-d');

$dbh->prepare("UPDATE reservations SET status = 'cancelled' 
               WHERE reservation_date < ? AND status = 'pending'")->execute([$today]);

if (isset($_GET['update_id']) && isset($_GET['new_status'])) {
    $id = intval($_GET['update_id']);
    $status = $_GET['new_status'];
    
    $stmt = $dbh->prepare("UPDATE reservations SET status = ? WHERE id = ?");
    $stmt->execute([$status, $id]);
    header("Location: manage-reservations.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Reservations | GreenLeaf Admin</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"> <link rel="stylesheet" href="assets/css/admin-styles.css">
    <link rel="stylesheet" href="assets/css/index-styles.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <div class="header-title">
                    <h2>Guest Reservations</h2>
                    <p class="subtitle">Real-time table booking intelligence</p>
                </div>
            </header>

            <section class="admin-card glass-morph" style="margin-bottom: 2rem;">
                <form method="GET" class="filter-form" style="display: flex; gap: 20px; flex-wrap: wrap; align-items: flex-end;">
                    <div class="form-group" style="flex: 2; min-width: 250px; margin-bottom: 0;">
                        <label style="font-size: 0.75rem; letter-spacing: 0.05em;">Search Intelligence</label>
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Name, Email, or Phone..." style="background: rgba(255,255,255,0.8);">
                    </div>
                    <div class="form-group" style="flex: 1; min-width: 150px; margin-bottom: 0;">
                        <label style="font-size: 0.75rem; letter-spacing: 0.05em;">Timeline Filter</label>
                        <input type="date" name="filter_date" value="<?php echo $filter_date; ?>" style="background: rgba(255,255,255,0.8);">
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="admin-login-btn" style="margin: 0; padding: 12px 25px;">Apply Filter</button>
                        <a href="manage-reservations.php" class="nav-btn logout-btn" style="padding: 12px 25px; line-height: 1.2; text-decoration: none; display: flex; align-items: center;">Reset</a>
                    </div>
                </form>
            </section>

            <section class="admin-card glass-morph">
                <div class="card-header" style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h3 style="margin:0;">Bookings Log <span style="font-size: 0.9rem; color: var(--text-muted); font-weight: 400;">(<?php echo count($reservations); ?> entries)</span></h3>
                </div>
                
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Guest Identity</th>
                                <th>Contact Access</th>
                                <th>Schedule</th>
                                <th>Party Size</th>
                                <th>Status</th>
                                <th>Operations</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if($reservations): ?>
                                <?php foreach ($reservations as $res): ?>
                                    <tr class="table-row-hover">
                                        <td>
                                            <div style="font-weight: 700; color: var(--sidebar-dark);"><?php echo htmlspecialchars($res['name']); ?></div>
                                            <div style="font-size: 0.75rem; color: var(--text-muted);"><?php echo htmlspecialchars($res['email']); ?></div>
                                        </td>
                                        <td><span style="font-family: monospace;"><?php echo htmlspecialchars($res['phone']); ?></span></td>
                                        <td>
                                            <div style="font-weight: 600;"><?php echo date('M d, Y', strtotime($res['reservation_date'])); ?> | <?php echo $res['reservation_time']; ?></div>
                                            <div style="font-size: 0.8rem; color: var(--primary-green); font-weight: 700;"></div>
                                        </td>
                                        <td>
                                            <span class="badge" style="background: #e0f2fe; color: #0369a1; padding: 5px 12px; border-radius: 6px; font-weight: 700;">
                                                <?php echo $res['guests']; ?> Guests
                                            </span>
                                        </td>
                                        <td>
                                            <span class="badge <?php echo 'badge-' . $res['status']; ?>">
                                                <?php echo ucfirst($res['status']); ?>
                                            </span>
                                        </td>
                                        <td>
                                            <?php if($res['status'] == 'pending'): ?>
                                                <a href="?update_id=<?php echo $res['id']; ?>&new_status=ongoing" class="action-btn checkin">Check-in</a>
                                                <a href="?update_id=<?php echo $res['id']; ?>&new_status=cancelled" class="action-btn cancel">Cancel</a>
                                            <?php elseif($res['status'] == 'ongoing'): ?>
                                                <a href="?update_id=<?php echo $res['id']; ?>&new_status=completed" class="action-btn complete">Complete & Free Table</a>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="6" style="text-align:center; padding: 60px;">
                                        <?php if ($total_count == 0): ?>
                                            <div style="opacity: 0.6;">
                                                <div style="font-size: 3rem; margin-bottom: 10px;">📭</div>
                                                <h4 style="margin:0;">No Reservations Logged</h4>
                                                <p style="font-size: 0.85rem;">The system has no historical booking data.</p>
                                            </div>
                                        <?php else: ?>
                                            <div style="color: #ef4444;">
                                                <div style="font-size: 3rem; margin-bottom: 10px;">🔍</div>
                                                <h4 style="margin:0;">No Intelligence Matches</h4>
                                                <p style="font-size: 0.85rem; color: var(--text-muted);">Adjust your search parameters and try again.</p>
                                            </div>
                                        <?php endif; ?>
                                    </td>
                                </tr>
                            <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </section>
        </main>
    </div>
</body>
</html>