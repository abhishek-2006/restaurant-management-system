<?php 
$activePage = 'about';
require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Our Story | The GreenLeaf Veg. Restaurant</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/about-styles.css" type="text/css">
</head>
<body class="about-page">

    <?php include 'header.php'; ?>

    <section class="about-hero">
        <div class="hero-overlay"></div>
        <div class="hero-content animate-up">
            <span class="est-badge">Established 2026</span>
            <h1 class="hero-title">A Legacy of Purity</h1>
            <p class="hero-subtitle">Rooted in Tradition, Growing with Love</p>
        </div>
    </section>

    <div class="about-wrapper">
        <main class="about-content">
            <section class="info-card glass-morph animate-up">
                <div class="card-icon">🌿</div>
                <h2 class="block-heading">Authentic Multi-Cuisine</h2>
                <p class="story-text">Welcome to <strong>The GreenLeaf</strong>, where we redefine the vegetarian experience. We are an authentic Indian Multi-Cuisine destination, bringing you a curated journey from the rich, buttery curries of the North to the crispy, fermented delights of the South.</p>
                
                <div class="highlight-quote">
                    <p>"Prepared with love, served with integrity. Every plate tells a story of the soil."</p>
                </div>
            </section>

            <section class="info-card glass-morph animate-up" style="animation-delay: 0.2s;">
                <div class="card-icon">💎</div>
                <h2 class="block-heading">Purity and Promise</h2>
                <p class="story-text">Our philosophy is built on the twin pillars of <strong>Purity and Flavor</strong>. We believe that great food starts long before the stove is lit. We use only the freshest farm-to-table vegetables, organic pure ghee, and traditional hand-ground spices to ensure every bite is a celebration of health.</p>
                <p class="story-text">Sustainability isn't just a buzzword for us—it's our core. By honoring the spirit of vegetarian cooking, we bring the best of nature directly to your table without compromise.</p>
            </section>

            <section class="values-section animate-up" style="animation-delay: 0.3s;">
                <div class="section-intro text-center">
                    <h2 class="block-heading">The GreenLeaf Way</h2>
                    <p class="subtitle-small">Our commitment to you and the planet</p>
                </div>
                
                <div class="values-grid">
                    <div class="value-card glass-morph">
                        <div class="value-icon">🥗</div>
                        <h3>100% Purity</h3>
                        <p>Strictly vegetarian and sourced from certified organic farms. We never compromise on the quality of our ingredients.</p>
                    </div>

                    <div class="value-card glass-morph">
                        <div class="value-icon">🤝</div>
                        <h3>Integrity</h3>
                        <p>Transparency in our kitchen and honesty in our service. We treat every guest like a member of our family.</p>
                    </div>

                    <div class="value-card glass-morph">
                        <div class="value-icon">🌍</div>
                        <h3>Sustainability</h3>
                        <p>From zero-plastic initiatives to minimizing food waste, we strive to leave the smallest footprint possible.</p>
                    </div>

                    <div class="value-card glass-morph">
                        <div class="value-icon">🍲</div>
                        <h3>Innovation</h3>
                        <p>Respecting old recipes while experimenting with modern plant-based techniques to surprise your palate.</p>
                    </div>
                </div>
            </section>

            <section class="gallery-section animate-up" style="animation-delay: 0.4s;">
                <h2 class="block-heading text-center">Step Into Our World</h2>
                <p class="text-center subtitle-small">Explore the ambiance designed for your comfort</p>
                <div class="gallery-grid">
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1517248135467-4c7edcad34c4?auto=format&fit=crop&w=800&q=80" alt="Dining Area" onclick="openLightbox(this.src)">
                        <div class="img-overlay"><span>View Dining Area</span></div>
                    </div>
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1552566626-52f8b828add9?auto=format&fit=crop&w=800&q=80" alt="Kitchen" onclick="openLightbox(this.src)">
                        <div class="img-overlay"><span>Our Open Kitchen</span></div>
                    </div>
                    <div class="gallery-item">
                        <img src="https://images.unsplash.com/photo-1559339352-11d035aa65de?auto=format&fit=crop&w=800&q=80" alt="Decor" onclick="openLightbox(this.src)">
                        <div class="img-overlay"><span>Artisanal Decor</span></div>
                    </div>
                </div>
            </section>

            <section class="chefs-section animate-up" style="animation-delay: 0.5s;">
                <div class="section-intro text-center">
                    <span class="chef-badge">👨‍🍳 The Team</span>
                    <h2 class="block-heading">Meet Our Culinary Masters</h2>
                    <p class="subtitle-small">Crafting Experiences, One Plate at a Time</p>
                </div>

                <div class="chef-grid">
                    <div class="chef-card glass-morph">
                        <div class="chef-img-container">
                            <img src="https://images.unsplash.com/photo-1577219491135-ce391730fb2c?auto=format&fit=crop&w=500&h=500&q=80" alt="Chef Karthik Menon">
                        </div>
                        <div class="chef-info">
                            <h3>Chef Karthik Menon</h3>
                            <p class="chef-title">Executive Chef & Founder</p>
                            <p class="chef-bio">A master of spices from Kerala, Chef Karthik ensures that every traditional dish carries the authentic soul of its origin.</p>
                        </div>
                    </div>

                    <div class="chef-card glass-morph">
                        <div class="chef-img-container">
                            <img src="https://blog.pincel.app/wp-content/uploads/2024/02/chef_portrait_in_a_kitchen_happy_with_a_chefs_hat_professional_photo_on_blurred_kitchen_background.-1.jpeg" alt="Chef Anjali Sharma">
                        </div>
                        <div class="chef-info">
                            <h3>Chef Anjali Sharma</h3>
                            <p class="chef-title">Head of Innovation</p>
                            <p class="chef-bio">Chef Anjali specializes in blending classic North Indian flavors with modern, plant-based culinary techniques.</p>
                        </div>
                    </div>

                    <div class="chef-card glass-morph">
                        <div class="chef-img-container">
                            <img src="https://static.pincel.app/cdn-cgi/image/width=450,format=auto/https://static.pincel.app/media/2cd1y6glxcs5hy6ptwdkn3-pffz2.png" alt="Ravi Patel">
                        </div>
                        <div class="chef-info">
                            <h3>Ravi Patel</h3>
                            <p class="chef-title">Pastry & Dessert Specialist</p>
                            <p class="chef-bio">Ravi creates artisanal vegan desserts that provide the perfect, guilt-free conclusion to your dining experience.</p>
                        </div>
                    </div>
                </div>
            </section>

            <section class="cta-banner glass-morph animate-up">
                <h2 class="cta-title">Taste the GreenLeaf Difference</h2>
                <p style="margin-bottom: 2rem; opacity: 0.9;">Join us for an unforgettable vegetarian feast today.</p>
                <div class="cta-buttons">
                    <a href="menu.php" class="btn btn-primary">View Full Menu</a> 
                    <a href="reservation.php" class="btn btn-outline">Secure a Table</a>
                </div>
            </section>
        </main>
    </div>

    <div id="lightbox" class="lightbox" onclick="this.style.display='none'">
        <div class="close-btn">&times;</div>
        <img id="lightboxImg">
    </div>

    <?php include 'footer.php'; ?>

    <script>
        function openLightbox(src) {
            document.getElementById('lightboxImg').src = src;
            document.getElementById('lightbox').style.display = 'flex';
        }
    </script>
</body>
</html>