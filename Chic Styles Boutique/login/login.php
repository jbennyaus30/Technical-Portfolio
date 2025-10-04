<?php
// Include the database connection
require '../db_connection.php';

session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = trim($_POST['email']);
    $password = trim($_POST['password']);

    // Validate input fields
    if (empty($email) || empty($password)) {
        header('Location: ../login/index.php?error=invalid_credentials');
        exit;
    }

    // Check if the user exists
    $query = "SELECT * FROM USER WHERE user_email = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('s', $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $user = $result->fetch_assoc();

        // Verify the password
        if (password_verify($password, $user['user_password'])) {
            // Start the session and store user details
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['user_first_name'] = $user['user_first_name'];
            $_SESSION['user_last_name'] = $user['user_last_name'];

            // Redirect to homepage
            echo "
                <script>
                    sessionStorage.setItem('isLoggedIn', 'true');
                    sessionStorage.setItem('userName', '{$user['user_first_name']} {$user['user_last_name']}');
                    window.location.href = '../index.php';
                </script>
            ";
            exit;
        }
    }

    // Redirect with a general error if email or password is incorrect
    header('Location: ../login/index.php?error=invalid_credentials');
    exit;
}
?>
