<?php
session_start();
include_once "./db.php";

$errors = [];  // Array to hold error messages

// Registration logic
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $full_name = $_POST['full_name'];
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirm_password = trim($_POST['confirm_password']);
    $university = trim($_POST['uni']);

    if (empty($full_name) || empty($email) || empty($password) || empty($confirm_password) || empty($university)) {
        $errors[] = "Please fill in all fields.";
    }


    // Email validation check
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors[] = "Valid email is required";
    }

    // Password validation checks
    if (strlen($password) < 8) {
        $errors[] = "Password must be at least 8 characters";
    }

    if (!preg_match("/[a-z]/i", $password)) {
        $errors[] = "Password must contain at least one letter";
    }

    if (!preg_match("/[0-9]/", $password)) {
        $errors[] = "Password must contain at least one number";
    }

    if ($password !== $confirm_password) {
        $errors[] = "Passwords do not match";
    }

    // Check if email already exists
    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
    $stmt->execute(['email' => $email]);
    if ($stmt->fetch()) {
        $errors[] = "Email already exists";
    }

    // If there are errors, redirect and display them
    if (!empty($errors)) {
        $errorMessage = implode(", ", $errors);
        header("Location: ../register.php?error=" . urlencode($errorMessage));
        exit();
    }

    // Hash the password before storing it
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert the new user into the database
    $stmt = $pdo->prepare("INSERT INTO users (full_name, email, password, university) VALUES (:full_name, :email, :password, :university)");
    $stmt->execute([
        'full_name' => $full_name,
        'email' => $email,
        'password' => $hashed_password,
        'university' => $university
    ]);

    // Redirect to a success page or login page
    header("Location: ../register.php?message=Registration successful");
    exit();
}
