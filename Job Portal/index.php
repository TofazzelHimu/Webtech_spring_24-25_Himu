<?php
session_start();

// Redirect user based on login status
if (isset($_SESSION['user_id'])) {
    header("Location: dashboard/index.php");
    exit();
} else {
    header("Location: auth/login.php");
    exit();
}
?>