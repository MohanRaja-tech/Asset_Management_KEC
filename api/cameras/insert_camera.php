<?php
// Include database configuration
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $pdo = getDatabaseConnection();
    
    $data = json_decode(file_get_contents("php://input"), true);
    if(!$data){ 
        http_response_code(400); 
        echo json_encode(['success' => false, 'error' => 'Invalid data']);
        exit;
    }

    $sql = "INSERT INTO cameras
            (building_block, location, make, model, type, pixel, qty, cost, reg_no, p_no, dop, remarks)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);
    
    $building_block = $data['building_block'] ?? null;
    $location = $data['location'] ?? null;
    $make = $data['make'] ?? null;
    $model = $data['model'] ?? null;
    $type = $data['type'] ?? null;
    $pixel = $data['pixel'] ?? null;
    $qty = isset($data['qty']) ? (int)$data['qty'] : 1;
    $cost = isset($data['cost']) ? (float)$data['cost'] : 0.0;
    $reg_no = $data['reg_no'] ?? null;
    $p_no = $data['p_no'] ?? null;
    $dop = $data['dop'] ?? null;
    $remarks = $data['remarks'] ?? null;

    $result = $stmt->execute([
        $building_block, $location, $make, $model, $type, $pixel,
        $qty, $cost, $reg_no, $p_no, $dop, $remarks
    ]);

    if ($result) {
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to insert camera']);
    }
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>