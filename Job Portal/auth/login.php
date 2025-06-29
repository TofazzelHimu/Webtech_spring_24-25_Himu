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
    <title>Login - Job Portal</title>
    <link rel="stylesheet" href="../../css/style.css">
</head>
<body>
    <h2>Login</h2>

    <?php
    if (isset($_GET['error'])) {
        echo "<p style='color:red;'>".htmlspecialchars($_GET['error'])."</p>";
    }
    ?>

    <form action="../actions/handle_login.php" method="POST">
        <label>Email:</label><br>
        <input type="email" name="email" value="<?php echo isset($_COOKIE['email']) ? htmlspecialchars($_COOKIE['email']) : ''; ?>" required><br><br>

        <label>Password:</label><br>
        <input type="password" name="password" required><br><br>

        <label> <input type="checkbox" name="remember" <?php echo isset($_COOKIE['email']) ? 'checked' : ''; ?>> Remember Me </label>


        <button type="submit">Login</button>
    </form>

    <p>Don't have an account? <a href="register.php">Register here</a></p>
</body>
</html>
