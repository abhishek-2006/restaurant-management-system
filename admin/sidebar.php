<aside class="admin-sidebar">
    <div class="admin-logo">
        <img src="assets/img/logo.png" alt="GreenLeaf Logo" class="sidebar-logo">
        <h3>Admin Panel</h3>
    </div>
    <nav class="sidebar-nav">
        <a href="dashboard.php" class="<?php echo ($activePage == 'dashboard') ? 'active' : ''; ?>">📊 Dashboard</a>
        <a href="manage-reservations.php" class="<?php echo ($activePage == 'reservations') ? 'active' : ''; ?>">📅 Reservations</a>
        <a href="manage-menu.php" class="<?php echo ($activePage == 'menu') ? 'active' : ''; ?>">🍛 Menu Items</a>
        <a href="manage-users.php" class="<?php echo ($activePage == 'users') ? 'active' : ''; ?>">👥 Users</a>
        <a href="settings.php" class="<?php echo ($activePage == 'settings') ? 'active' : ''; ?>">⚙️ Settings</a>
        <hr style="border: 0; border-top: 1px solid #334155; margin: 10px 0;">
        <a href="logout.php" class="logout-link">🚪 Logout</a>
    </nav>
</aside>