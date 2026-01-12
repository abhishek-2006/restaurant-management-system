<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | The GreenLeaf Veg. Restaurant</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/contact-styles.css" type="text/css">
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
                <a href="menu.php">Menu</a>
                <a href="reservation.php">Reserve Table</a>
                <a href="contact.php" class="active">Contact</a>
            </nav>
        </div>
    </header>

    <div class="contact-wrapper">
        <header class="page-intro">
            <h1 class="main-title">Get In Touch 📞</h1>
            <p class="subtitle">Have a question or feedback? We'd love to hear from you.</p>
        </header>

        <main class="contact-grid">
            <section class="contact-info">
                <div class="info-card">
                    <h3>Our Location</h3>
                    <p>123 Green Avenue, Foodie District<br>Surat, Gujarat, India</p>
                </div>
                <div class="info-card">
                    <h3>Contact Details</h3>
                    <p><strong>Phone:</strong> +91 98765 43210</p>
                    <p><strong>Email:</strong> hello@greenleafveg.com</p>
                </div>
                <div class="info-card">
                    <h3>Hours of Operation</h3>
                    <p>Mon - Sun: 11:00 AM - 11:00 PM</p>
                </div>
            </section>

            <section class="contact-form-container">
                <form action="#" class="contact-form">
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" id="name" name="name" placeholder="Your Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="Your Email" required>
                    </div>
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <input type="text" id="subject" name="subject" placeholder="What is this about?">
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" placeholder="Your message here..." required></textarea>
                    </div>
                    <button type="submit" class="submit-btn">Send Message</button>
                </form>
            </section>
        </main>
    </div>

    <footer class="site-footer">
        <p>&copy; 2026 GreenLeaf Veg Restaurant</p>
        <p class="footer-tagline">Pure Veg · Multi-Cuisine · Authentic Taste</p>
    </footer>

</body>
</html>