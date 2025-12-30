<?php
/**
 * NEXUS Phonebook System - Configuration
 * This file handles database connectivity, session security, and global helpers.
 */

// Prevent multiple inclusion of the config file
if (defined('CONFIG_LOADED')) return;
define('CONFIG_LOADED', true);

// Start the session to track logged-in users across the application
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database Credentials
$servername = "localhost";
$username = "school_admin";
$password = "cAqrXpN/6tyh0reS";
$dbname = "phonebook_db";

// Create Connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check Connection
if ($conn->connect_error) {
    die("Database Connection failed: " . $conn->connect_error);
}

/**
 * SECURITY HELPER: protect_page()
 * Redirects unauthorized users to the login page.
 * Usage: Call this at the top of any page that requires a login.
 */
if (!function_exists('protect_page')) {
    function protect_page() {
        if (!isset($_SESSION['user_id'])) {
            header("Location: login.php");
            exit;
        }
    }
}

/**
 * UTILITY: log_activity()
 * Records system actions into the activity_log table for auditing.
 */
if (!function_exists('log_activity')) {
    function log_activity($action_type, $details) {
        global $conn;
        $details = substr($details, 0, 1000); // Limit detail length
        $stmt = $conn->prepare("INSERT INTO activity_log (action_type, details) VALUES (?, ?)");
        if ($stmt) {
            $stmt->bind_param("ss", $action_type, $details);
            $stmt->execute();
            $stmt->close();
        }
    }
}

function log_activity($type, $details, $severity = 'info') {
    global $conn;
    $stmt = $conn->prepare("INSERT INTO activity_log (action_type, details, severity) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $type, $details, $severity);
    $stmt->execute();
    $stmt->close();
}
?>