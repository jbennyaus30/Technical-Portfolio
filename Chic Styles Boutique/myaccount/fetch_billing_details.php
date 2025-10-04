<?php
include '../config.php';
include '../db_connection.php';

// Start the session if it's not already started
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

$userId = $_SESSION['user_id'];

// Fetch the user's billing details from the database
$query = "SELECT first_name, last_name, company_name, phone, email, country, address_line1, address_line2, suburb, state, postcode 
          FROM billing_details WHERE user_id = ?";
$stmt = $conn->prepare($query);

if ($stmt) {
    $stmt->bind_param('s', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $billingDetails = $result->fetch_assoc();
    $stmt->close();

    if ($billingDetails) {
        // Return the billing details as a JSON response
        echo json_encode(['success' => true, 'billingDetails' => $billingDetails]);
    } else {
        // If no details are found, return an empty response
        echo json_encode(['success' => false, 'message' => 'No billing details found.']);
    }
} else {
    // Handle database query errors
    echo json_encode(['success' => false, 'message' => 'Failed to execute database query.']);
    error_log("Database error: " . $conn->error);
}

$conn->close();
?>
