<?php
// Database configuration
$host = 'localhost'; // Replace with your database host
$dbname = 'khemen'; // Replace with your database name
$user = 'root'; // Replace with your database username
$pass = 'monalisa'; // Replace with your database password

// Create a connection
try {
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
?>