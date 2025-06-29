<?php
session_start();
if (isset($_SESSION['user_id'])) {
    header("Location: ../dashboard/index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Register - Job Portal</title>
    <link rel="stylesheet" href="../../css/style.css">


</head>
<body>
    <h2>Register</h2>

    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>".htmlspecialchars($_GET['error'])."</p>";
    }
    ?>

    <form action="../actions/handle_register.php" method="POST">
        <label>Full Name:</label><br>
        <input type="text" name="name" required><br><br>

        <label>Email:</label><br>
        <input type="email" name="email" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label>User Type:</label><br>
        <select name="user_type" required>
            <option value="">Select...</option>
            <option value="seeker">Job Seeker</option>
            <option value="employer">Employer</option>
        </select><br><br>

        <button type="submit">Register</button>
    </form>

    <p>Already have an account? <a href="login.php">Login here</a></p>
</body>
</html>
