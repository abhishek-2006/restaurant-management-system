<?php 
$activePage = 'home';
require 'config.php';
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GreenLeaf Veg Restaurant | Authentic Multi-Cuisine</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css" type="text/css">
</head>
<body>

    <?php include 'header.php'; ?>

    <main class="home-wrapper">
        <section class="hero-section">
            <div class="hero-content">
                <h2 class="hero-title">A Symphony of Spices and Freshness</h2>
                <p class="hero-subtitle">Experience the best of Indian and Italian vegetarian cuisine — freshly prepared and made with love.</p>
                <div class="hero-actions">
                    <a href="menu.php" class="btn btn-primary">View Menu</a>
                    <a href="reservation.php" class="btn btn-secondary">Book a Table</a>
                </div>
            </div>
        </section>

        <section class="about-preview">
            <div class="container">
                <div class="about-grid">
                    <div class="about-image">
                        <img src="https://images.unsplash.com/photo-1512621776951-a57141f2eefd?auto=format&fit=crop&w=600&q=80" alt="Fresh Vegetarian Bowl" class="img-branded">
                    </div>
                    <div class="about-text">
                        <span class="badge">Since 2026</span>
                        <h3 class="section-title">Rooted in Tradition</h3> 
                        <p>We are dedicated to purity and flavor, using only the freshest vegetables and traditional hand-ground spices to bring nature's best to your table.</p> 
                        <a href="about.php" class="text-link">Our Story &rarr;</a>
                    </div>
                </div>
            </div>
        </section>

        <section class="specialties-section">
            <div class="container">
                <h3 class="section-title center">Chef's Recommendations</h3>
                <div class="specialties-grid">
                    <div class="spec-card">
                        <img src="https://images.unsplash.com/photo-1631452180519-c014fe946bc7?auto=format&fit=crop&w=400&q=80" alt="Paneer Butter Masala">
                        <div class="spec-info">
                            <h4>Paneer Butter Masala</h4>
                            <p>Creamy tomato gravy with soft paneer.</p>
                        </div>
                    </div>
                    <div class="spec-card">
                        <img src="https://images.unsplash.com/photo-1604068549290-dea0e4a305ca?auto=format&fit=crop&w=400&q=80" alt="Margherita Pizza">
                        <div class="spec-info">
                            <h4>Margherita Pizza</h4>
                            <p>Classic mozzarella and fresh basil.</p>
                        </div>
                    </div>
                    <div class="spec-card">
                        <img src="https://images.unsplash.com/photo-1543339308-43e59d6b73a6?auto=format&fit=crop&w=400&q=80" alt="Veg Biryani">
                        <div class="spec-info">
                            <h4>Hyderabadi Biryani</h4>
                            <p>Aromatic basmati rice and spices.</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <?php include 'footer.php'; ?>
</body>
</html>