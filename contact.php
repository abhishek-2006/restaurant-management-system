<?php 
$activePage = 'contact';
require 'config.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us | The GreenLeaf</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css">
    <link rel="stylesheet" href="assets/css/contact-styles.css">
</head>
<body>

    <?php include 'header.php'; ?>

    <div class="contact-container">
        <?php if (isset($_GET['msg'])): ?>
            <?php if ($_GET['msg'] == 'success'): ?>
                <div class="alert alert-success">✨ Thank you! Your message has been received. We'll get back to you soon.</div>
            <?php elseif ($_GET['msg'] == 'error' || $_GET['msg'] == 'empty_fields'): ?>
                <div class="alert alert-danger">❌ Something went wrong. Please check your details and try again.</div>
            <?php endif; ?>
        <?php endif; ?>
    </div>

    <main class="contact-container">
        <header class="contact-header">
            <h1>Get in Touch</h1>
            <p>Have a question or feedback? We'd love to hear from you.</p>
        </header>

        <div class="contact-grid">
            <div class="contact-info">
                <div class="info-box">
                    <div class="info-icon">📍</div>
                    <div class="info-details">
                        <h3>Visit Us</h3>
                        <p>123 Garden Street, Bardoli, Gujarat 394601</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon">📞</div>
                    <div class="info-details">
                        <h3>Call Us</h3>
                        <p>+91 98765 43210</p>
                    </div>
                </div>

                <div class="info-box">
                    <div class="info-icon">✉️</div>
                    <div class="info-details">
                        <h3>Email Us</h3>
                        <p>hello@thegreenleaf.com</p>
                    </div>
                </div>
            </div>

            <section class="form-section">
                <form action="process-contact.php" method="POST" class="solid-form">
                    <div class="form-row">
                        <div class="form-group">
                            <label for="full-name">Full Name</label>
                            <input type="text" id="full-name" name="name" placeholder="John Doe" required>
                        </div>
                        <div class="form-group">
                            <label for="email-address">Email Address</label>
                            <input type="email" id="email-address" name="email" placeholder="john@example.com" required>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label for="subject">Subject</label>
                        <select id="subject" name="subject">
                            <option value="general">General Inquiry</option>
                            <option value="feedback">Feedback</option>
                            <option value="event">Private Event</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea id="message" name="message" rows="5" placeholder="How can we help you?" required></textarea>
                    </div>

                    <button type="submit" id="submit-button" class="btn-submit">Send Message</button>
                </form>
            </section>
        </div>
    </main>

    <?php include 'footer.php'; ?>

</body>
</html>