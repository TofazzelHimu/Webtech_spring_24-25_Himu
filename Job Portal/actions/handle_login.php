<?php
session_start();
require_once '../config/db.php';

function cleanInput($data) {
    return htmlspecialchars(trim($data));
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $email = cleanInput($_POST['email']);
    $password = $_POST['password'];
    $remember = isset($_POST['remember']);

    // Validate email
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        header("Location: ../auth/login.php?error=Invalid email format");
        exit();
    }

    // Fetch user by email
    $stmt = $conn->prepare("SELECT id, name, password, user_type FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $stmt->store_result();

    if ($stmt->num_rows === 1) {
        $stmt->bind_result($id, $name, $hashed_password, $user_type);
        $stmt->fetch();

        if (password_verify($password, $hashed_password)) {
            // Success — set session
            $_SESSION['user_id'] = $id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_type'] = $user_type;

            // Set cookie if "Remember Me" was checked
            if ($remember) {
                setcookie("email", $email, time() + (86400 * 7), "/"); // 7 days
            } else {
                setcookie("email", "", time() - 3600, "/"); // delete cookie
            }

            header("Location: ../dashboard/index.php");
            exit();
        } else {
            header("Location: ../auth/login.php?error=Incorrect password");
            exit();
        }
    } else {
        $stmt->close();
        header("Location: ../auth/login.php?error=Email not found");
        exit();
    }

}
?>
