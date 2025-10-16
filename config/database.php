<?php
/**
 * Database Configuration
 * 
 * This file contains database connection settings for the Lab Inventory Management System.
 * Update these settings according to your database configuration.
 */

// Database connection settings
define('DB_HOST', 'localhost');
define('DB_NAME', 'inventory_db');
define('DB_USER', 'asset_user');
define('DB_PASS', 'StrongPass123!');

// Database connection function
function getDatabaseConnection() {
    try {
        $pdo = new PDO(
            "mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4",
            DB_USER,
            DB_PASS,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_EMULATE_PREPARES => false
            ]
        );
        return $pdo;
    } catch(PDOException $e) {
        error_log("Database connection failed: " . $e->getMessage());
        throw new Exception("Database connection failed");
    }
}

// Application settings
define('APP_NAME', 'Lab Inventory Management System');
define('APP_VERSION', '1.0.0');
define('APP_TIMEZONE', 'Asia/Kolkata');

// Set timezone
date_default_timezone_set(APP_TIMEZONE);

// Error reporting (set to false in production)
define('DEBUG_MODE', $_ENV['DEBUG_MODE'] ?? true);

if (DEBUG_MODE) {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
} else {
    error_reporting(0);
    ini_set('display_errors', 0);
}
?>
