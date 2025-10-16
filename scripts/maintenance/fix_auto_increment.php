<?php
require_once 'config/database.php';

echo "Fixing AUTO_INCREMENT gaps in switches table...\n";
echo "==============================================\n\n";

try {
    $pdo = getDatabaseConnection();
    
    // Get current state
    $stmt = $pdo->query("SELECT id FROM switches ORDER BY id");
    $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Current IDs: " . implode(', ', $ids) . "\n";
    
    if (count($ids) > 0) {
        $maxId = max($ids);
        $nextId = $maxId + 1;
        
        echo "Max existing ID: $maxId\n";
        echo "Next logical ID should be: $nextId\n";
        
        // Reset AUTO_INCREMENT to next logical ID
        $pdo->exec("ALTER TABLE switches AUTO_INCREMENT = $nextId");
        
        echo "✅ AUTO_INCREMENT reset to $nextId\n";
        
        // Verify the change
        $stmt = $pdo->query("SHOW TABLE STATUS LIKE 'switches'");
        $result = $stmt->fetch();
        echo "New AUTO_INCREMENT value: " . $result['Auto_increment'] . "\n";
        
    } else {
        echo "No records found. Resetting AUTO_INCREMENT to 1.\n";
        $pdo->exec("ALTER TABLE switches AUTO_INCREMENT = 1");
    }
    
    echo "\n✅ AUTO_INCREMENT fix completed!\n";
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
