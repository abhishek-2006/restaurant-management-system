<?php
session_start();
$_SESSION = array();

// Destroy the session cookie if it exists
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time()-42000, '/');
}

// Destroy the session on the server
session_destroy();

// Redirect to home page
header("Location: index.php");
exit();
?>