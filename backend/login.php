<?php
session_start();
include_once "./db.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Sanitize email input
    $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
    $password = $_POST['password'];

    if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email LIMIT 1");
        $stmt->execute(['email' => $email]);
        $user = $stmt->fetch();

        if ($user) {
            // Verify the provided password with the hashed password in the database
            if (password_verify($password, $user['password'])) {
                // Set session variables
                $_SESSION['id'] = $user['id'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['full_name'] = $user['full_name'] ?? 'Guest'; // Fallback to 'Guest' if full_name is null
                $_SESSION['image'] = $user['image'] ?? null;

                // Redirect to the homepage after successful login
                header("Location: ../index.php");
                exit();
            } else {
                // Redirect to the login page with an error message if the password is incorrect
                header("Location: ../login.php?error=Invalid password");
                exit();
            }
        } else {
            // Redirect to the login page with an error message if the user is not found
            header("Location: ../login.php?error=Invalid email or password");
            exit();
        }
    } else {
        // Redirect to the login page with an error message if the email is invalid
        header("Location: ../login.php?error=Invalid email format");
        exit();
    }
}
