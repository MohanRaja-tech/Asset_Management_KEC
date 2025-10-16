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

    $sql = "INSERT INTO lab_inventory
            (dept, lab_name, make_name, model_name, serial_no,
             processor, generation, ram_gb, primary_storage, secondary_storage,
             operating_system, gpu_name, monitor_type, monitor_size, monitor_serial,
             qty, cost, reg_no, p_no, dop, remarks)
            VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

    $stmt = $pdo->prepare($sql);
    
    $dept = $data['dept'] ?? null;
    $lab_name = $data['lab_name'] ?? null;
    $make_name = $data['make_name'] ?? null;
    $model_name = $data['model_name'] ?? null;
    $serial_no = $data['serial_no'] ?? null;
    $processor = $data['processor'] ?? null;
    $generation = $data['generation'] ?? null;
    $ram_gb = $data['ram_gb'] ?? null;
    $primary_storage = $data['primary_storage'] ?? null;
    $secondary_storage = $data['secondary_storage'] ?? null;
    $operating_system = $data['operating_system'] ?? null;
    $gpu_name = $data['gpu_name'] ?? null;
    $monitor_type = $data['monitor_type'] ?? null;
    $monitor_size = $data['monitor_size'] ?? null;
    $monitor_serial = $data['monitor_serial'] ?? null;
    $qty = isset($data['qty']) ? (int)$data['qty'] : 0;
    $cost = isset($data['cost']) ? (float)$data['cost'] : 0.0;
    $reg_no = $data['reg_no'] ?? null;
    $p_no = $data['p_no'] ?? null;
    $dop = $data['dop'] ?? null;
    $remarks = $data['remarks'] ?? null;

    $result = $stmt->execute([
        $dept, $lab_name, $make_name, $model_name, $serial_no,
        $processor, $generation, $ram_gb, $primary_storage, $secondary_storage,
        $operating_system, $gpu_name, $monitor_type, $monitor_size, $monitor_serial,
        $qty, $cost, $reg_no, $p_no, $dop, $remarks
    ]);
    
    if ($result) {
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to insert system']);
    }
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
