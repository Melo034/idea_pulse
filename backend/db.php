<?php


// Database connection parameters
$host = 'localhost';
$dbname   = 'idea_pulse';
$username = 'root';
$password = '';
$charset = 'utf8mb4';

// Data Source Name (DSN) for connecting to the database
$dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";

// PDO options for error handling and fetch modes
$options = [
    PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION, // Throw exceptions on errors
    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,       // Fetch results as associative arrays
    PDO::ATTR_EMULATE_PREPARES   => false,                  // Disable emulation of prepared statements
];

try {
    // Create a new PDO instance (connect to the database)
    $pdo = new PDO($dsn, $username, $password, $options);
} catch (\PDOException $e) {
    // Handle connection error by throwing an exception with the error message and code
    throw new \PDOException($e->getMessage(), (int)$e->getCode());
}





