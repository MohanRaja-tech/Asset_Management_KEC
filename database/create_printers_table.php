<?php
// Include database configuration
require_once '../config/database.php';

try {
    $pdo = getDatabaseConnection();
    
    // Create printers table
    $sql = "CREATE TABLE IF NOT EXISTS printers (
        id INT AUTO_INCREMENT PRIMARY KEY,
        dept VARCHAR(50) NOT NULL,
        lab_name VARCHAR(100) NOT NULL,
        make VARCHAR(100) NOT NULL,
        model VARCHAR(100) NOT NULL,
        type VARCHAR(50) NOT NULL,
        paper_size VARCHAR(50),
        cartridge_model VARCHAR(100),
        total_printers INT DEFAULT 1,
        cost DECIMAL(10,2),
        reg_no VARCHAR(100),
        p_no VARCHAR(100),
        dop DATE,
        remarks TEXT,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
    )";
    
    $pdo->exec($sql);
    echo "Printers table created successfully!";
    
    // Insert some sample data
    $sampleData = [
        ['CSE', 'Computer Lab 1', 'HP', 'LaserJet Pro', 'Laser', 'A4', 'HP 85A', 2, 25000.00, 'REG001', 'P001', '2023-01-15', 'Working condition'],
        ['ECE', 'Electronics Lab', 'Canon', 'PIXMA', 'Inkjet', 'A4', 'Canon PG-240', 1, 15000.00, 'REG002', 'P002', '2023-02-20', 'Good condition'],
        ['IT', 'IT Lab 1', 'Epson', 'WorkForce', 'All in one', 'A4', 'Epson 252', 1, 18000.00, 'REG003', 'P003', '2023-03-10', 'Excellent condition'],
        ['ME', 'Mechanical Lab', 'Brother', 'HL-L2350DW', 'Laser', 'A4', 'Brother TN-660', 1, 12000.00, 'REG004', 'P004', '2023-04-05', 'Good working'],
        ['CE', 'Civil Lab', 'Xerox', 'WorkCentre', 'Xerox', 'A3', 'Xerox 106R00659', 1, 35000.00, 'REG005', 'P005', '2023-05-12', 'Professional grade'],
        ['EEE', 'Electrical Lab', 'HP', 'OfficeJet', 'All in one', 'A4', 'HP 305', 1, 20000.00, 'REG006', 'P006', '2023-06-18', 'Multifunction printer']
    ];
    
    $insertSql = "INSERT INTO printers (dept, lab_name, make, model, type, paper_size, cartridge_model, total_printers, cost, reg_no, p_no, dop, remarks) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
    $stmt = $pdo->prepare($insertSql);
    
    foreach ($sampleData as $data) {
        $stmt->execute($data);
    }
    
    echo "<br>Sample printer data inserted successfully!";
    
} catch(PDOException $e) {
    echo "Error: " . $e->getMessage();
}
?>
