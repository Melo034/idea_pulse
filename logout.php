<?php
session_start();

if (isset($_SESSION)) {
    session_unset(); // Unset all session variables
    session_destroy(); // Destroy the session
    session_regenerate_id(true); // Prevent session fixation attacks
}

// Redirect to the index page
header("Location: ./index.php");
exit();
