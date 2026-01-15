<?php
require 'config.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?msg=login_required");
    exit();
}

$message = "";
$message_class = "";
$activePage = 'reservation';
$user_id = $_SESSION['user_id'];

$stmt = $dbh->prepare("SELECT full_name, email, phone FROM users WHERE user_id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();

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
            // Check availability
            $stmt = $dbh->prepare("SELECT total_tables FROM settings WHERE id=1");
            $stmt->execute();
            $total_tables = $stmt->fetchColumn();

            $stmt = $dbh->prepare("SELECT COUNT(*) FROM reservations 
                                WHERE reservation_date = ? 
                                AND reservation_time = ? 
                                AND status IN ('pending', 'ongoing')");
            $stmt->execute([$date, $time]);
            $booked_tables = $stmt->fetchColumn();

            $user_id = $_SESSION['user_id'];
            $stmt = $dbh->prepare("SELECT role FROM users WHERE user_id = ?");
            $stmt->execute([$user_id]);
            $user_role = $stmt->fetchColumn();

            if ($user_role === 'banned') {
                $message = "Your account has been restricted. You are no longer permitted to make reservations.";
                $message_class = "error";
                $is_banned = true; 
            }

            if ($booked_tables >= $total_tables) {
                $message = "Sorry, all tables are booked for this slot.";
                $message_class = "error";
            } else {
                $stmt = $dbh->prepare("INSERT INTO reservations (user_id, name, email, phone, guests, reservation_date, reservation_time) VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$user_id, $name, $email, $phone, $guests, $date, $time]);
                $message = "Table successfully reserved! View it in your dashboard.";
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

    <?php include 'header.php'; ?>

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
                    <input type="text" id="name" name="name" placeholder="Enter your name" value="<?php echo htmlspecialchars($user['full_name']); ?>" required>
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" id="email" name="email" placeholder="email@example.com" value="<?php echo htmlspecialchars($user['email']); ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="tel" id="phone" name="phone" placeholder="Phone number" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-group">
                        <label for="date">Date</label>
                        <input type="date" id="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>
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

                <button type="submit" id="reserveBtn" class="submit-btn">
                    <span id="btnText">Confirm Reservation</span>
                    <span id="btnLoader" style="display:none;">🌿 Processing...</span>
                </button>
            </form>
        </main>
    </div>

    <script>
        document.querySelector('.reservation-form').onsubmit = function() {
            document.getElementById('btnText').style.display = 'none';
            document.getElementById('btnLoader').style.display = 'inline';
            document.getElementById('reserveBtn').disabled = true;
        };
    </script>

    <?php include 'footer.php'; ?>

</body>
</html>