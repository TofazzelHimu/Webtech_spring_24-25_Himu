<?php
require_once '../config/db.php';

function cleanInput($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $name = cleanInput($_POST['name']);
    $email = cleanInput($_POST['email']);
    $password = $_POST['password'];
    $user_type = $_POST['user_type'];

    // Validation
    if (!preg_match("/^[a-zA-Z\s]+$/", $name)) {
        header("Location: ../auth/register.php?error=Invalid name format");
        exit();
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../auth/register.php?error=Invalid email address");
        exit();
    }

    if (strlen($password) < 6) {
        header("Location: ../auth/register.php?error=Password must be at least 6 characters");
        exit();
    }

    if (!in_array($user_type, ['seeker', 'employer'])) {
        header("Location: ../auth/register.php?error=Invalid user type");
        exit();
    }

    // Check if email exists
    $stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows > 0) {
        header("Location: ../auth/register.php?error=Email already exists");
        exit();
    }
    $stmt->close();

    // Hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert into DB
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, user_type) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $hashed_password, $user_type);
    if ($stmt->execute()) {
        header("Location: ../auth/login.php");
        exit();
    } else {
        header("Location: ../auth/register.php?error=Registration failed");
        exit();
    }
}
?>
