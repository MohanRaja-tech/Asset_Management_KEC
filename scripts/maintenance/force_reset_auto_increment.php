<?php
require_once 'config/database.php';

echo "Force Reset AUTO_INCREMENT\n";
echo "=========================\n\n";

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
        echo "Target AUTO_INCREMENT: $nextId\n\n";
        
        // Method 1: Try with explicit table engine
        echo "Method 1: ALTER TABLE with explicit settings...\n";
        try {
            $pdo->exec("ALTER TABLE switches ENGINE=InnoDB AUTO_INCREMENT=$nextId");
            echo "✅ Method 1 completed\n";
        } catch (Exception $e) {
            echo "❌ Method 1 failed: " . $e->getMessage() . "\n";
        }
        
        // Method 2: Try with table options
        echo "Method 2: ALTER TABLE with table options...\n";
        try {
            $pdo->exec("ALTER TABLE switches AUTO_INCREMENT=$nextId");
            echo "✅ Method 2 completed\n";
        } catch (Exception $e) {
            echo "❌ Method 2 failed: " . $e->getMessage() . "\n";
        }
        
        // Method 3: Check table structure
        echo "Method 3: Check table structure...\n";
        $stmt = $pdo->query("SHOW CREATE TABLE switches");
        $createTable = $stmt->fetch();
        echo "Table structure:\n" . $createTable['Create Table'] . "\n\n";
        
        // Method 4: Try to insert a test record and then delete it
        echo "Method 4: Insert/delete test record...\n";
        try {
            // Insert a test record
            $stmt = $pdo->prepare("INSERT INTO switches (dept, lab_name, make, model) VALUES (?, ?, ?, ?)");
            $stmt->execute(['TEST', 'Test Lab', 'Test Make', 'Test Model']);
            $testId = $pdo->lastInsertId();
            echo "Test record inserted with ID: $testId\n";
            
            // Delete the test record
            $stmt = $pdo->prepare("DELETE FROM switches WHERE id = ?");
            $stmt->execute([$testId]);
            echo "Test record deleted\n";
            
            // Check AUTO_INCREMENT again
            $stmt = $pdo->query("SHOW TABLE STATUS LIKE 'switches'");
            $result = $stmt->fetch();
            echo "AUTO_INCREMENT after test: " . $result['Auto_increment'] . "\n";
            
        } catch (Exception $e) {
            echo "❌ Method 4 failed: " . $e->getMessage() . "\n";
        }
        
        // Final check
        $stmt = $pdo->query("SHOW TABLE STATUS LIKE 'switches'");
        $result = $stmt->fetch();
        echo "\nFinal AUTO_INCREMENT value: " . $result['Auto_increment'] . "\n";
        
        if ($result['Auto_increment'] == $nextId) {
            echo "✅ AUTO_INCREMENT successfully reset to $nextId\n";
        } else {
            echo "❌ AUTO_INCREMENT reset failed. Still at " . $result['Auto_increment'] . "\n";
            echo "\nThis is actually normal MySQL behavior in many cases.\n";
            echo "The gaps in AUTO_INCREMENT are usually not a problem for applications.\n";
            echo "If you really need sequential IDs, consider using a different approach.\n";
        }
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
