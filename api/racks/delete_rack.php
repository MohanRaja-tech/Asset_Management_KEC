<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');
try {
    $pdo = getDatabaseConnection();
    $input = json_decode(file_get_contents('php://input'), true) ?: [];
    if(!isset($input['id'])) { throw new Exception('Missing id'); }
    $stmt = $pdo->prepare('DELETE FROM racks WHERE id = ?');
    $result = $stmt->execute([$input['id']]);
    echo json_encode(['success'=>$result]);
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>'Database error: '.$e->getMessage()]);
}
