<?php
require 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize input data
    $name = htmlspecialchars(trim($_POST['name']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Validation
    if (empty($name) || empty($email) || empty($message)) {
        header("Location: contact.php?msg=empty_fields");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: contact.php?msg=invalid_email");
        exit();
    }

    try {
        $stmt = $dbh->prepare("INSERT INTO contact_messages (name, email, subject, message) VALUES (?, ?, ?, ?)");
        $stmt->execute([$name, $email, $subject, $message]);
        
        // Success redirect
        header("Location: contact.php?msg=success");
        exit();
    } catch (PDOException $e) {
        // Log error and redirect with failure
        error_log("Contact form error: " . $e->getMessage());
        header("Location: contact.php?msg=error");
        exit();
    }
} else {
    header("Location: contact.php");
    exit();
}