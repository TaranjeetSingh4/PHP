<?php
session_start();

function isLoggedIn() {
    return isset($_SESSION['user_id']) && isset($_SESSION['role'] )  && isset($_SESSION['name'] );
}

function redirectIfNotLoggedIn() {
    if (!isLoggedIn()) {
        header('Location: ../login.php');
        exit();
    }
}

// New function to protect a page for a specific role
function requireRole($role) {
    redirectIfNotLoggedIn();
    if ($_SESSION['role'] !== $role) {
        // Redirect to login or a 403 page if role does not match
        header('Location: ../login.php');
        exit();
    }
}

?>
