<?php
require_once 'config/database.php';

echo "Checking AUTO_INCREMENT status for switches table...\n";
echo "================================================\n\n";

try {
    $pdo = getDatabaseConnection();
    
    // Check current AUTO_INCREMENT value
    $stmt = $pdo->query("SHOW TABLE STATUS LIKE 'switches'");
    $result = $stmt->fetch();
    echo "Current AUTO_INCREMENT value: " . $result['Auto_increment'] . "\n";
    
    // Get all existing IDs
    $stmt = $pdo->query("SELECT id FROM switches ORDER BY id");
    $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Existing IDs: " . implode(', ', $ids) . "\n";
    
    // Check for gaps
    $gaps = [];
    for ($i = 1; $i < $result['Auto_increment']; $i++) {
        if (!in_array($i, $ids)) {
            $gaps[] = $i;
        }
    }
    
    if (count($gaps) > 0) {
        echo "Gaps in ID sequence: " . implode(', ', $gaps) . "\n";
        echo "Total gaps: " . count($gaps) . "\n";
    } else {
        echo "No gaps in ID sequence.\n";
    }
    
    echo "\nNext new record will get ID: " . $result['Auto_increment'] . "\n";
    
} catch (Exception $e) {
    echo "Error: " . $e->getMessage() . "\n";
}
?>
