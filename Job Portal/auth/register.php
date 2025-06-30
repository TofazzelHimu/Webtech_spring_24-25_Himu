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
<body style="margin: 0; height: 100vh; display: flex; align-items: center; justify-content: center; background: #f2f2f2;">

    <div style="width: 100%; max-width: 450px; background: #fff; padding: 25px; border-radius: 10px; box-shadow: 0 0 8px rgba(0,0,0,0.1);">

        <h2 style="text-align:center;">Register</h2>

        <?php
        if (isset($_GET['error'])) {
            echo "<p style='color:red; text-align:center;'>".htmlspecialchars($_GET['error'])."</p>";
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

            <button type="submit" style="width:100%; padding:10px; background:#2a4d9b; color:white; border:none; border-radius:5px; cursor:pointer;">Register</button>
        </form>

        <p style="margin-top: 15px; text-align:center;">
            Already have an account? 
            <a href="login.php" style="color:#2a4d9b; font-weight:500; text-decoration:none; border-bottom:1px dashed #2a4d9b;">Login here</a>
        </p>
    </div>

</body>
</html>
