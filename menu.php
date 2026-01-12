<?php
include 'config.php';

// Fetch all menu items from the 'menu' table
try {
    $stmt = $dbh->query("SELECT name, description, price, category FROM menu ORDER BY category, price");
    $all_menu_items = $stmt->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    $all_menu_items = [];
}

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
<body>

    <header class="site-header">
        <div class="header-container">
            <div class="logo-area">
                <img src="assets/img/logo.png" alt="GreenLeaf Logo" class="main-logo">
                <h1 class="brand-name">GreenLeaf</h1>
            </div>
            <nav class="main-nav">
                <a href="index.php">Home</a>
                <a href="about.php">About</a>
                <a href="menu.php" class="active">Menu</a>
                <a href="reservation.php">Reserve Table</a>
                <a href="contact.php">Contact Us</a>
            </nav>
        </div>
    </header>

    <div class="menu-controls">
        <input type="text" id="menuSearch" placeholder="Search for a dish..." onkeyup="filterMenu()">
        <div class="category-filters">
            <button class="filter-btn active" onclick="filterCategory('all')">All</button>
            <?php foreach(array_keys($menu_categories) as $cat): ?>
                <button class="filter-btn" onclick="filterCategory('<?php echo htmlspecialchars($cat); ?>')">
                    <?php echo htmlspecialchars($cat); ?>
                </button>
            <?php endforeach; ?>
        </div>
    </div>
    <div class="menu-wrapper">
        <header class="page-intro">
            <h1 class="main-title">The GreenLeaf Menu</h1>
            <p class="subtitle">A Symphony of Spices and Freshness</p>
        </header>

        <main class="menu-content">
            <?php foreach($menu_categories as $category_name => $items): ?>
                <section class="menu-category-section">
                    <h2 class="category-heading"><?php echo htmlspecialchars($category_name); ?></h2>
                    
                    <div class="menu-grid">
                        <?php foreach($items as $item): ?>
                            <div class="menu-card">
                                <div class="card-header">
                                    <h3 class="item-name"><?php echo htmlspecialchars($item['name']); ?></h3>
                                    <span class="item-price">₹<?php echo number_format($item['price'], 2); ?></span>
                                </div>
                                <p class="item-description">
                                    <?php echo htmlspecialchars($item['description']); ?>
                                </p>
                            </div>
                        <?php endforeach; ?>
                    </div>
                </section>
            <?php endforeach; ?>
            
            <?php if (empty($all_menu_items)): ?>
                <div class="empty-state">
                    <p>No menu items found. Please check your database connection.</p>
                </div>
            <?php endif; ?>
        </main>
    </div>

    <footer class="site-footer">
        <p>&copy; 2026 GreenLeaf Veg Restaurant</p>
        <p class="footer-tagline">Pure Veg · Multi-Cuisine · Authentic Taste</p>
    </footer>

    <script>
        function filterMenu() {
            let input = document.getElementById('menuSearch').value.toLowerCase();
            let items = document.getElementsByClassName('menu-card');
            for (let item of items) {
                let name = item.querySelector('.item-name').innerText.toLowerCase();
                item.style.display = name.includes(input) ? "block" : "none";
            }
        }

        function filterCategory(category) {
            let sections = document.getElementsByClassName('menu-category-section');
            let buttons = document.getElementsByClassName('filter-btn');
            
            for (let btn of buttons) btn.classList.remove('active');
            event.target.classList.add('active');

            for (let section of sections) {
                let catTitle = section.querySelector('.category-heading').innerText;
                section.style.display = (category === 'all' || catTitle === category) ? "block" : "none";
            }
        }
    </script>
</body>
</html>