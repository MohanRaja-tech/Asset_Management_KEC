<?php
/**
 * Migration: Add missing columns to racks table (idempotent)
 * Run: php ./database/migrations/20251005_add_columns_to_racks.php
 */
require_once __DIR__ . '/../../config/database.php';

try {
    $pdo = getDatabaseConnection();

    // Collect existing columns
    $existing = [];
    $stmt = $pdo->query("SHOW TABLES LIKE 'racks'");
    if ($stmt->rowCount() === 0) {
        echo "Table 'racks' does not exist. Run create_racks_table.php first.\n";
        exit; 
    }

    $cols = $pdo->query("SHOW COLUMNS FROM racks")->fetchAll(PDO::FETCH_ASSOC);
    foreach ($cols as $c) { $existing[$c['Field']] = true; }

    $alterStatements = [];

    // Define desired columns in order (column => DDL fragment)
    $desired = [
        'dept'          => "ADD COLUMN dept VARCHAR(100) NULL AFTER id",
        'lab_name'      => "ADD COLUMN lab_name VARCHAR(150) NULL AFTER dept",
        'make'          => "ADD COLUMN make VARCHAR(150) NULL AFTER lab_name",
        'rack_size'     => "ADD COLUMN rack_size VARCHAR(50) NULL AFTER make",
        'pdu'           => "ADD COLUMN pdu VARCHAR(150) NULL AFTER rack_size",
        'reg_no'        => "ADD COLUMN reg_no VARCHAR(100) NULL AFTER pdu",
        'page_no'       => "ADD COLUMN page_no VARCHAR(50) NULL AFTER reg_no",
        'price'         => "ADD COLUMN price DECIMAL(12,2) NULL AFTER page_no",
        'dop'           => "ADD COLUMN dop DATE NULL AFTER price",
        'supplier_name' => "ADD COLUMN supplier_name VARCHAR(200) NULL AFTER dop",
        'remarks'       => "ADD COLUMN remarks TEXT NULL AFTER supplier_name",
        'created_at'    => "ADD COLUMN created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP AFTER remarks"
    ];

    foreach ($desired as $col => $ddl) {
        if (!isset($existing[$col])) {
            $alterStatements[] = $ddl;
        }
    }

    if (empty($alterStatements)) {
        echo "No changes needed. All expected columns already exist.\n";
        exit;
    }

    $sql = "ALTER TABLE racks \n  " . implode(",\n  ", $alterStatements) . ";";
    $pdo->exec($sql);

    echo "Added columns: " . implode(', ', array_keys(array_filter($desired, fn($v,$k)=>!isset($existing[$k]), ARRAY_FILTER_USE_BOTH))) . "\n";
    echo "Migration completed successfully.\n";
} catch (Exception $e) {
    http_response_code(500);
    echo "Migration failed: " . $e->getMessage() . "\n";
}
