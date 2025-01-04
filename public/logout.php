<?php
// Logout script

// Initialize the session
session_start();

// Unset all session variables
$_SESSION = array();

// Destroy the session.
session_unset();
session_destroy();

// Redirect to login page after logout
header("Location: login.php");
exit;
?>
