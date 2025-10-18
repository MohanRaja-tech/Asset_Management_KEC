<?php
// Include database configuration
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $pdo = getDatabaseConnection();
    
    $analytics = [];
    
    // Get overall totals
    $stmt = $pdo->query("SELECT COUNT(*) as count, SUM(COALESCE(CAST(cost AS DECIMAL(10,2)), 0)) as value FROM lab_inventory");
    $systemTotals = $stmt->fetch();
    
    $stmt = $pdo->query("SELECT COUNT(*) as count, SUM(COALESCE(CAST(cost AS DECIMAL(10,2)), 0)) as value FROM printers");
    $printerTotals = $stmt->fetch();
    
    $stmt = $pdo->query("SELECT COUNT(*) as count, SUM(COALESCE(CAST(price AS DECIMAL(10,2)), 0)) as value FROM switches");
    $switchTotals = $stmt->fetch();
    
    $stmt = $pdo->query("SELECT COUNT(*) as count, SUM(COALESCE(CAST(price AS DECIMAL(10,2)), 0)) as value FROM racks");
    $rackTotals = $stmt->fetch();
    
    $stmt = $pdo->query("SELECT COUNT(*) as count, SUM(COALESCE(CAST(cost AS DECIMAL(10,2)), 0)) as value FROM cameras");
    $cameraTotals = $stmt->fetch();
    
    // Get department summary for systems
    $stmt = $pdo->query("
        SELECT 
            dept,
            COUNT(*) as systems,
            SUM(COALESCE(CAST(cost AS DECIMAL(10,2)), 0)) as system_value
        FROM lab_inventory 
        GROUP BY dept
    ");
    $systemsByDept = $stmt->fetchAll();
    
    // Get department summary for printers
    $stmt = $pdo->query("
        SELECT 
            dept,
            COUNT(*) as printers,
            SUM(COALESCE(CAST(cost AS DECIMAL(10,2)), 0)) as printer_value
        FROM printers 
        GROUP BY dept
    ");
    $printersByDept = $stmt->fetchAll();
    
    // Get department summary for switches
    $stmt = $pdo->query("
        SELECT 
            dept,
            COUNT(*) as switches,
            SUM(COALESCE(CAST(price AS DECIMAL(10,2)), 0)) as switch_value
        FROM switches 
        GROUP BY dept
    ");
    $switchesByDept = $stmt->fetchAll();
    
    // Get department summary for racks
    $stmt = $pdo->query("
        SELECT 
            dept,
            COUNT(*) as racks,
            SUM(COALESCE(CAST(price AS DECIMAL(10,2)), 0)) as rack_value
        FROM racks 
        GROUP BY dept
    ");
    $racksByDept = $stmt->fetchAll();
    
    // Get department summary for cameras
    $stmt = $pdo->query("
        SELECT 
            building_block as dept,
            COUNT(*) as cameras,
            SUM(COALESCE(CAST(cost AS DECIMAL(10,2)), 0)) as camera_value
        FROM cameras 
        GROUP BY building_block
    ");
    $camerasByDept = $stmt->fetchAll();
    
    // Get recent activity (last 10 additions/updates)
    $stmt = $pdo->query("
        (SELECT 'System' as type, make_name as name, dept, created_at as date, 'added' as action FROM lab_inventory ORDER BY created_at DESC LIMIT 3)
        UNION ALL
        (SELECT 'Printer' as type, make as name, dept, created_at as date, 'added' as action FROM printers ORDER BY created_at DESC LIMIT 3)
        UNION ALL
        (SELECT 'Switch' as type, make as name, dept, created_at as date, 'added' as action FROM switches ORDER BY created_at DESC LIMIT 2)
        UNION ALL
        (SELECT 'Camera' as type, make as name, building_block as dept, created_at as date, 'added' as action FROM cameras ORDER BY created_at DESC LIMIT 2)
        ORDER BY date DESC LIMIT 10
    ");
    $recentActivity = $stmt->fetchAll();
    
    // Compile analytics data
    $analytics = [
        'totals' => [
            'systems' => (int)($systemTotals['count'] ?? 0),
            'printers' => (int)($printerTotals['count'] ?? 0),
            'switches' => (int)($switchTotals['count'] ?? 0),
            'racks' => (int)($rackTotals['count'] ?? 0),
            'cameras' => (int)($cameraTotals['count'] ?? 0),
            'total_value' => (float)($systemTotals['value'] ?? 0) + 
                           (float)($printerTotals['value'] ?? 0) + 
                           (float)($switchTotals['value'] ?? 0) + 
                           (float)($rackTotals['value'] ?? 0) + 
                           (float)($cameraTotals['value'] ?? 0)
        ],
        'by_department' => [
            'systems' => $systemsByDept,
            'printers' => $printersByDept,
            'switches' => $switchesByDept,
            'racks' => $racksByDept,
            'cameras' => $camerasByDept
        ],
        'recent_activity' => $recentActivity
    ];
    
    echo json_encode($analytics);
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['error' => 'Database error: ' . $e->getMessage()]);
}
?>
