<?php
include 'config.php';
$message = "";
$message_class = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = htmlspecialchars(trim($_POST['name']));
    $email = htmlspecialchars(trim($_POST['email']));
    $phone = htmlspecialchars(trim($_POST['phone']));
    $guests = intval($_POST['guests']);
    $date = $_POST['date'];
    $time = $_POST['time'];

    if (empty($name) || empty($email) || $guests < 1 || empty($date) || empty($time)) {
        $message = "Please fill out all required fields.";
        $message_class = "error";
    } else {
        try {
            $stmt = $dbh->prepare("SELECT total_tables FROM settings WHERE id=1");
            $stmt->execute();
            $total_tables = $stmt->fetchColumn();

            $stmt = $dbh->prepare("SELECT COUNT(*) FROM reservations WHERE reservation_date=? AND reservation_time=?");
            $stmt->execute([$date, $time]);
            $booked_tables = $stmt->fetchColumn();

            if ($booked_tables >= $total_tables) {
                $message = "Sorry, all tables are booked for this slot.";
                $message_class = "error";
            } else {
                $stmt = $dbh->prepare("INSERT INTO reservations (name, email, phone, guests, reservation_date, reservation_time) VALUES (?, ?, ?, ?, ?, ?)");
                $stmt->execute([$name, $email, $phone, $guests, $date, $time]);
                $message = "Table successfully reserved!";
                $message_class = "success";
            }
        } catch (PDOException $e) {
            $message = "Database error. Please try again later.";
            $message_class = "error";
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reserve a Table | The GreenLeaf Veg. Restaurant</title>
    <link rel="icon" type="image/x-icon" href="assets/img/favicon.ico">
    <link rel="stylesheet" href="assets/css/index-styles.css" type="text/css">
    <link rel="stylesheet" href="assets/css/reservation-styles.css" type="text/css">
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
                <a href="reservation.php" class="active">Reserve Table</a>
                <a href="contact.php">Contact Us</a>
            </nav>
        </div>
    </header>

    <div class="reservation-wrapper">
        <header class="page-intro">
            <h1 class="main-title">Book Your Table 🍽️</h1>
            <p class="subtitle">Join us for a flavorful vegetarian experience.</p>
        </header>
        
        <main class="form-container">
            <?php if($message): ?>
                <div class="message-box <?php echo $message_class; ?>">
                    <strong><?php echo $message; ?></strong>
                </div>
            <?php endif; ?>

            <form method="post" class="reservation-form">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter your name" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="email@example.com" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" placeholder="Phone number" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" required>
                    </div>
                    <div class="form-group">
                        <label for="time">Time</label>
                        <input type="time" id="time" name="time" required>
                    </div>
                </div>

                <div class="form-group">
                    <label for="guests">Number of Guests</label>
                    <input type="number" id="guests" name="guests" required min="1" max="20">
                </div>

                <button type="submit" class="submit-btn">Confirm Reservation</button>
            </form>
        </main>
    </div>

    <footer class="site-footer">
        <p>&copy; 2026 GreenLeaf Veg Restaurant</p>
        <p class="footer-tagline">Pure Veg · Multi-Cuisine · Authentic Taste</p>
    </footer>

</body>
</html>