<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: ../auth/login.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Dashboard - Job Portal</title>
    <link rel="stylesheet" href="../css/style.css">
</head>
<body>
<header style="background:#f2f2f2; padding:10px;">
    <h3>Welcome, <?php echo htmlspecialchars($_SESSION['user_name']); ?> (<?php echo $_SESSION['user_type']; ?>)</h3>
    <nav>
        <a href="index.php">🏠 Dashboard</a> |
        <a href="job_alerts.php">🔔 Job Alerts</a> |
        <a href="interviews.php">📅 Interviews</a> |
        <a href="employer.php">🧑‍💼 Employer Panel</a> |
        <a href="../auth/logout.php">🚪 Logout</a>
    </nav>
</header>
<main style="padding:20px;">
