<?php
require 'config.php';
$activePage = 'inbox';

// Admin Security Check
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$activePage = 'inbox';
$message = "";

// Handle Message Actions (Mark as Read / Delete)
if (isset($_GET['action']) && isset($_GET['id'])) {
    $id = intval($_GET['id']);
    if ($_GET['action'] === 'read') {
        $stmt = $dbh->prepare("UPDATE contact_messages SET status = 'read' WHERE id = ?");
        $stmt->execute([$id]);
    } elseif ($_GET['action'] === 'delete') {
        $stmt = $dbh->prepare("DELETE FROM contact_messages WHERE id = ?");
        $stmt->execute([$id]);
        $message = "Message archived successfully.";
    }
}

// Fetch all messages
$stmt = $dbh->query("SELECT * FROM contact_messages ORDER BY created_at DESC");
$messages = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Guest Inbox | GreenLeaf Admin</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/admin-styles.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <div class="header-title">
                    <h2>Guest Communications</h2>
                    <p class="subtitle">Manage inquiries and feedback from your customers</p>
                </div>
                <?php if($message): ?>
                    <div class="trend-badge positive">✨ <?php echo $message; ?></div>
                <?php endif; ?>
            </header>

            <div class="admin-card glass-morph">
                <div class="table-responsive">
                    <table class="admin-table">
                        <thead>
                            <tr>
                                <th>Status</th>
                                <th>Guest Info</th>
                                <th>Subject & Message</th>
                                <th>Received</th>
                                <th style="text-align: right;">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (empty($messages)): ?>
                                <tr><td colspan="5" style="text-align:center; padding: 40px;">No messages in the inbox.</td></tr>
                            <?php endif; ?>
                            
                            <?php foreach ($messages as $msg): ?>
                            <tr class="table-row-hover <?php echo $msg['status'] === 'unread' ? 'unread-row' : ''; ?>">
                                <td>
                                    <span class="badge <?php echo $msg['status'] === 'unread' ? 'badge-danger' : 'badge-success'; ?>">
                                        <?php echo ucfirst($msg['status']); ?>
                                    </span>
                                </td>
                                <td>
                                    <strong><?php echo htmlspecialchars($msg['name']); ?></strong><br>
                                    <small><?php echo htmlspecialchars($msg['email']); ?></small>
                                </td>
                                <td style="max-width: 400px;">
                                    <div style="font-weight: 700; color: var(--sidebar-bg);"><?php echo htmlspecialchars($msg['subject']); ?></div>
                                    <div style="font-size: 0.85rem; color: var(--text-muted);"><?php echo nl2br(htmlspecialchars($msg['message'])); ?></div>
                                </td>
                                <td><?php echo date('M d, Y', strtotime($msg['created_at'])); ?></td>
                                <td style="text-align: right;">
                                    <?php if($msg['status'] === 'unread'): ?>
                                        <a href="?action=read&id=<?php echo $msg['id']; ?>" class="action-btn checkin" style="margin-right: 5px;">Mark Read</a>
                                    <?php endif; ?>
                                    <a href="?action=delete&id=<?php echo $msg['id']; ?>" class="action-btn cancel" onclick="return confirm('Delete this message?')">Delete</a>
                                </td>
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