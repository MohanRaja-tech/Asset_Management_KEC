<?php
require_once __DIR__ . '/../config/database.php';

try {
    $pdo = getDatabaseConnection();

    $sql = "CREATE TABLE IF NOT EXISTS racks (
        id INT AUTO_INCREMENT PRIMARY KEY,
        dept VARCHAR(100) NULL,
        lab_name VARCHAR(150) NULL,
        make VARCHAR(150) NULL,
        rack_size VARCHAR(50) NULL,
        pdu VARCHAR(150) NULL,
        reg_no VARCHAR(100) NULL,
        page_no VARCHAR(50) NULL,
        price DECIMAL(12,2) NULL,
        dop DATE NULL,
        supplier_name VARCHAR(200) NULL,
        remarks TEXT NULL,
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;";

    $pdo->exec($sql);
    echo "Racks table created or already exists."; 
} catch (Exception $e) {
    echo "Error creating racks table: " . $e->getMessage();
}
