<?php
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $pdo = getDatabaseConnection();
    $input = json_decode(file_get_contents('php://input'), true);

    error_log("Switch insert data: " . json_encode($input));

    // Ensure all expected fields exist
    $fields = [
        'dept', 'lab_name', 'make', 'model', 'serial_number',
        'poe_type', 'access_port', 't_ports_count', 't_ports_speed',
        'sfp_ports_count', 'sfp_ports_speed', 'uplink_sfp_ports_count',
        'uplink_sfp_ports_speed', 'reg_no', 'page_no', 'qty', 'price',
        'dop', 'supplier_name', 'switch_ip', 'remarks'
    ];
    foreach ($fields as $field) {
        if (!isset($input[$field])) $input[$field] = null;
    }

    // Validate PoE field
    $poe_type = 'Non-PoE';
    if (isset($input['poe_type'])) {
        $received = trim($input['poe_type']);
        if (in_array($received, ['PoE', 'Non-PoE'])) {
            $poe_type = $received;
        }
    }
    $input['poe_type'] = $poe_type;

    // Convert empty numeric values to NULL
    $numeric_fields = [
        't_ports_count', 't_ports_speed', 'sfp_ports_count',
        'sfp_ports_speed', 'uplink_sfp_ports_count',
        'uplink_sfp_ports_speed', 'qty', 'price'
    ];
    foreach ($numeric_fields as $field) {
        if (!isset($input[$field]) || trim($input[$field]) === '') {
            $input[$field] = null;
        } else {
            $input[$field] = (int)$input[$field];
        }
    }

    // ✅ Convert empty or invalid date to NULL
    if (!isset($input['dop']) || trim($input['dop']) === '') {
        $input['dop'] = null;
    } else {
        // Optional: validate date format (YYYY-MM-DD)
        $date = date_create_from_format('Y-m-d', $input['dop']);
        $input['dop'] = $date ? $date->format('Y-m-d') : null;
    }

    $sql = "INSERT INTO switches (
        dept, lab_name, make, model, serial_number, poe_type, access_port,
        t_ports_count, t_ports_speed, sfp_ports_count, sfp_ports_speed,
        uplink_sfp_ports_count, uplink_sfp_ports_speed, reg_no, page_no,
        qty, price, dop, supplier_name, switch_ip, remarks
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $pdo->prepare($sql);
    $result = $stmt->execute([
        $input['dept'],
        $input['lab_name'],
        $input['make'],
        $input['model'],
        $input['serial_number'],
        $input['poe_type'],
        $input['access_port'],
        $input['t_ports_count'],
        $input['t_ports_speed'],
        $input['sfp_ports_count'],
        $input['sfp_ports_speed'],
        $input['uplink_sfp_ports_count'],
        $input['uplink_sfp_ports_speed'],
        $input['reg_no'],
        $input['page_no'],
        $input['qty'],
        $input['price'],
        $input['dop'],
        $input['supplier_name'],
        $input['switch_ip'],
        $input['remarks']
    ]);

    if ($result) {
        echo json_encode(['success' => true, 'id' => $pdo->lastInsertId()]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to insert switch']);
    }

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
