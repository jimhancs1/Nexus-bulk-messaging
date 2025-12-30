<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
require_once 'config.php';
protect_page();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = trim($_POST['name']);
    $content = trim($_POST['content']);

    if (!empty($name) && !empty($content)) {
        $stmt = $conn->prepare("INSERT INTO templates (name, content) VALUES (?, ?)");
        $stmt->bind_param("ss", $name, $content);

        if ($stmt->execute()) {
            // Audit trail
            log_activity('template_create', "Created message template: $name");
            
            header("Location: templates.php?status=success");
        } else {
            header("Location: templates.php?status=db_error");
        }
        $stmt->close();
    } else {
        header("Location: templates.php?status=missing_fields");
    }
    exit;
} else {
    header("Location: templates.php");
    exit;
}
?>