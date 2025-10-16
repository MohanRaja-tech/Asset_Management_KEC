<?php
// Include database configuration
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $pdo = getDatabaseConnection();
    
    $stmt = $pdo->query("SELECT * FROM lab_inventory ORDER BY id ASC");
    $data = $stmt->fetchAll();
    
    echo json_encode($data);
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}
?>
