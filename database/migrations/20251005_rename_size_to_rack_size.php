<?php
/**
 * Migration: Rename legacy 'size' column to 'rack_size' if present (and 'rack_size' missing)
 * Run: php database/migrations/20251005_rename_size_to_rack_size.php
 */
require_once __DIR__ . '/../../config/database.php';

try {
    $pdo = getDatabaseConnection();

    $check = $pdo->query("SHOW TABLES LIKE 'racks'");
    if ($check->rowCount() === 0) {
        echo "Table 'racks' does not exist. Run create_racks_table.php first.\n";
        exit; 
    }

    $cols = $pdo->query("SHOW COLUMNS FROM racks")->fetchAll(PDO::FETCH_COLUMN,0);
    $hasSize = in_array('size',$cols,true);
    $hasRackSize = in_array('rack_size',$cols,true);

    if ($hasRackSize && !$hasSize) {
        echo "Already normalized (rack_size present, no legacy size).\n";
        exit;
    }
    if (!$hasSize && !$hasRackSize) {
        echo "Neither 'size' nor 'rack_size' exists. Nothing to do.\n";
        exit;
    }
    if ($hasRackSize && $hasSize) {
        echo "Both 'size' and 'rack_size' exist. Consider manual data merge then drop 'size'.\n";
        exit;
    }

    if ($hasSize && !$hasRackSize) {
        echo "Renaming column 'size' -> 'rack_size' ...\n";
        $pdo->exec("ALTER TABLE racks CHANGE COLUMN size rack_size VARCHAR(50) NULL");
        echo "Rename complete.\n";
    }

} catch (Exception $e) {
    http_response_code(500);
    echo "Rename migration failed: " . $e->getMessage() . "\n";
}
