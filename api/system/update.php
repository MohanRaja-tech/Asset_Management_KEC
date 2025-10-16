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

    $sql = "UPDATE lab_inventory SET
            dept=?, lab_name=?, make_name=?, model_name=?, serial_no=?,
            processor=?, generation=?, ram_gb=?, primary_storage=?, secondary_storage=?,
            operating_system=?, gpu_name=?, monitor_type=?, monitor_size=?, monitor_serial=?,
            qty=?, cost=?, reg_no=?, p_no=?, dop=?, remarks=?
            WHERE id=?";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $input['dept'], $input['lab_name'], $input['make_name'], $input['model_name'],
        $input['serial_no'], $input['processor'], $input['generation'], $input['ram_gb'],
        $input['primary_storage'], $input['secondary_storage'], $input['operating_system'],
        $input['gpu_name'], $input['monitor_type'], $input['monitor_size'],
        $input['monitor_serial'], $input['qty'], $input['cost'], $input['reg_no'],
        $input['p_no'], $input['dop'], $input['remarks'], $input['id']
    ]);
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update system']);
    }
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
