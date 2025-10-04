<?php
session_start();
header("Content-Type: text/event-stream");
header("Cache-Control: no-cache");
header("Connection: keep-alive");

include '../db_connection.php';

if (!isset($_SESSION['user_id'])) {
    echo "data: {}\n\n";
    exit;
}

$userId = $_SESSION['user_id'];

while (true) {
    // Fetch the latest name from the database
    $query = "SELECT user_first_name, user_last_name FROM USER WHERE user_id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('i', $userId);
    $stmt->execute();
    $result = $stmt->get_result();
    $user = $result->fetch_assoc();
    $stmt->close();

    if ($user) {
        $response = [
            'firstName' => htmlspecialchars($user['user_first_name']),
            'lastName' => htmlspecialchars($user['user_last_name']),
        ];
        echo "data: " . json_encode($response) . "\n\n";
    } else {
        echo "data: {}\n\n";
    }

    // Flush the output to the client
    ob_flush();
    flush();

    // Sleep for a short duration to avoid overloading the server
    sleep(2);
}
?>
