<?php
//© 2025 Khemen Front-End Script.
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Allow cross-origin requests from anybody in Conestoga
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Handle Cross Origin Resource Sharing preflight options request
if ($_SERVER["REQUEST_METHOD"] == "OPTIONS") {
    http_response_code(204);
    exit;
}

// Process the actual request
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get Authorization header
    $authHeader = $_SERVER['HTTP_AUTHORIZATION'] ?? '';

    if (!$authHeader || $authHeader !== "Bearer token123") {
        http_response_code(401); // Unauthorized
        echo json_encode(["status" => "error", "message" => "Invalid or missing Authorization token"]);
        exit;
    }
}

// Database credentials
$servername = "10.180.98.35"; // Change if your MySQL server is not on localhost
$username = "webuser";        // Change to your MySQL username
$password = "NewWebUserPassword";            // Change to your MySQL password
$dbname = "Khemen_OneTimeDatabase";     // Change to your database name

// Create database connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check database connection
if ($conn->connect_error) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
}

//read incoming form data
$jsonData = file_get_contents('php://input');
$data = json_decode($jsonData, true);

// Check if decoding was successful
if ($data === null) {
    // Handle error if JSON is invalid
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data.']);
    exit;
}

// Check if data is received
if ($data !== null) {
    // Extract from JSON
    $firstName = htmlspecialchars($data['firstname']);
    $lastName = htmlspecialchars($data['lastname']);
    $email = htmlspecialchars($data['email']);
    $phone = htmlspecialchars($data['phone']);
    $address = htmlspecialchars($data['address']);
    $city = htmlspecialchars($data['city']);
    $province = htmlspecialchars($data['province']);
    $postalCode = htmlspecialchars($data['postalcode']);
    $amount = htmlspecialchars($data['amount']);
    $cardNumber = htmlspecialchars($data['cardnumber']);
    $expiry = htmlspecialchars($data['expiry']);
    $cvv = htmlspecialchars($data['cvv']);
} else {
    die(json_encode(['status' => 'error', 'message' => 'Invalid request method']));
}

// Validate form data
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["status" => "error", "message" => "Invalid email format."]);
    exit;
}

// Prepare and execute database insertion and return JSON response
$stmt = $conn->prepare("INSERT INTO Khemen_OneTimeDonors (firstname, lastname, email, phone, address, city, province, postalcode, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    echo json_encode(["status" => "error", "message" => "Database connection failed."]);
    exit;
}
$stmt->bind_param("ssssssssd", $firstName, $lastName, $email, $phone, $address, $city, $province, $postalCode, $amount);

if ($stmt->execute()) {
    echo json_encode(['status' => 'success', 'message' => 'Donation processed successfully.']);
} else {
    echo json_encode(['status' => 'error', 'message' => 'Failed to process donation.']);
}

// Close database connection
$stmt->close();
$conn->close();
?>
