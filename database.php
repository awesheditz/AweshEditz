<?php
define('DB_HOST', 'localhost'); // Agar free hosting hai toh apna MySQL Hostname likhein
define('DB_NAME', 'awes134268_awesh'); // Apna database name likhein
define('DB_USER', 'awes134268_awesh'); // Apna database user name likhein
define('DB_PASS', 'awes134268_awesh'); // Apna database password likhein

try {
    $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME . ";charset=utf8mb4", DB_USER, DB_PASS, [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ]);
} catch (PDOException $e) {
    header('Content-Type: application/json');
    // Yeh line humein exact error batayegi ki connection kyun fail ho raha hai
    echo json_encode([
        "status" => "error", 
        "message" => "Connection failed: " . $e->getMessage()
    ]);
    exit;
}
?>