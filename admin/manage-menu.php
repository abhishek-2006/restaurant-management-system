<?php
require 'config.php';
$activePage = 'menu';

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
    try {
        $stmt->execute([$name, $category, $price, $description]);
        $message = "New dish added successfully!";
    } catch (PDOException $e) {
        if ($e->getCode() == 23000) {
            $message = "Error: A dish with this name already exists.";
        } else {
            $message = "Database error occurred.";
        }
    }
}

$stmt = $dbh->query("SELECT category, id, name, price, description FROM menu ORDER BY category, name");
$menu_items = $stmt->fetchAll(PDO::FETCH_GROUP|PDO::FETCH_ASSOC);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Menu | GreenLeaf Admin</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico"> <link rel="stylesheet" href="assets/css/admin-styles.css">
    <link rel="stylesheet" href="assets/css/index-styles.css">
</head>
<body class="admin-body">
    <div class="admin-container">
        <?php include 'sidebar.php'; ?>

        <main class="admin-main">
            <header class="admin-header">
                <div class="header-title">
                    <h2>Menu Management</h2>
                    <p class="subtitle">Curate your restaurant's culinary offerings</p>
                </div>
                <?php if($message): ?> 
                    <div class="trend-badge positive" style="padding: 10px 20px; font-size: 0.9rem;">
                        ✨ <?php echo $message; ?>
                    </div> 
                <?php endif; ?>
            </header>

            <div class="menu-grid">
                <section class="admin-card glass-morph form-card">
                    <div class="card-header">
                        <h3 style="margin:0;">Add New Dish</h3>
                    </div>
                    <form method="POST" style="margin-top:20px;">
                        <div class="form-group">
                            <label for="dish-name">Dish Name</label>
                            <input type="text" id="dish-name" name="name" placeholder="e.g. Paneer Lababdar" required>
                        </div>
                        <div class="form-group">
                            <label for="menu-category">Menu Category</label>
                            <select name="category" id="menu-category" required>
                                <option value="" disabled selected>Select Category</option>
                                <?php foreach (array_keys($menu_items) as $category): ?>
                                    <option value="<?php echo htmlspecialchars($category); ?>"><?php echo htmlspecialchars($category); ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="dish-price">Pricing (₹)</label>
                            <input type="number" name="price" id="dish-price" step="0.01" placeholder="0.00" required>
                        </div>
                        <div class="form-group">
                            <label for="dish-description">Dish Description</label>
                            <textarea name="description" id="dish-description" rows="4" placeholder="Describe the flavors and ingredients..." style="width:100%; border-radius:12px; border:2px solid #e2e8f0; padding:12px; background:rgba(255,255,255,0.8);"></textarea>
                        </div>
                        <button type="submit" name="add_item" class="admin-login-btn" style="width:100%; margin-top:10px;">Deploy to Menu</button>
                    </form>
                </section>

                <section class="admin-card glass-morph">
                    <div class="card-header">
                        <h3 style="margin:0;">Current Menu Intelligence</h3>
                    </div>
                    
                    <?php foreach ($menu_items as $category => $items): ?>
                        <div class="category-block" style="margin-top:30px;">
                            <h4 class="category-label" style="display:inline-block; background:var(--primary-green); color:white; padding:5px 15px; border-radius:50px; font-size:0.8rem; text-transform:uppercase; letter-spacing:0.05em; margin-bottom:15px;">
                                <?php echo htmlspecialchars($category); ?>
                            </h4>
                            
                            <div class="table-responsive">
                                <table class="admin-table">
                                    <thead>
                                        <tr>
                                            <th>Dish Specification</th>
                                            <th style="width:100px;">Price</th>
                                            <th style="text-align: right;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach ($items as $item): ?>
                                        <tr class="table-row-hover">
                                            <td>
                                                <div style="font-weight: 700; color: var(--sidebar-bg);"><?php echo htmlspecialchars($item['name']); ?></div>
                                                <div style="font-size: 0.8rem; color: var(--text-muted); line-height:1.4;"><?php echo htmlspecialchars($item['description']); ?></div>
                                            </td>
                                            <td>
                                                <span style="font-weight: 700; color: var(--primary-green);">₹<?php echo number_format($item['price'], 2); ?></span>
                                            </td>
                                            <td style="text-align: right;">
                                                <a href="?delete=<?php echo $item['id']; ?>" class="delete-btn" onclick="return confirm('Archive this dish? This will remove it from the public menu.')" >
                                                   Remove
                                                </a>
                                            </td>
                                        </tr>
                                        <?php endforeach; ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </section>
            </div>
        </main>
    </div>
</body>
</html>