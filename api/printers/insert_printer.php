<?php
// Include database configuration
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $pdo = getDatabaseConnection();
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    $sql = "INSERT INTO printers (dept, lab_name, make, model, type, paper_size, cartridge_model, total_printers, cost, reg_no, p_no, dop, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    
    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $input['dept'],
        $input['lab_name'],
        $input['make'],
        $input['model'],
        $input['type'],
        $input['paper_size'],
        $input['cartridge_model'],
        $input['total_printers'],
        $input['cost'],
        $input['reg_no'],
        $input['p_no'],
        $input['dop'],
        $input['remarks']
    ]);
    
    if ($result) {
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to insert printer']);
    }
    
} catch(PDOException $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
