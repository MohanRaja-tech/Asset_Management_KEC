<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');
try {
    $pdo = getDatabaseConnection();
    $input = json_decode(file_get_contents('php://input'), true) ?: [];
    if(!isset($input['id'])) { throw new Exception('Missing id'); }

    // Detect legacy 'size' column
    $hasRackSize = false; $hasSize = false;
    $cols = $pdo->query("SHOW COLUMNS FROM racks")->fetchAll(PDO::FETCH_COLUMN,0);
    foreach ($cols as $c) { if ($c==='rack_size') $hasRackSize = true; if ($c==='size') $hasSize = true; }

    $sizeColumn = $hasRackSize ? 'rack_size' : ($hasSize ? 'size' : 'rack_size');

    $sql = "UPDATE racks SET dept=?, lab_name=?, make=?, {$sizeColumn}=?, pdu=?, reg_no=?, page_no=?, price=?, dop=?, supplier_name=?, remarks=? WHERE id=?";
    $stmt = $pdo->prepare($sql);
    $rackSizeVal = $input['rack_size'] ?? ($input['size'] ?? null);
    $result = $stmt->execute([
        $input['dept'] ?? null,
        $input['lab_name'] ?? null,
        $input['make'] ?? null,
        $rackSizeVal,
        $input['pdu'] ?? null,
        $input['reg_no'] ?? null,
        $input['page_no'] ?? null,
        $input['price'] !== '' ? $input['price'] : null,
        !empty($input['dop']) ? $input['dop'] : null,
        $input['supplier_name'] ?? null,
        $input['remarks'] ?? null,
        $input['id']
    ]);

    echo json_encode(['success'=>$result]);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>'Database error: '.$e->getMessage()]);
}
