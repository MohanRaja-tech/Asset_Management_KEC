<?php
require_once __DIR__ . '/../config/database.php';

try {
	$pdo = getDatabaseConnection();

	// Sample data for racks
	$sampleRacks = [
		[
			'dept' => 'Computer Science',
			'lab_name' => 'Networking Lab',
			'make' => 'APC',
			'rack_size' => '42U',
			'pdu' => 'APC PDU',
			'reg_no' => 'CS-001',
			'page_no' => '12',
			'price' => 45000.00,
			'dop' => '2023-08-15',
			'supplier_name' => 'Tech Supplies Ltd.',
			'remarks' => 'Main server rack'
		],
		[
			'dept' => 'Electronics',
			'lab_name' => 'Embedded Systems Lab',
			'make' => 'Vertiv',
			'rack_size' => '24U',
			'pdu' => 'Vertiv PDU',
			'reg_no' => 'EC-002',
			'page_no' => '8',
			'price' => 32000.00,
			'dop' => '2024-01-10',
			'supplier_name' => 'ElectroMart',
			'remarks' => 'For microcontroller kits'
		]
	];

	$sql = "INSERT INTO racks (dept, lab_name, make, rack_size, pdu, reg_no, page_no, price, dop, supplier_name, remarks) VALUES (:dept, :lab_name, :make, :rack_size, :pdu, :reg_no, :page_no, :price, :dop, :supplier_name, :remarks)";
	$stmt = $pdo->prepare($sql);

	foreach ($sampleRacks as $rack) {
		$stmt->execute($rack);
	}

	echo "Sample racks inserted successfully.";
} catch (Exception $e) {
	echo "Error inserting sample racks: " . $e->getMessage();
}
