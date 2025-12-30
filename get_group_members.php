<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
include 'config.php';
$group_id = $_GET['group_id'];
$result = $conn->query("SELECT c.* FROM contacts c JOIN group_members gm ON c.id = gm.contact_id WHERE gm.group_id = $group_id");
$members = [];
while ($row = $result->fetch_assoc()) $members[] = $row;
echo json_encode($members);
?>