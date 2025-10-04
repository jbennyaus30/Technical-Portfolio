<?php
ob_start(); // Start output buffering
header('Content-Type: application/json'); // Set content type to JSON

include '../config.php';
include '../db_connection.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }

    if (!isset($_SESSION['user_id'])) {
        echo json_encode(['success' => false, 'message' => 'User not logged in.']);
        exit;
    }

    // Retrieve user input from POST request
    $firstName = trim($_POST['firstName']);
    $lastName = trim($_POST['lastName']);
    $companyName = trim($_POST['companyName']);
    $phone = trim($_POST['phone']);
    $email = trim($_POST['email']);
    $country = trim($_POST['country']);
    $addressLine1 = trim($_POST['addressLine1']);
    $addressLine2 = trim($_POST['addressLine2']);
    $suburb = trim($_POST['suburb']);
    $state = trim($_POST['state']);
    $postcode = trim($_POST['postcode']);

    // Validate required fields
    if (empty($firstName) || empty($lastName) || empty($phone) || empty($email) || empty($country) || empty($addressLine1) || empty($suburb) || empty($state) || empty($postcode)) {
        echo json_encode(['success' => false, 'message' => 'All mandatory fields must be filled.']);
        exit;
    }

    // Validate phone number format (starts with +61 for Australia)
    if (!preg_match('/^\+61\d{9}$/', $phone)) {
        echo json_encode(['success' => false, 'message' => 'Invalid phone number format. Please use +61 followed by 9 digits.']);
        exit;
    }

    // Validate email format
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo json_encode(['success' => false, 'message' => 'Invalid email format.']);
        exit;
    }

    // Generate a unique billing_id
    $billingId = bin2hex(random_bytes(16)); // Generate a random 32-character ID

    $userId = $_SESSION['user_id'];

    // Check if a billing record already exists for the user
    $checkQuery = "SELECT * FROM billing_details WHERE user_id = ?";
    $checkStmt = $conn->prepare($checkQuery);
    if (!$checkStmt) {
        echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
        exit;
    }
    $checkStmt->bind_param('s', $userId);
    $checkStmt->execute();
    $existingRecord = $checkStmt->get_result()->fetch_assoc();
    $checkStmt->close();

    if ($existingRecord) {
        // Update existing record
        $query = "UPDATE billing_details SET 
                    first_name = ?, 
                    last_name = ?, 
                    company_name = ?, 
                    phone = ?, 
                    email = ?, 
                    country = ?, 
                    address_line1 = ?, 
                    address_line2 = ?, 
                    suburb = ?, 
                    state = ?, 
                    postcode = ?, 
                    last_updated = NOW()
                  WHERE user_id = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param(
            'ssssssssssss',
            $firstName, $lastName, $companyName, $phone, $email, $country,
            $addressLine1, $addressLine2, $suburb, $state, $postcode, $userId
        );
    } else {
        // Insert new record
        $query = "INSERT INTO billing_details (
                    billing_id, user_id, first_name, last_name, company_name, phone, 
                    email, country, address_line1, address_line2, suburb, state, postcode, last_updated
                  ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            echo json_encode(['success' => false, 'message' => 'Database error: ' . $conn->error]);
            exit;
        }
        $stmt->bind_param(
            'sssssssssssss',
            $billingId, $userId, $firstName, $lastName, $companyName, $phone, $email,
            $country, $addressLine1, $addressLine2, $suburb, $state, $postcode
        );
    }

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Billing details updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update billing details.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
