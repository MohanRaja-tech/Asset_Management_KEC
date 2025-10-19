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

    $sql = "UPDATE nvr SET 
            building_block = ?,
            location = ?,
            make = ?,
            model = ?,
            serial_no = ?,
            hdd_2tb_qty = ?,
            hdd_4tb_qty = ?,
            hdd_6tb_qty = ?,
            hdd_8tb_qty = ?,
            type = ?,
            qty = ?,
            cost = ?,
            reg_no = ?,
            page_no = ?,
            dop = ?,
            remarks = ?
            WHERE id = ?";

    $stmt = $pdo->prepare($sql);
    
    $building_block = $data['building_block'] ?? null;
    $location = $data['location'] ?? null;
    $make = $data['make'] ?? null;
    $model = $data['model'] ?? null;
    $serial_no = $data['serial_no'] ?? null;
    $hdd_2tb_qty = isset($data['hdd_2tb_qty']) ? (int)$data['hdd_2tb_qty'] : 0;
    $hdd_4tb_qty = isset($data['hdd_4tb_qty']) ? (int)$data['hdd_4tb_qty'] : 0;
    $hdd_6tb_qty = isset($data['hdd_6tb_qty']) ? (int)$data['hdd_6tb_qty'] : 0;
    $hdd_8tb_qty = isset($data['hdd_8tb_qty']) ? (int)$data['hdd_8tb_qty'] : 0;
    $type = $data['type'] ?? null;
    $qty = isset($data['qty']) ? (int)$data['qty'] : 1;
    $cost = isset($data['cost']) ? (float)$data['cost'] : 0.0;
    $reg_no = $data['reg_no'] ?? null;
    $page_no = $data['page_no'] ?? null;
    $dop = $data['dop'] ?? null;
    $remarks = $data['remarks'] ?? null;
    $id = (int)$data['id'];

    $result = $stmt->execute([
        $building_block, $location, $make, $model, $serial_no,
        $hdd_2tb_qty, $hdd_4tb_qty, $hdd_6tb_qty, $hdd_8tb_qty,
        $type, $qty, $cost, $reg_no, $page_no, $dop, $remarks, $id
    ]);

    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update NVR']);
    }
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
