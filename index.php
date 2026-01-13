<?php $activePage = 'home'; ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenLeaf Veg Restaurant | Home</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css" type="text/css">
</head>
<body>

    <?php include 'header.php'; ?>

    <main class="home-wrapper">
        <section class="hero-section">
            <h2 class="hero-title">A Symphony of Spices and Freshness</h2>
            <p class="hero-subtitle">Experience the best of Indian and Italian vegetarian cuisine — freshly prepared and made with love.</p>

            <div class="hero-actions">
                <a href="menu.php" class="btn btn-primary">View Menu</a>
                <a href="reservation.php" class="btn btn-secondary">Book a Table</a>
            </div>
        </section>

        <section class="specialties-section">
            <h3 class="section-title">Our Specialties</h3>
            <div class="specialties-grid">
                <div class="spec-item">🍛 Paneer Butter Masala</div>
                <div class="spec-item">🍕 Margherita Pizza</div>
                <div class="spec-item">🍝 Pasta Alfredo</div>
                <div class="spec-item">🥘 Veg Biryani</div>
            </div>
        </section>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>