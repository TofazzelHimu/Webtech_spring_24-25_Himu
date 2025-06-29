<?php
session_start();

// Destroy session variables
$_SESSION = [];
session_unset();
session_destroy();
header("Location: login.php");
exit();
?>
