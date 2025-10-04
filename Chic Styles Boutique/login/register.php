<?php
require '../db_connection.php'; // Include database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Collect data from the form
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);
    $confirmPassword = trim($_POST['confirmPassword']);
    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

    // Validate inputs
    if (empty($firstName) || empty($lastName) || empty($email) || empty($password) || empty($confirmPassword)) {
        echo "<script>alert('All fields are required!'); window.history.back();</script>";
        exit();
    }

    // Check if passwords match
    if ($password !== $confirmPassword) {
        echo "<script>alert('Passwords do not match!'); window.history.back();</script>";
        exit();
    }

    // Validate password complexity
    $passwordRegex = '/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&\-_=+,.<>?:;#^])[A-Za-z\d@$!%*?&\-_=+,.<>?:;#^]{8,}$/';
    if (!preg_match($passwordRegex, $password)) {
        echo "<script>alert('Password does not meet the required complexity. It must include at least one uppercase letter, one lowercase letter, one number, and one special character.'); window.history.back();</script>";
        exit();
    }

    // Check if the email is already registered
    $query = "SELECT * FROM USER WHERE user_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        echo "<script>alert('Email is already registered!'); window.history.back();</script>";
        exit();
    }

    // Default role_id = 1 (Member)
    $roleId = 1;

    // Insert the user into the database
    $query = "INSERT INTO USER (user_first_name, user_last_name, user_email, user_password, user_role_id) 
              VALUES (?, ?, ?, ?, ?)";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $firstName, $lastName, $email, $hashedPassword, $roleId);

    if ($stmt->execute()) {
        // Display a success message and redirect
        echo "<script>
            alert('Account created successfully! Please log in.');
            window.location.href = 'index.php'; // Replace with the login page URL
        </script>";
        exit();
    } else {
        echo "<script>alert('Error: " . $stmt->error . "'); window.history.back();</script>";
        exit();
    }
}
?>
