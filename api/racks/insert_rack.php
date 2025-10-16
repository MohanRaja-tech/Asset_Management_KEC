<?php
require_once __DIR__ . '/../../config/database.php';
header('Content-Type: application/json');
try {
    $pdo = getDatabaseConnection();
    $input = json_decode(file_get_contents('php://input'), true) ?: [];

    // Normalize empty strings to null (but keep for validation first)
    foreach ($input as $k => $v) {
        if (is_string($v)) {
            $trim = trim($v);
            if ($trim === '') { $input[$k] = null; } else { $input[$k] = $trim; }
        }
    }

    // Basic required field validation (adjust as needed)
    $required = ['dept','make'];
    $missing = [];
    foreach ($required as $r) { if (!isset($input[$r]) || $input[$r] === null) $missing[] = $r; }
    if ($missing) {
        echo json_encode(['success'=>false,'error'=>'Missing required fields: '.implode(', ',$missing)]);
        return;
    }

    // Safety fallback: ensure 'make' not null even if DB unexpectedly enforces NOT NULL
    if ($input['make'] === null) { $input['make'] = 'Unknown'; }

    // Desired column order (matches current UI)
    $desiredCols = [
        'dept','lab_name','make','rack_size','pdu','reg_no','page_no','price','dop','supplier_name','remarks'
    ];

    // Fetch actual columns from DB to avoid unknown column errors if schema is outdated
    $existingCols = [];
    $colsStmt = $pdo->query("SHOW COLUMNS FROM racks");
    $columnMeta = $colsStmt->fetchAll(PDO::FETCH_ASSOC);
    $existingCols = [];
    $notNullNoDefault = [];
    foreach ($columnMeta as $col) {
        $existingCols[$col['Field']] = true;
        $isNotNull = (strtoupper($col['Null']) === 'NO');
        $hasDefault = ($col['Default'] !== null);
        if ($isNotNull && !$hasDefault && $col['Field'] !== 'id') {
            $notNullNoDefault[$col['Field']] = true; // track problematic columns
        }
    }

    // Auto-heal: if critical first column missing, attempt to create full schema additions
    $critical = ['dept','lab_name','make'];
    $needsAlter = false;
    foreach ($critical as $c) {
        if (!isset($existingCols[$c])) { $needsAlter = true; break; }
    }
    if ($needsAlter) {
        // Attempt to add missing columns (best-effort, ignore failures)
        $additions = [
            'dept VARCHAR(100) NULL',
            'lab_name VARCHAR(150) NULL',
            'make VARCHAR(150) NULL',
            'rack_size VARCHAR(50) NULL',
            'pdu VARCHAR(150) NULL',
            'reg_no VARCHAR(100) NULL',
            'page_no VARCHAR(50) NULL',
            'price DECIMAL(12,2) NULL',
            'dop DATE NULL',
            'supplier_name VARCHAR(200) NULL',
            'remarks TEXT NULL'
        ];
        $toAdd = [];
        foreach ($additions as $def) {
            $name = strtok($def,' ');
            if (!isset($existingCols[$name])) { $toAdd[] = 'ADD COLUMN '.$def; }
        }
        if ($toAdd) {
            try { $pdo->exec('ALTER TABLE racks ' . implode(', ', $toAdd)); } catch (Exception $e) { /* ignore */ }
            // Re-read columns
            $existingCols = [];
            $colsStmt = $pdo->query("SHOW COLUMNS FROM racks");
            $columnMeta = $colsStmt->fetchAll(PDO::FETCH_ASSOC);
            $existingCols = [];
            $notNullNoDefault = [];
            foreach ($columnMeta as $col) {
                $existingCols[$col['Field']] = true;
                $isNotNull = (strtoupper($col['Null']) === 'NO');
                $hasDefault = ($col['Default'] !== null);
                if ($isNotNull && !$hasDefault && $col['Field'] !== 'id') {
                    $notNullNoDefault[$col['Field']] = true;
                }
            }
        }
    }

    // Support legacy schema where column was named 'size' instead of 'rack_size'
    $aliasMap = [];
    if (!isset($existingCols['rack_size']) && isset($existingCols['size'])) {
        $aliasMap['rack_size'] = 'size';
        // If input has rack_size but DB expects size ensure we keep value
        if (!isset($input['rack_size']) && isset($input['size'])) {
            $input['rack_size'] = $input['size'];
        }
    }

    // Filter to logical columns that have a physical column (direct or alias)
    $finalLogicalCols = [];
    $finalPhysicalCols = [];
    foreach ($desiredCols as $logical) {
        $physical = $aliasMap[$logical] ?? $logical;
        if (isset($existingCols[$physical])) {
            $finalLogicalCols[] = $logical;
            $finalPhysicalCols[] = $physical;
        }
    }

    if (empty($finalPhysicalCols)) {
        throw new Exception("No matching columns in racks table. Schema mismatch.");
    }

    $placeholders = rtrim(str_repeat('?,', count($finalPhysicalCols)), ',');
    $sql = "INSERT INTO racks (" . implode(',', $finalPhysicalCols) . ") VALUES ($placeholders)";
    $stmt = $pdo->prepare($sql);
    $values = [];
    foreach ($finalLogicalCols as $logical) {
        $val = $input[$logical] ?? null;
        if ($logical === 'price' && $val !== null) {
            $val = is_numeric($val) ? $val : null;
        } elseif ($logical === 'dop' && !empty($val)) {
            $date = date_create($val); $val = $date ? $date->format('Y-m-d') : null;
        }
        // Provide safe placeholder if physical column is NOT NULL without default and value is null
        $physical = $aliasMap[$logical] ?? $logical;
        if ($val === null && isset($notNullNoDefault[$physical])) {
            // Minimal placeholder per type guess: use 'N/A' for text-ish, 0 for numeric, 0000-00-00 avoided (use current date for DATE)
            if (in_array($physical, ['price'])) {
                $val = 0;
            } elseif ($physical === 'dop') {
                $val = date('Y-m-d');
            } else {
                $val = 'N/A';
            }
        }
        $values[] = $val;
    }

    $result = $stmt->execute($values);

    if ($result) {
        echo json_encode([
            'success' => true,
            'id' => $pdo->lastInsertId(),
            'used_columns_physical' => $finalPhysicalCols,
            'column_alias_map' => $aliasMap,
            'not_null_no_default_columns' => array_keys($notNullNoDefault)
        ]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Insert failed']);
    }
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success'=>false,'error'=>'Database error: '.$e->getMessage()]);
}
