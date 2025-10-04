<?php
require '../db_connection.php'; // Include your database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);

    // Check if email exists in the database
    $query = "SELECT * FROM USER WHERE user_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Generate a unique reset token
        $token = bin2hex(random_bytes(32));

        // Store the token and its expiration in the database
        $expiry = date("Y-m-d H:i:s", strtotime("+1 hour")); // 1-hour expiration
        $updateQuery = "UPDATE USER SET reset_token = ?, reset_token_expiry = ? WHERE user_email = ?";
        $stmt = $conn->prepare($updateQuery);
        $stmt->bind_param('sss', $token, $expiry, $email);
        $stmt->execute();

        // Send the reset email
        $resetLink = "http://yourwebsite.com/reset_password.php?token=$token";
        $subject = "Password Reset Request";
        $message = "Click the link below to reset your password:\n\n$resetLink\n\nThis link will expire in 1 hour.";
        $headers = "From: no-reply@chicstylesboutique.com";

        if (mail($email, $subject, $message, $headers)) {
            echo "<script>
                alert('A password reset link has been sent to your email.');
                window.location.href = 'index.php';
            </script>";
        } else {
            echo "<script>
                alert('Failed to send the password reset email. Please try again.');
                window.location.href = 'forgotpass.php';
            </script>";
        }
    } else {
        echo "<script>
            alert('Email address not registered.');
            window.location.href = 'forgotpass.php';
        </script>";
    }
}
?>
