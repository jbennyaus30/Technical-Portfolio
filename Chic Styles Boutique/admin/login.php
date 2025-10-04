<?php
session_start();
require_once '../config.php'; 
require_once '../db_connection.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Validate inputs
    if (!filter_var($email, FILTER_VALIDATE_EMAIL) || empty($password)) {
        die("Invalid email or password input.");
    }

    // Adjusted query to match the user table structure
    $sql = "SELECT user_id, user_first_name, user_last_name, user_password FROM user WHERE user_email = ? AND user_role_id = 2";
    $stmt = $conn->prepare($sql);

    if (!$stmt) {
        die("SQL preparation failed: " . $conn->error);
    }

    // Bind email parameter and execute
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();

        // Verify the password using password_verify
        if (password_verify($password, $row['user_password'])) {
            // Store the admin ID and name in the session
            $_SESSION['admin_id'] = $row['user_id'];
            $_SESSION['admin_name'] = $row['user_first_name'] . ' ' . $row['user_last_name']; // Combine first and last name
        
            // Redirect to the admin dashboard
            header('Location: ' . BASE_URL . 'admin/dashboard/index.php');
            exit();
        } else {
            die("Invalid password.");
        }
    } else {
        die("No user found with this email or not an admin.");
    }

    $stmt->close();
}
$conn->close();
?>
