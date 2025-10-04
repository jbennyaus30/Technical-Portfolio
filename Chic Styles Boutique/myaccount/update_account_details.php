<?php
session_start();
include '../db_connection.php';

// Path to the file used for SSE updates
$sseFilePath = __DIR__ . '/sse_data.json';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $userId = $_SESSION['user_id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    // Validate inputs
    if (empty($firstName) || empty($lastName) || empty($email)) {
        http_response_code(400);
        echo json_encode(['message' => 'First Name, Last Name, and Email are required.']);
        exit;
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        http_response_code(400);
        echo json_encode(['message' => 'Invalid email format.']);
        exit;
    }

    // Update database
    $query = "UPDATE USER SET user_first_name = ?, user_last_name = ?, user_email = ?, user_phone = ? WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ssssi', $firstName, $lastName, $email, $phone, $userId);

    if ($stmt->execute()) {
        // Update session variables
        $_SESSION['user_first_name'] = $firstName;
        $_SESSION['user_last_name'] = $lastName;

        // Write updated data to the SSE file
        $sseData = [
            'firstName' => $firstName,
            'lastName' => $lastName,
        ];
        file_put_contents($sseFilePath, json_encode($sseData));

        echo json_encode([
            'message' => 'Details updated successfully.',
            'firstName' => $_SESSION['user_first_name'],
            'lastName' => $_SESSION['user_last_name']
        ]);
    } else {
        http_response_code(500);
        echo json_encode(['message' => 'Failed to update details.']);
    }
    $stmt->close();
    $conn->close();
}
