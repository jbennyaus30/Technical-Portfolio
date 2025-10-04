<?php
session_start();
require_once '../config.php'; // Include configuration file

// Destroy all session data
session_unset();
session_destroy();

// Redirect to the login page
header('Location: ' . BASE_URL . 'admin/index.php');
exit();
?>
