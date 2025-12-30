<?php
include 'config.php';

// This file handles the return from Google/GitHub
// In a real OAuth flow, you'd exchange the $_GET['code'] for an access token
// Here is the conceptual logic for processing the user:

$provider = $_GET['provider'] ?? ''; // e.g. 'google' or 'github'
$social_id = $_GET['id'] ?? '';
$email = $_GET['email'] ?? '';
$name = $_GET['name'] ?? '';

if (!empty($social_id) && !empty($email)) {
    // 1. Check if user already exists
    $stmt = $conn->prepare("SELECT id, username FROM users WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($row = $result->fetch_assoc()) {
        // User exists -> Log them in
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['username'] = $row['username'];
    } else {
        // User doesn't exist -> Create account automatically
        $username = explode('@', $email)[0] . rand(10,99);
        $dummy_pass = password_hash(bin2hex(random_bytes(10)), PASSWORD_BCRYPT);
        
        $insert = $conn->prepare("INSERT INTO users (username, email, password, oauth_provider, oauth_id) VALUES (?, ?, ?, ?, ?)");
        $insert->bind_param("sssss", $username, $email, $dummy_pass, $provider, $social_id);
        $insert->execute();
        
        $_SESSION['user_id'] = $conn->insert_id;
        $_SESSION['username'] = $username;
    }

    header("Location: dashboard.php");
    exit;
} else {
    header("Location: login.php?error=oauth_failed");
    exit;
}
?>