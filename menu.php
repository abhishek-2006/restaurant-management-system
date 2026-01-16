<?php
require 'config.php';
$activePage = 'menu';

// Fetch menu items - simplified query to ensure visibility
try {
    $stmt = $dbh->query("SELECT name, description, price, category FROM menu ORDER BY category, price");
    $all_menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $all_menu_items = [];
}

// Group items by category for the display loop
$menu_categories = [];
foreach ($all_menu_items as $item) {
    $menu_categories[$item['category']][] = $item;
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Menu | The GreenLeaf Veg. Restaurant</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/menu-styles.css" type="text/css">
</head>
<body class="menu-page">

    <?php include 'header.php'; ?>

    <header class="menu-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content">
            <h1 class="main-title">Our Menu</h1>
            <p class="subtitle">Fresh flavors, traditional recipes</p>
        </div>
    </header>

    <div class="menu-wrapper">
        <main class="menu-content">
            <?php if (!empty($menu_categories)): ?>
                <?php foreach($menu_categories as $category_name => $items): ?>
                    <section class="menu-category-section">
                        <h2 class="category-heading"><?php echo htmlspecialchars($category_name); ?></h2>
                        
                        <div class="menu-grid">
                            <?php foreach($items as $item): ?>
                                <div class="menu-card">
                                    <div class="card-header">
                                        <h3 class="item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                                        <span class="item-price">₹<?php echo number_format($item['price'], 0); ?></span>
                                    </div>
                                    <p class="item-description">
                                        <?php echo htmlspecialchars($item['description']); ?>
                                    </p>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    </section>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="empty-state">
                    <p>No menu items found. Please ensure your "menu" table contains data.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>

        <section class="menu-cta-banner">
            <div class="cta-content">
                <h2>Ready for a Feast?</h2>
                <p>Skip the wait by booking your table online in just a few clicks.</p>
                <div class="cta-btns">
                    <a href="reservation.php" class="btn btn-primary">Book Your Table</a>
                    <a href="contact.php" class="btn btn-outline">Ask a Question</a>
                </div>
            </div>
        </section>

    <?php include 'footer.php'; ?>

</body>
</html>