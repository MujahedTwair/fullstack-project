<?php
    // Start the session (if not already started)
    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }

    // Clear session data
    $_SESSION = array();

    // Destroy session
    session_destroy();

    // Redirect user to the login page
    echo '<script>window.location.assign("index.php");</script>';
?>