<?php
// Include the database connection file
include_once "./db.php"; 

$errors = [];

// Check if the token is provided via POST request
if (!isset($_POST["token"])) {
    $errors[] = "Token not provided";
}

// Get the token from the POST request, if not provided, set it to an empty string
$token = $_POST["token"] ?? "";
if (empty($token)) {
    $errors[] = "Empty token";
}

// Hash the token using SHA-256
$token_hash = hash("sha256", $token);

// Prepare the SQL query to find the user by the hashed token
$query = "SELECT * FROM users WHERE reset_token_hash = :token_hash";
$stmt = $pdo->prepare($query);
$stmt->execute(['token_hash' => $token_hash]);

// Fetch the user from the database
$user = $stmt->fetch();

// If the user is not found, add an error
if (!$user) {
    $errors[] = "Token not found";
}

// Check if the token has expired
if (strtotime($user["reset_token_expires_at"]) <= time()) {
    $errors[] = "Token has expired";
}

// Retrieve the new password and confirmation from the POST request
$password = $_POST["password"] ?? "";
$confirm_password = $_POST["confirm_password"] ?? "";

// Validate the new password (minimum length, contains letter and number)
if (strlen($password) < 8) {
    $errors[] = "Password must be at least 8 characters";
}

if (!preg_match("/[a-z]/i", $password)) {
    $errors[] = "Password must contain at least one letter";
}

if (!preg_match("/[0-9]/", $password)) {
    $errors[] = "Password must contain at least one number";
}

// Check if the password and confirmation match
if ($password !== $confirm_password) {
    $errors[] = "Passwords must match";
}

// If there are errors, stop execution and redirect to the form with errors
if (!empty($errors)) {
    $errorMessage = implode(", ", $errors);
    header("Location: ../create_new_password.php?token=" . $token . "&error=" . urlencode($errorMessage));
    exit();
}

// Hash the new password using a secure algorithm
$hashed_password = password_hash($password, PASSWORD_DEFAULT);

// Update the user's password in the database and clear the reset token and expiration
$updateQuery = "UPDATE users SET password = :password, reset_token_hash = NULL, reset_token_expires_at = NULL WHERE id = :id";
$stmt = $pdo->prepare($updateQuery);
$stmt->execute(['password' => $hashed_password, 'id' => $user["id"]]);

// Redirect to the login page after successful password reset
header("Location: ../new_login.php");