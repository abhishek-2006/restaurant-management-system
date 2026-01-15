<?php
require 'config.php';
$activePage = 'users';

if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

if (isset($_GET['ban_id'])) {
    $target_id = intval($_GET['ban_id']);
    $stmt = $dbh->prepare("UPDATE users SET role = IF(role='banned', 'guest', 'banned') WHERE user_id = ? AND role != 'admin'");
    $stmt->execute([$target_id]);
    header("Location: manage-users.php");
    exit();
}

$message = "";

// Handle Delete User
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    
    // Prevent admin from deleting themselves
    if ($id == $_SESSION['user_id']) {
        $message = "Error: You cannot delete your own admin account.";
    } else {
        $stmt = $dbh->prepare("DELETE FROM users WHERE user_id = ?");
        $stmt->execute([$id]);
        $message = "User account removed successfully.";
    }
}

// Fetch all users
$stmt = $dbh->query("SELECT user_id, full_name, email, phone, role, created_at FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Users | GreenLeaf Admin</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/admin-styles.css">
    <link rel="stylesheet" href="assets/css/index-styles.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <h2>User Management</h2>
                <?php if($message): ?> 
                    <div style="padding:10px; background:#fef2f2; color:#991b1b; border-radius:8px;">
                        <?php echo $message; ?>
                    </div> 
                <?php endif; ?>
            </header>

            <section class="admin-card">
                <h3>Registered Accounts</h3>
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Email</th>
                                <th>Phone</th>
                                <th>Role</th>
                                <th>Joined</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr>
                                    <td><strong><?php echo htmlspecialchars($user['full_name']); ?></strong></td>
                                    <td><?php echo htmlspecialchars($user['email']); ?></td>
                                    <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                                    <td>
                                        <span class="badge <?php echo ($user['role'] == 'banned') ? 'badge-danger' : 'badge-success'; ?>">
                                            <?php echo ucfirst($user['role']); ?>
                                        </span>
                                    </td>
                                    <td><small><?php echo date('M j, Y', strtotime($user['created_at'])); ?></small></td>
                                    <td>
                                        <?php if($user['role'] !== 'admin'): ?>
                                            <a href="?ban_id=<?php echo $user['user_id']; ?>" 
                                                class="action-btn <?php echo ($user['role'] == 'banned') ? 'unban' : 'ban'; ?>">
                                            <?php echo ($user['role'] == 'banned') ? 'Unban' : 'Ban User'; ?>
                                            </a>
                                            <a href="?delete=<?php echo $user['user_id']; ?>" 
                                            class="delete-btn"
                                            onclick="return confirm('Permanently delete this user?')">Delete</a>
                                        <?php else: ?>
                                            <span style="color:#94a3b8;">(Current Admin)</span>
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