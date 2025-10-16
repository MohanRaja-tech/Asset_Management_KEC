<?php
// Include database configuration
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $pdo = getDatabaseConnection();
    
    // Return rows in insertion order (by primary key)
    $stmt = $pdo->query("SELECT * FROM printers ORDER BY id ASC");
    $printers = $stmt->fetchAll();
    
    echo json_encode($printers);
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database connection failed: ' . $e->getMessage()]);
}
?>
