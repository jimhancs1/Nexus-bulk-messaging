<?php
require_once 'config.php';
require_once 'vendor/autoload.php';

// Fetch messages where scheduled time has passed and status is pending
$now = date('Y-m-d H:i:s');
$query = "SELECT * FROM sent_messages WHERE status = 'pending' AND scheduled_at <= '$now'";
$result = $conn->query($query);

while ($row = $result->fetch_assoc()) {
    $recipients = explode(',', $row['recipients']);
    $channel = $row['channel'];
    $msg = $row['message_content'];

    try {
        if ($channel === 'sms') {
            // AT Logic
        } elseif ($channel === 'email') {
            // PHPMailer Logic
        } elseif ($channel === 'whatsapp') {
            // Twilio Logic
        }

        // Mark as sent
        $conn->query("UPDATE sent_messages SET status = 'sent' WHERE id = " . $row['id']);
    } catch (Exception $e) {
        $conn->query("UPDATE sent_messages SET status = 'failed' WHERE id = " . $row['id']);
    }
}