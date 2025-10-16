<?php
// Include database configuration
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = getDatabaseConnection();
    
    // Create switches table
    $sql = "CREATE TABLE IF NOT EXISTS switches (
        id INT AUTO_INCREMENT PRIMARY KEY,
        dept VARCHAR(50) NOT NULL,
        lab_name VARCHAR(100) NOT NULL,
        make VARCHAR(100) NOT NULL,
        model VARCHAR(100) NOT NULL,
        serial_number VARCHAR(100),
        poe_type ENUM('PoE', 'Non-PoE') DEFAULT 'Non-PoE',
        access_port VARCHAR(50),
        t_ports_count INT DEFAULT 0,
        t_ports_speed VARCHAR(50),
        sfp_ports_count INT DEFAULT 0,
        sfp_ports_speed VARCHAR(50),
        uplink_sfp_ports_count INT DEFAULT 0,
        uplink_sfp_ports_speed VARCHAR(50),
        reg_no VARCHAR(100),
        page_no VARCHAR(50),
        qty INT DEFAULT 1,
        price DECIMAL(10,2),
        dop DATE,
        supplier_name VARCHAR(100),
        switch_ip VARCHAR(45),
        remarks TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Switches table created successfully!";
    
    // Insert some sample data
    $sampleData = [
        ['CSE', 'Computer Lab 1', 'Cisco', 'Catalyst 2960', 'CISCO001', 'PoE', '24', 24, '100Mbps', 2, '1Gbps', 2, '1Gbps', 'REG001', 'P001', 1, 45000.00, '2023-01-15', 'Cisco Systems', '192.168.1.10', 'Working condition'],
        ['ECE', 'Electronics Lab', 'HP', 'ProCurve 2520', 'HP001', 'PoE', '24', 24, '1Gbps', 4, '1Gbps', 2, '10Gbps', 'REG002', 'P002', 1, 35000.00, '2023-02-20', 'HP Enterprise', '192.168.1.11', 'Good condition'],
        ['IT', 'IT Lab 1', 'D-Link', 'DGS-1210', 'DLINK001', 'Non-PoE', '24', 24, '1Gbps', 2, '1Gbps', 2, '1Gbps', 'REG003', 'P003', 1, 25000.00, '2023-03-10', 'D-Link India', '192.168.1.12', 'Excellent condition'],
        ['ME', 'Mechanical Lab', 'Netgear', 'GS724T', 'NETGEAR001', 'Non-PoE', '24', 24, '1Gbps', 0, '', 0, '', 'REG004', 'P004', 1, 15000.00, '2023-04-05', 'Netgear India', '192.168.1.13', 'Good working'],
        ['CE', 'Civil Lab', 'TP-Link', 'TL-SG1024', 'TPLINK001', 'Non-PoE', '24', 24, '1Gbps', 0, '', 0, '', 'REG005', 'P005', 1, 12000.00, '2023-05-12', 'TP-Link India', '192.168.1.14', 'Professional grade'],
        ['EEE', 'Electrical Lab', 'Ubiquiti', 'EdgeSwitch 24', 'UBIQUITI001', 'PoE', '24', 24, '1Gbps', 2, '1Gbps', 2, '10Gbps', 'REG006', 'P006', 1, 55000.00, '2023-06-18', 'Ubiquiti Networks', '192.168.1.15', 'Enterprise grade switch']
    ];
    
    $insertSql = "INSERT INTO switches (dept, lab_name, make, model, serial_number, poe_type, access_port, t_ports_count, t_ports_speed, sfp_ports_count, sfp_ports_speed, uplink_sfp_ports_count, uplink_sfp_ports_speed, reg_no, page_no, qty, price, dop, supplier_name, switch_ip, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertSql);
    
    foreach ($sampleData as $data) {
        $stmt->execute($data);
    }
    
    echo "<br>Sample switch data inserted successfully!";
    
} catch(Exception $e) {
    echo "Error: " . $e->getMessage();
}
?>
