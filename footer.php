<button id="scrollTopBtn" title="Go to top">↑</button>

<script>
window.onscroll = function() {
    let btn = document.getElementById("scrollTopBtn");
    if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
        btn.style.display = "block";
    } else {
        btn.style.display = "none";
    }
};

document.getElementById("scrollTopBtn").onclick = function() {
    window.scrollTo({top: 0, behavior: 'smooth'});
};
</script>
<footer class="site-footer">
    <div class="footer-container">
        <div class="footer-col branding">
            <img src="assets/img/logo.png" alt="GreenLeaf Logo" class="footer-logo">
            <p class="footer-tagline">Authentic Indian Multi-Cuisine Veg Restaurant. Since 2026.</p>
        </div>

        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="menu.php">Menu</a></li>
                <li><a href="about.php">Our Story</a></li>
                <li><a href="reservation.php">Book Table</a></li>
            </ul>
        </div>

        <div class="footer-col">
            <h4>Find Us</h4>
            <p>📍 123 Garden Street, <br>Bardoli, Gujarat 394601</p>
            <p>📞 +91 98765 43210</p>
            <p>✉️ hello@greenleaf.com</p>
        </div>

        <div class="footer-col">
            <h4>Opening Hours</h4>
            <p>Mon - Fri: 11:00 AM - 11:00 PM</p>
            <p>Sat - Sun: 09:00 AM - 12:00 AM</p>
            <div class="status-indicator">
                <span class="status-dot"></span> Open Now
            </div>
        </div>
    </div>
    <div class="footer-bottom">
        <p>&copy; 2026 The GreenLeaf Veg Restaurant. All Rights Reserved.</p>
    </div>
</footer>