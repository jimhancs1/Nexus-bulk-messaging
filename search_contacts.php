<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
// search_contacts.php - AJAX endpoint for live contact search
include 'config.php';
protect_page(); // Redirects to login.php if not logged in

header('Content-Type: application/json');

$query = $_GET['q'] ?? '';
$query = trim($query);

if (strlen($query) < 2) {
    echo json_encode([]);
    exit;
}

// Search in name, phone, email
$stmt = $conn->prepare("
    SELECT id, name, phone, email 
    FROM contacts 
    WHERE name LIKE ? 
       OR phone LIKE ? 
       OR email LIKE ? 
    ORDER BY name 
    LIMIT 10
");

$searchTerm = "%$query%";
$stmt->bind_param("sss", $searchTerm, $searchTerm, $searchTerm);
$stmt->execute();
$result = $stmt->get_result();

$contacts = [];
while ($row = $result->fetch_assoc()) {
    $contacts[] = [
        'id' => $row['id'],
        'name' => htmlspecialchars($row['name']),
        'phone' => htmlspecialchars($row['phone']),
        'email' => $row['email'] ? htmlspecialchars($row['email']) : ''
    ];
}

echo json_encode($contacts);
?>