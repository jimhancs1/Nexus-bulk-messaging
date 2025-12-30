<?php
// Africa's Talking sends data as POST
$status  = $_POST['status'];
$messageId = $_POST['id'];
$phoneNumber = $_POST['phoneNumber'];

// Log this to a file or your database to verify it's working
$log = "ID: $messageId | Phone: $phoneNumber | Status: $status" . PHP_EOL;
file_put_contents('sms_logs.txt', $log, FILE_APPEND);
?>