<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');
try {
    $pdo = getDatabaseConnection();
    $stmt = $pdo->query("SELECT * FROM racks ORDER BY id ASC");
    echo json_encode($stmt->fetchAll());
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
