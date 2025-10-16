<?php
// Include database configuration
require_once __DIR__ . '/../../config/database.php';

header('Content-Type: application/json');

try {
    $pdo = getDatabaseConnection();
    
    $input = json_decode(file_get_contents('php://input'), true);
    
    // Check if it's a single field update or full record update
    if (isset($input['field']) && isset($input['value'])) {
        // Single field update
        $field = $input['field'];
        $value = $input['value'];
        $id = $input['id'];
        
        // Validate field name to prevent SQL injection
        $allowedFields = [
            'dept', 'lab_name', 'make', 'model', 'serial_number', 'poe_type', 'access_port',
            't_ports_count', 't_ports_speed', 'sfp_ports_count', 'sfp_ports_speed',
            'uplink_sfp_ports_count', 'uplink_sfp_ports_speed', 'reg_no', 'page_no',
            'qty', 'price', 'dop', 'supplier_name', 'switch_ip', 'remarks'
        ];
        
        if (!in_array($field, $allowedFields)) {
            throw new Exception('Invalid field name');
        }
        
        $sql = "UPDATE switches SET $field = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $result = $stmt->execute([$value, $id]);
    } else {
        // Full record update
        $sql = "UPDATE switches SET dept=?, lab_name=?, make=?, model=?, serial_number=?, poe_type=?, access_port=?, t_ports_count=?, t_ports_speed=?, sfp_ports_count=?, sfp_ports_speed=?, uplink_sfp_ports_count=?, uplink_sfp_ports_speed=?, reg_no=?, page_no=?, qty=?, price=?, dop=?, supplier_name=?, switch_ip=?, remarks=? WHERE id=?";
        
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
            $input['remarks'],
            $input['id']
        ]);
    }
    
    if ($result) {
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => 'Failed to update switch']);
    }
    
} catch(Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'error' => 'Database error: ' . $e->getMessage()]);
}
?>
