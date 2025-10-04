<?php
require '../db_connection.php'; // Adjust path as needed

// Ensure this script is only accessed via POST
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    session_start();

    // Check if the user is logged in
    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'You must be logged in to change your password.']);
        exit;
    }

    // Retrieve data from the POST request
    $userId = $_SESSION['user_id'];
    $currentPassword = trim($_POST['currentPassword']);
    $newPassword = trim($_POST['newPassword']);

    // Input validation
    if (empty($currentPassword) || empty($newPassword)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    // Validate password complexity
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&\-_=+,.<>?:;#^])[A-Za-z\d@$!%*?&\-_=+,.<>?:;#^]{8,}$/';
    if (!preg_match($passwordRegex, $newPassword)) {
        echo json_encode(['success' => false, 'message' => 'Password must include uppercase, lowercase, a number, and a special character.']);
        exit;
    }

    try {
        // Fetch the current password hash from the database
        $query = "SELECT user_password FROM USER WHERE user_id = ?";
        $stmt = $conn->prepare($query);

        if (!$stmt) {
            throw new Exception("Failed to prepare statement: " . $conn->error);
        }

        $stmt->bind_param('i', $userId);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows === 0) {
            echo json_encode(['success' => false, 'message' => 'User not found.']);
            exit;
        }

        $row = $result->fetch_assoc();

        // Verify the current password
        if (!password_verify($currentPassword, $row['user_password'])) {
            echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
            exit;
        }

        // Hash the new password
        $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Update the password in the database
        $updateQuery = "UPDATE USER SET user_password = ? WHERE user_id = ?";
        $updateStmt = $conn->prepare($updateQuery);

        if (!$updateStmt) {
            throw new Exception("Failed to prepare update statement: " . $conn->error);
        }

        $updateStmt->bind_param('si', $hashedPassword, $userId);

        if ($updateStmt->execute()) {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
        } else {
            throw new Exception("Failed to execute update query: " . $updateStmt->error);
        }
    } catch (Exception $e) {
        // Log the error for debugging
        error_log("Password Update Error: " . $e->getMessage());
        echo json_encode(['success' => false, 'message' => 'An error occurred. Please try again later.']);
    }
    exit;
} else {
    // Handle invalid access method
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
    exit;
}
?>
