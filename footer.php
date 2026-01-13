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
    <div class="footer-content">
        <p>&copy; 2026 GreenLeaf Veg Restaurant</p>
        <p class="footer-tagline">Pure Veg · Multi-Cuisine · Authentic Taste</p>
    </div>
</footer>