<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';
echo $conn->query("SELECT COUNT(*) FROM contacts")->fetch_row()[0];
?>