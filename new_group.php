<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';
protect_page(); // Ensure only logged-in users can create groups

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $description = trim($_POST['description']);

    if (!empty($name)) {
        // Prepare SQL to prevent injection
        $stmt = $conn->prepare("INSERT INTO groups (name, description) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $description);

        if ($stmt->execute()) {
            // Log the action in the activity log
            log_activity('group_create', "Created a new group: $name");
            
            // Redirect with success flag
            header("Location: groups.php?status=created");
        } else {
            header("Location: groups.php?status=error");
        }
        $stmt->close();
    } else {
        header("Location: groups.php?status=invalid");
    }
    exit;
} else {
    // If someone tries to access this file directly without POST
    header("Location: groups.php");
    exit;
}
?>