<?php
// Include database configuration
require_once '../config/database.php';

try {
    $pdo = getDatabaseConnection();
    
    // Create lab_inventory table
    $sql = "CREATE TABLE IF NOT EXISTS lab_inventory (
        id INT AUTO_INCREMENT PRIMARY KEY,
        dept VARCHAR(50) NOT NULL,
        lab_name VARCHAR(100) NOT NULL,
        make_name VARCHAR(100),
        model_name VARCHAR(100),
        serial_no VARCHAR(100),
        processor VARCHAR(100),
        generation VARCHAR(50),
        ram_gb INT,
        primary_storage VARCHAR(100),
        secondary_storage VARCHAR(100),
        operating_system VARCHAR(100),
        gpu_name VARCHAR(100),
        monitor_type VARCHAR(100),
        monitor_size VARCHAR(50),
        monitor_serial VARCHAR(100),
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
    echo "Lab inventory table created successfully!<br>";
    
    // Insert sample data
    $sampleData = [
        [
            'dept' => 'CSE', 
            'lab_name' => 'Programming Lab 1',
            'make_name' => 'Dell',
            'model_name' => 'OptiPlex 3080',
            'serial_no' => 'DL001CSE',
            'processor' => 'Intel Core i5',
            'generation' => '10th Gen',
            'ram_gb' => 8,
            'primary_storage' => '256GB SSD',
            'secondary_storage' => '1TB HDD',
            'operating_system' => 'Windows 11',
            'gpu_name' => 'Intel UHD Graphics',
            'monitor_type' => 'LED',
            'monitor_size' => '22 inch',
            'monitor_serial' => 'MON001CSE',
            'qty' => 30,
            'cost' => 45000.00,
            'reg_no' => 'REG/CSE/001',
            'p_no' => 'PO/2024/001',
            'dop' => '2024-01-15',
            'remarks' => 'Lab systems for programming'
        ],
        [
            'dept' => 'ECE', 
            'lab_name' => 'Digital Lab',
            'make_name' => 'HP',
            'model_name' => 'EliteDesk 800',
            'serial_no' => 'HP001ECE',
            'processor' => 'Intel Core i7',
            'generation' => '11th Gen',
            'ram_gb' => 16,
            'primary_storage' => '512GB SSD',
            'secondary_storage' => null,
            'operating_system' => 'Windows 11',
            'gpu_name' => 'Intel Iris Xe',
            'monitor_type' => 'LED',
            'monitor_size' => '24 inch',
            'monitor_serial' => 'MON001ECE',
            'qty' => 25,
            'cost' => 65000.00,
            'reg_no' => 'REG/ECE/001',
            'p_no' => 'PO/2024/002',
            'dop' => '2024-02-10',
            'remarks' => 'High-end systems for digital circuits'
        ]
    ];
    
    $insertSql = "INSERT INTO lab_inventory 
                  (dept, lab_name, make_name, model_name, serial_no, processor, generation, 
                   ram_gb, primary_storage, secondary_storage, operating_system, gpu_name, 
                   monitor_type, monitor_size, monitor_serial, qty, cost, reg_no, p_no, dop, remarks)
                  VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";
    
    $stmt = $pdo->prepare($insertSql);
    
    foreach ($sampleData as $data) {
        $stmt->execute([
            $data['dept'], $data['lab_name'], $data['make_name'], $data['model_name'],
            $data['serial_no'], $data['processor'], $data['generation'], $data['ram_gb'],
            $data['primary_storage'], $data['secondary_storage'], $data['operating_system'],
            $data['gpu_name'], $data['monitor_type'], $data['monitor_size'], $data['monitor_serial'],
            $data['qty'], $data['cost'], $data['reg_no'], $data['p_no'], $data['dop'], $data['remarks']
        ]);
    }
    
    echo "Sample lab inventory data inserted successfully!<br>";
    
} catch(PDOException $e) {
    echo "Error creating table: " . $e->getMessage();
}
?>