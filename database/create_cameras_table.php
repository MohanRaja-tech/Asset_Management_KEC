<?php
// Include database configuration
require_once '../config/database.php';

try {
    $pdo = getDatabaseConnection();
    
    // Create cameras table
    $sql = "CREATE TABLE IF NOT EXISTS cameras (
        id INT AUTO_INCREMENT PRIMARY KEY,
        building_block VARCHAR(100) NOT NULL,
        location VARCHAR(100) NOT NULL,
        make VARCHAR(100) NOT NULL,
        model VARCHAR(100),
        type VARCHAR(50) NOT NULL,
        pixel VARCHAR(50) NOT NULL,
        qty INT DEFAULT 1,
        cost DECIMAL(10,2),
        reg_no VARCHAR(100),
        p_no VARCHAR(100),
        dop DATE,
        remarks TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Cameras table created successfully!<br>";
    
    // Insert sample data based on the provided structure
    $sampleData = [
        [
            'building_block' => 'Main Block',
            'location' => 'Entrance Gate',
            'make' => 'HikVision',
            'model' => 'DS-2CD2143G0-I',
            'type' => 'IP',
            'pixel' => '4.0Mp',
            'qty' => 2,
            'cost' => 15000.00,
            'reg_no' => 'REG/CAM/001',
            'p_no' => 'PO/2024/CAM/001',
            'dop' => '2024-03-15',
            'remarks' => 'Main entrance monitoring'
        ],
        [
            'building_block' => 'CSE Block',
            'location' => 'Corridor 1st Floor',
            'make' => 'HikVision',
            'model' => 'DS-2CD2123G0-I',
            'type' => 'IP',
            'pixel' => '2.0Mp',
            'qty' => 4,
            'cost' => 8000.00,
            'reg_no' => 'REG/CAM/002',
            'p_no' => 'PO/2024/CAM/002',
            'dop' => '2024-03-20',
            'remarks' => 'Corridor surveillance'
        ],
        [
            'building_block' => 'ECE Block',
            'location' => 'Lab Entrance',
            'make' => 'HikVision',
            'model' => 'DS-2CD2163G0-I',
            'type' => 'IP',
            'pixel' => '6.0Mp',
            'qty' => 3,
            'cost' => 20000.00,
            'reg_no' => 'REG/CAM/003',
            'p_no' => 'PO/2024/CAM/003',
            'dop' => '2024-04-10',
            'remarks' => 'High-resolution lab monitoring'
        ],
        [
            'building_block' => 'Library Block',
            'location' => 'Reading Hall',
            'make' => 'HikVision',
            'model' => 'DS-2CD2183G0-I',
            'type' => 'IP',
            'pixel' => '8.0Mp',
            'qty' => 2,
            'cost' => 25000.00,
            'reg_no' => 'REG/CAM/004',
            'p_no' => 'PO/2024/CAM/004',
            'dop' => '2024-04-15',
            'remarks' => 'Ultra HD library surveillance'
        ],
        [
            'building_block' => 'Admin Block',
            'location' => 'Reception Area',
            'make' => 'HikVision',
            'model' => 'DS-2CD2143G0-I',
            'type' => 'HD',
            'pixel' => '1.3Mp',
            'qty' => 1,
            'cost' => 6000.00,
            'reg_no' => 'REG/CAM/005',
            'p_no' => 'PO/2024/CAM/005',
            'dop' => '2024-05-01',
            'remarks' => 'Reception monitoring'
        ]
    ];
    
    $insertSql = "INSERT INTO cameras 
                  (building_block, location, make, model, type, pixel, qty, cost, reg_no, p_no, dop, remarks)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?)";
    
    $stmt = $pdo->prepare($insertSql);
    
    foreach ($sampleData as $data) {
        $stmt->execute([
            $data['building_block'], $data['location'], $data['make'], $data['model'],
            $data['type'], $data['pixel'], $data['qty'], $data['cost'],
            $data['reg_no'], $data['p_no'], $data['dop'], $data['remarks']
        ]);
    }
    
    echo "Sample camera data inserted successfully!<br>";
    
} catch(PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>