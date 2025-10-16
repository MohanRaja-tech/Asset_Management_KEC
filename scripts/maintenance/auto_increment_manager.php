<?php
require_once 'config/database.php';

/**
 * AUTO_INCREMENT Manager for Asset Management System
 * 
 * This class provides utilities to manage AUTO_INCREMENT gaps
 * and maintain clean ID sequences across tables.
 */
class AutoIncrementManager {
    private $pdo;
    
    public function __construct() {
        $this->pdo = getDatabaseConnection();
    }
    
    /**
     * Get AUTO_INCREMENT status for a table
     */
    public function getAutoIncrementStatus($tableName) {
        $stmt = $this->pdo->query("SHOW TABLE STATUS LIKE '$tableName'");
        $result = $stmt->fetch();
        
        $stmt = $this->pdo->query("SELECT id FROM $tableName ORDER BY id");
        $ids = $stmt->fetchAll(PDO::FETCH_COLUMN);
        
        $gaps = [];
        if (count($ids) > 0) {
            for ($i = 1; $i < $result['Auto_increment']; $i++) {
                if (!in_array($i, $ids)) {
                    $gaps[] = $i;
                }
            }
        }
        
        return [
            'table' => $tableName,
            'current_auto_increment' => $result['Auto_increment'],
            'existing_ids' => $ids,
            'gaps' => $gaps,
            'gap_count' => count($gaps),
            'next_logical_id' => count($ids) > 0 ? max($ids) + 1 : 1
        ];
    }
    
    /**
     * Reset AUTO_INCREMENT to next logical ID
     */
    public function resetAutoIncrement($tableName) {
        $status = $this->getAutoIncrementStatus($tableName);
        $nextId = $status['next_logical_id'];
        
        $this->pdo->exec("ALTER TABLE $tableName AUTO_INCREMENT = $nextId");
        
        return [
            'success' => true,
            'old_auto_increment' => $status['current_auto_increment'],
            'new_auto_increment' => $nextId,
            'gaps_removed' => $status['gap_count']
        ];
    }
    
    /**
     * Check if AUTO_INCREMENT needs resetting
     */
    public function needsReset($tableName, $threshold = 5) {
        $status = $this->getAutoIncrementStatus($tableName);
        return $status['gap_count'] >= $threshold;
    }
    
    /**
     * Get status for all tables
     */
    public function getAllTablesStatus() {
        $tables = ['switches', 'printers', 'systems'];
        $results = [];
        
        foreach ($tables as $table) {
            try {
                $results[$table] = $this->getAutoIncrementStatus($table);
            } catch (Exception $e) {
                $results[$table] = ['error' => $e->getMessage()];
            }
        }
        
        return $results;
    }
}

// Usage example
echo "AUTO_INCREMENT Manager\n";
echo "=====================\n\n";

try {
    $manager = new AutoIncrementManager();
    
    // Get status for all tables
    $allStatus = $manager->getAllTablesStatus();
    
    foreach ($allStatus as $table => $status) {
        if (isset($status['error'])) {
            echo "❌ $table: " . $status['error'] . "\n";
            continue;
        }
        
        echo "📊 $table:\n";
        echo "   Current AUTO_INCREMENT: " . $status['current_auto_increment'] . "\n";
        echo "   Existing IDs: " . implode(', ', $status['existing_ids']) . "\n";
        echo "   Gaps: " . $status['gap_count'] . " (IDs: " . implode(', ', $status['gaps']) . ")\n";
        echo "   Next logical ID: " . $status['next_logical_id'] . "\n";
        
        if ($manager->needsReset($table)) {
            echo "   ⚠️  Needs reset (gaps >= 5)\n";
        } else {
            echo "   ✅ OK\n";
        }
        echo "\n";
    }
    
    // Example: Reset switches table if needed
    if ($manager->needsReset('switches')) {
        echo "Resetting switches AUTO_INCREMENT...\n";
        $result = $manager->resetAutoIncrement('switches');
        echo "✅ Reset completed:\n";
        echo "   Old value: " . $result['old_auto_increment'] . "\n";
        echo "   New value: " . $result['new_auto_increment'] . "\n";
        echo "   Gaps removed: " . $result['gaps_removed'] . "\n";
    }
    
} catch (Exception $e) {
    echo "❌ Error: " . $e->getMessage() . "\n";
}
?>
