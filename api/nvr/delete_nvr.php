<?php
// Include database configuration
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $pdo = getDatabaseConnection();
    
    $data = json_decode(file_get_contents("php://input"), true);
    if(!$data || !isset($data['id'])){ 
        http_response_code(400); 
        echo json_encode(['success' => false, 'error' => 'Invalid data or missing ID']);
        exit;
    }

    $sql = "DELETE FROM nvr WHERE id = ?";
    $stmt = $pdo->prepare($sql);
    
    $result = $stmt->execute([(int)$data['id']]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete NVR']);
    }
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
