<?php

// Check if email is set in the POST request
if (isset($_POST["email"])) {

    // Initialize email and generate a reset token
    $email = $_POST["email"];
    $token = bin2hex(random_bytes(16));
    $token_hash = hash("sha256", $token);
    $expiry = date("Y-m-d H:i:s", time() + 60 * 30);

    // Include the database connection
    include_once "./db.php";

    // Prepare an SQL query to update the user's reset token and its expiry time
    $sql = "UPDATE users
            SET reset_token_hash = ?,
                reset_token_expires_at = ?
            WHERE email = ?";
    $stmt = $pdo->prepare($sql);

    // Check if the statement was prepared successfully
    if (!$stmt) {
        die("Prepare failed: " . $pdo->errorInfo()[2]);
    }

    // Bind the parameters to the statement
    $stmt->bindParam(1, $token_hash);
    $stmt->bindParam(2, $expiry);
    $stmt->bindParam(3, $email);

    // Execute the statement and check for errors
    if (!$stmt->execute()) {
        die("Execute failed: " . $stmt->errorInfo()[2]);
    }

    // If the email exists and the token was set, send the reset password link
    if ($stmt->rowCount()) {
        $mail = require __DIR__ . "/mailer.php";
        $mail->setFrom("noreply@example.com");
        $mail->addAddress($email);
        $mail->Subject = "Password Reset";

        // Create a password reset link
        $resetLink = "http://localhost/php%20projects/IdeaPulse/create_new_password.php?token=" . urlencode($token);
        $mail->Body = "Click <a href='{$resetLink}'>here</a> to reset your password.";

        // Attempt to send the email
        try {
            $mail->send();
        } catch (Exception $e) {
            echo "Message could not be sent. Mailer error: {$mail->ErrorInfo}";
        }
    }

    // Redirect to a message page after the process
    header("Location: ../message.php");

    // Close the statement and the database connection
    $stmt = null;
    $pdo = null;
}
?>