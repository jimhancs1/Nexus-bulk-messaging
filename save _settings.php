<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $system_name = $conn->real_escape_string($_POST['system_name']);
    $admin_email = $conn->real_escape_string($_POST['admin_email']);
    $timezone = $conn->real_escape_string($_POST['timezone']);

    // Check if a row exists, update if it does, insert if it doesn't
    $check = $conn->query("SELECT id FROM system_settings LIMIT 1");
    
    if ($check->num_rows > 0) {
        $sql = "UPDATE system_settings SET 
                system_name = '$system_name', 
                admin_email = '$admin_email', 
                timezone = '$timezone' 
                WHERE id = 1";
    } else {
        $sql = "INSERT INTO system_settings (system_name, admin_email, timezone) 
                VALUES ('$system_name', '$admin_email', '$timezone')";
    }

    if ($conn->query($sql)) {
        echo "<script>alert('Settings saved successfully!'); window.location.href='dashboard.php';</script>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>