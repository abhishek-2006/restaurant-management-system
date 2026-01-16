<header class="site-header">
    <div class="header-container">
        <div class="logo-area">
            <img src="assets/img/logo.png" alt="GreenLeaf Logo" class="main-logo">
            <div class="brand-text">
                <h1 class="brand-name">GreenLeaf Veg Restaurant</h1>
                <span class="tagline">Fresh. Flavorful. Vegetarian.</span>
            </div>
        </div>
        
        <nav class="main-nav">
            <div class="nav-links">
                <a href="index.php" class="<?php echo ($activePage == 'home') ? 'active' : ''; ?>">Home</a>
                <a href="about.php" class="<?php echo ($activePage == 'about') ? 'active' : ''; ?>">About Us</a>
                <a href="menu.php" class="<?php echo ($activePage == 'menu') ? 'active' : ''; ?>">Menu</a>
                <a href="contact.php" class="<?php echo ($activePage == 'contact') ? 'active' : ''; ?>">Contact Us</a>
            </div>
            <?php if (!isset($_SESSION['user_id'])): ?>
                <div class="nav-auth-btns">
                    <a href="login.php" class="nav-btn login-btn">Login</a>
                    <a href="signup.php" class="nav-btn register-btn">Register</a>
                </div>
            <?php else: ?>
                <div class="nav-auth-btns"> 
                    <a href="dashboard.php" class="<?php echo ($activePage == 'dashboard') ? 'active' : ''; ?> nav-btn dashboard-btn">Dashboard</a>
                </div>
            <?php endif; ?>
        </nav>
    </div>
</header>