<?php
session_start();
include 'config.php';

// Check if user is logged in and an ID is provided
if (isset($_SESSION['user_id']) && isset($_GET['id'])) {
    $booking_id = $_GET['id'];
    $user_id = $_SESSION['user_id'];

    try {
        // Security check: Match booking ID with logged-in user ID
        $stmt = $dbh->prepare("DELETE FROM reservations WHERE id = ? AND user_id = ?");
        $stmt->execute([$booking_id, $user_id]);

        // Redirect back to dashboard with success message
        header("Location: dashboard.php?msg=cancelled");
        exit();
    } catch (PDOException $e) {
        header("Location: dashboard.php?msg=error");
        exit();
    }
} else {
    header("Location: login.php");
    exit();
}
?>