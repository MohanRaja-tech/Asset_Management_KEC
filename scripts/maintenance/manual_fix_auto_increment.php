<?php
require_once 'config/database.php';

echo "Manual AUTO_INCREMENT Fix\n";
echo "========================\n\n";

try {
    $pdo = getDatabaseConnection();
    
    // Check MySQL version
    $stmt = $pdo->query("SELECT VERSION()");
    $version = $stmt->fetchColumn();
    echo "MySQL Version: $version\n\n";
    
    // Get current state
    $stmt = $pdo->query("SELECT id FROM switches ORDER BY id");
    $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
    echo "Current IDs: " . implode(', ', $ids) . "\n";
    
    $stmt = $pdo->query("SHOW TABLE STATUS LIKE 'switches'");
    $result = $stmt->fetch();
    echo "Current AUTO_INCREMENT: " . $result['Auto_increment'] . "\n";
    
    if (count($ids) > 0) {
        $maxId = max($ids);
        $nextId = $maxId + 1;
        
        echo "Max existing ID: $maxId\n";
        echo "Next logical ID: $nextId\n\n";
        
        // Try different approaches
        echo "Attempting to reset AUTO_INCREMENT...\n";
        
        // Method 1: Direct ALTER TABLE
        try {
            $pdo->exec("ALTER TABLE switches AUTO_INCREMENT = $nextId");
            echo "✅ Method 1 (ALTER TABLE) succeeded\n";
        } catch (Exception $e) {
            echo "❌ Method 1 failed: " . $e->getMessage() . "\n";
        }
        
        // Method 2: Using SET
        try {
            $pdo->exec("SET @auto_increment_offset = $nextId");
            $pdo->exec("ALTER TABLE switches AUTO_INCREMENT = $nextId");
            echo "✅ Method 2 (SET + ALTER) succeeded\n";
        } catch (Exception $e) {
            echo "❌ Method 2 failed: " . $e->getMessage() . "\n";
        }
        
        // Method 3: Check if we have the right permissions
        try {
            $stmt = $pdo->query("SHOW GRANTS");
            $grants = $stmt->fetchAll(PDO::FETCH_COLUMN);
            echo "Database grants:\n";
            foreach ($grants as $grant) {
                echo "  $grant\n";
            }
        } catch (Exception $e) {
            echo "❌ Could not check grants: " . $e->getMessage() . "\n";
        }
        
        // Verify final state
        $stmt = $pdo->query("SHOW TABLE STATUS LIKE 'switches'");
        $result = $stmt->fetch();
        echo "\nFinal AUTO_INCREMENT value: " . $result['Auto_increment'] . "\n";
        
        if ($result['Auto_increment'] == $nextId) {
            echo "✅ AUTO_INCREMENT successfully reset to $nextId\n";
        } else {
            echo "❌ AUTO_INCREMENT reset failed. Still at " . $result['Auto_increment'] . "\n";
            echo "This might be due to:\n";
            echo "1. Insufficient permissions\n";
            echo "2. MySQL version compatibility\n";
            echo "3. Table locks or constraints\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
