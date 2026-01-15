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
        <?php include 'sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h2>Guest Reservations</h2>
            </header>

            <section class="admin-card" style="margin-bottom: 20px;">
                <form method="GET" class="filter-form" style="display: flex; gap: 15px; flex-wrap: wrap; align-items: flex-end;">
                    <div class="form-group" style="flex: 1; min-width: 200px; margin-bottom: 0;">
                        <label>Search Guest</label>
                        <input type="text" name="search" value="<?php echo $search; ?>" placeholder="Name, Email, or Phone...">
                    </div>
                    <div class="form-group" style="margin-bottom: 0;">
                        <label>Filter by Date</label>
                        <input type="date" name="filter_date" value="<?php echo $filter_date; ?>">
                    </div>
                    <div style="display: flex; gap: 10px;">
                        <button type="submit" class="admin-login-btn" style="margin: 0; padding: 10px 20px;">Apply</button>
                        <a href="manage-reservations.php" class="nav-btn logout-btn" style="padding: 10px 20px; line-height: 1.2; text-decoration: none;">Clear</a>
                    </div>
                </form>
            </section>

            <section class="admin-card">
                <h3>Bookings List (<?php echo count($reservations); ?>)</h3>
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
                                        <td><?php echo htmlspecialchars($res['phone']); ?></td>
                                        <td><?php echo $res['reservation_date']; ?> | <?php echo $res['reservation_time']; ?></td>
                                        <td><?php echo $res['guests']; ?> Guests</td>
                                        <td><a href="?delete=<?php echo $res['id']; ?>" class="delete-btn" onclick="return confirm('Delete?')">Cancel</a></td>
                                    </tr>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <tr>
                                    <td colspan="5" style="text-align:center; padding: 40px;">
                                        <?php if ($total_count == 0): ?>
                                            <div style="color: #64748b;">
                                                <span style="font-size: 2rem;">📭</span><br>
                                                <strong>No reservations found in the system.</strong>
                                            </div>
                                        <?php else: ?>
                                            <div style="color: #ef4444;">
                                                <span style="font-size: 2rem;">🔍</span><br>
                                                <strong>No matches found for your search criteria.</strong><br>
                                                <small style="color: #64748b;">Try adjusting your filters or search terms.</small>
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