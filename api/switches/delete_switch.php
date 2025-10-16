<?php
// Include database configuration
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $pdo = getDatabaseConnection();
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    $sql = "DELETE FROM switches WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$input['id']]);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete switch']);
    }
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
