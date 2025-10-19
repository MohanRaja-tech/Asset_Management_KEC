<?php
// Include database configuration
require_once '../config/database.php';

try {
    $pdo = getDatabaseConnection();
    
    // Create NVR table
    $sql = "CREATE TABLE IF NOT EXISTS nvr (
        id INT AUTO_INCREMENT PRIMARY KEY,
        building_block VARCHAR(100) NOT NULL,
        location VARCHAR(100) NOT NULL,
        make VARCHAR(100) NOT NULL,
        model VARCHAR(100),
        serial_no VARCHAR(100),
        hdd_2tb_qty INT DEFAULT 0,
        hdd_4tb_qty INT DEFAULT 0,
        hdd_6tb_qty INT DEFAULT 0,
        hdd_8tb_qty INT DEFAULT 0,
        type VARCHAR(50),
        qty INT DEFAULT 1,
        cost DECIMAL(10,2),
        reg_no VARCHAR(100),
        page_no VARCHAR(100),
        dop DATE,
        remarks TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "NVR table created successfully!<br>";
    
    // Insert sample data based on the provided structure
    $sampleData = [
        [
            'building_block' => 'Main Block',
            'location' => 'Security Room',
            'make' => 'HikVision',
            'model' => 'DS-7616NI-K2',
            'serial_no' => 'NVR001234567',
            'hdd_2tb_qty' => 2,
            'hdd_4tb_qty' => 1,
            'hdd_6tb_qty' => 0,
            'hdd_8tb_qty' => 0,
            'type' => '16 Channel',
            'qty' => 1,
            'cost' => 45000.00,
            'reg_no' => 'REG/NVR/001',
            'page_no' => 'P001',
            'dop' => '2024-03-15',
            'remarks' => 'Main security NVR'
        ],
        [
            'building_block' => 'CSE Block',
            'location' => 'Server Room',
            'make' => 'HikVision',
            'model' => 'DS-7732NI-K4',
            'serial_no' => 'NVR001234568',
            'hdd_2tb_qty' => 0,
            'hdd_4tb_qty' => 2,
            'hdd_6tb_qty' => 1,
            'hdd_8tb_qty' => 0,
            'type' => '32 Channel',
            'qty' => 1,
            'cost' => 75000.00,
            'reg_no' => 'REG/NVR/002',
            'page_no' => 'P002',
            'dop' => '2024-04-10',
            'remarks' => 'CSE department NVR'
        ],
        [
            'building_block' => 'ECE Block',
            'location' => 'Control Room',
            'make' => 'Dahua',
            'model' => 'DHI-NVR4216-16P-4KS2',
            'serial_no' => 'NVR001234569',
            'hdd_2tb_qty' => 1,
            'hdd_4tb_qty' => 0,
            'hdd_6tb_qty' => 2,
            'hdd_8tb_qty' => 1,
            'type' => '16 Channel PoE',
            'qty' => 1,
            'cost' => 55000.00,
            'reg_no' => 'REG/NVR/003',
            'page_no' => 'P003',
            'dop' => '2024-05-01',
            'remarks' => 'ECE lab monitoring'
        ],
        [
            'building_block' => 'Library Block',
            'location' => 'Admin Office',
            'make' => 'HikVision',
            'model' => 'DS-7608NI-K2',
            'serial_no' => 'NVR001234570',
            'hdd_2tb_qty' => 0,
            'hdd_4tb_qty' => 0,
            'hdd_6tb_qty' => 0,
            'hdd_8tb_qty' => 2,
            'type' => '8 Channel',
            'qty' => 1,
            'cost' => 35000.00,
            'reg_no' => 'REG/NVR/004',
            'page_no' => 'P004',
            'dop' => '2024-06-15',
            'remarks' => 'Library surveillance'
        ]
    ];
    
    $insertSql = "INSERT INTO nvr 
                  (building_block, location, make, model, serial_no, hdd_2tb_qty, hdd_4tb_qty, 
                   hdd_6tb_qty, hdd_8tb_qty, type, qty, cost, reg_no, page_no, dop, remarks)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    
    $stmt = $pdo->prepare($insertSql);
    
    foreach ($sampleData as $data) {
        $stmt->execute([
            $data['building_block'], $data['location'], $data['make'], $data['model'],
            $data['serial_no'], $data['hdd_2tb_qty'], $data['hdd_4tb_qty'], 
            $data['hdd_6tb_qty'], $data['hdd_8tb_qty'], $data['type'], $data['qty'], 
            $data['cost'], $data['reg_no'], $data['page_no'], $data['dop'], $data['remarks']
        ]);
    }
    
    echo "Sample NVR data inserted successfully!<br>";
    
} catch(PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>
