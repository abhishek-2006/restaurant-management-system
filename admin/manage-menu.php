<?php
require 'config.php';

// Security: Admin access only
if (!isset($_SESSION['user_id']) || $_SESSION['role'] !== 'admin') {
    header("Location: index.php");
    exit();
}

$message = "";

// Handle Delete Item
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $dbh->prepare("DELETE FROM menu WHERE id = ?");
    $stmt->execute([$id]);
    $message = "Item deleted successfully.";
}

// Handle Add Item
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_item'])) {
    $name = htmlspecialchars(trim($_POST['name']));
    $category = htmlspecialchars(trim($_POST['category']));
    $price = floatval($_POST['price']);
    $description = htmlspecialchars(trim($_POST['description']));

    $stmt = $dbh->prepare("INSERT INTO menu (name, category, price, description) VALUES (?, ?, ?, ?)");
    $stmt->execute([$name, $category, $price, $description]);
    $message = "New dish added to the menu!";
}

// Fetch all menu items grouped by category
$stmt = $dbh->query("SELECT category, id, name, price, description FROM menu ORDER BY category, name");
$menu_items = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Manage Menu | GreenLeaf Admin</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/admin-styles.css">
    <link rel="stylesheet" href="assets/css/index-styles.css">
    <style>
        .menu-grid { display: grid; grid-template-columns: 1fr 2fr; gap: 30px; }
        .form-card { position: sticky; top: 30px; }
        .badge { padding: 4px 8px; border-radius: 4px; font-size: 0.8rem; background: #e2e8f0; }
        .delete-btn { color: #ef4444; text-decoration: none; font-weight: bold; }
    </style>
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
                <a href="manage-reservations.php">📅 Reservations</a>
                <a href="manage-menu.php" class="active">🍛 Menu Items</a>
                <a href="logout.php">🚪 Logout</a>
            </nav>
        </aside>

        <main class="admin-main">
            <header class="admin-header">
                <h2>Menu Management</h2>
                <?php if($message): ?> <div class="badge" style="background:#dcfce7; color:#166534;"><?php echo $message; ?></div> <?php endif; ?>
            </header>

            <div class="menu-grid">
                <section class="admin-card form-card">
                    <h3>Add New Dish</h3>
                    <form method="POST" style="margin-top:15px;">
                        <div class="form-group">
                            <label>Dish Name</label>
                            <input type="text" name="name" required>
                        </div>
                        <div class="form-group">
                            <label>Category</label>
                            <select name="category" required style="width:100%; padding:10px; border-radius:8px; border:1px solid #ddd;">
                                <option value="North Indian">North Indian</option>
                                <option value="Italian">Italian</option>
                                <option value="Beverages">Beverages</option>
                                <option value="Desserts">Desserts</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Price (₹)</label>
                            <input type="number" name="price" step="0.01" required>
                        </div>
                        <div class="form-group">
                            <label>Description</label>
                            <textarea name="description" rows="3" style="width:100%; border-radius:8px; border:1px solid #ddd; padding:10px;"></textarea>
                        </div>
                        <button type="submit" name="add_item" class="admin-login-btn">Add to Menu</button>
                    </form>
                </section>

                <section class="admin-card">
                    <h3>Current Menu</h3>
                    <?php foreach ($menu_items as $category => $items): ?>
                        <h4 style="margin-top:20px; color:var(--primary-green); border-bottom:1px solid #eee;"><?php echo $category; ?></h4>
                        <table class="admin-table">
                            <thead>
                                <tr>
                                    <th>Dish</th>
                                    <th>Price</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($items as $item): ?>
                                <tr>
                                    <td>
                                        <strong><?php echo $item['name']; ?></strong><br>
                                        <small style="color:666;"><?php echo $item['description']; ?></small>
                                    </td>
                                    <td>₹<?php echo number_format($item['price'], 2); ?></td>
                                    <td>
                                        <a href="?delete=<?php echo $item['id']; ?>" class="delete-btn" onclick="return confirm('Remove this dish?')">Delete</a>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    <?php endforeach; ?>
                </section>
            </div>
        </main>
    </div>
</body>
</html>