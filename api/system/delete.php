<?php
// Include database configuration
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $pdo = getDatabaseConnection();
    
    $input = json_decode(file_get_contents("php://input"), true);
    if (!$input || !isset($input['id'])) { 
        http_response_code(400); 
        echo json_encode(['success' => false, 'error' => 'Bad input']);
        exit;
    }

    $sql = "DELETE FROM lab_inventory WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([$input['id']]);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to delete system']);
    }
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
