<?php
// save.php
// Handles JSON posted from the web page and inserts rows into MySQL.

header('Content-Type: text/plain');

// ---- Database credentials ----
$host = "localhost";
$user = "asset_user";
$pass = "StrongPass123!";                 // <-- set to your MySQL password, or leave "" if none
$db   = "inventory_db";

// ---- Connect to database ----
$conn = new mysqli($host, $user, $pass, $db);
if ($conn->connect_error) {
    http_response_code(500);
    die("DB Connection failed: " . $conn->connect_error);
}

// ---- Read JSON from fetch() ----
$input = file_get_contents("php://input");
$data  = json_decode($input, true);

if (!$data || !isset($data["data"]) || !is_array($data["data"])) {
    http_response_code(400);
    die("No valid data received");
}

// ---- Prepare the insert statement once ----
$sql = "INSERT INTO lab_inventory
       (dept, lab_name, make_name, model_name, serial_no,
        processor, generation, ram_gb, primary_storage, secondary_storage,
        operating_system, gpu_name, monitor_type, monitor_size, monitor_serial,
        qty, cost, reg_no, p_no, dop, remarks)
       VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)";

$stmt = $conn->prepare($sql);
if (!$stmt) {
    http_response_code(500);
    die("Prepare failed: " . $conn->error);
}

// Type string: 21 columns
// 15 strings + 1 int (qty) + 1 double (cost) + 4 strings
$typeString = "sssssssssssssssidssss";

// ---- Loop through each row from the front end ----
foreach ($data["data"] as $row) {
    // Make sure there are at least 21 columns in $row
    if (count($row) < 21) {
        // Skip incomplete rows
        continue;
    }

    // Assign each column to a variable (bind_param needs variables by reference)
    $dept            = $row[0];
    $lab_name        = $row[1];
    $make_name       = $row[2];
    $model_name      = $row[3];
    $serial_no       = $row[4];
    $processor       = $row[5];
    $generation      = $row[6];
    $ram_gb          = $row[7];
    $primary_storage = $row[8];
    $secondary_storage = $row[9];
    $operating_system = $row[10];
    $gpu_name       = $row[11];
    $monitor_type   = $row[12];
    $monitor_size   = $row[13];
    $monitor_serial = $row[14];
    $qty            = (int)$row[15];
    $cost           = (float)$row[16];
    $reg_no         = $row[17];
    $p_no           = $row[18];
    $dop            = $row[19];   // Expecting YYYY-MM-DD
    $remarks        = $row[20];

    // Bind the parameters
    $stmt->bind_param(
        $typeString,
        $dept, $lab_name, $make_name, $model_name, $serial_no,
        $processor, $generation, $ram_gb, $primary_storage, $secondary_storage,
        $operating_system, $gpu_name, $monitor_type, $monitor_size, $monitor_serial,
        $qty, $cost, $reg_no, $p_no, $dop, $remarks
    );

    // Execute the insert
    if (!$stmt->execute()) {
        // If one row fails, log the error but continue
        error_log("Insert failed for row: " . $stmt->error);
    }
}

// ---- Finish up ----
$stmt->close();
$conn->close();

echo "Data saved successfully!";
?>
