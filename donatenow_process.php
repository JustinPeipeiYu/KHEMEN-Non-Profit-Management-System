<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
// Allow cross-origin requests from any domain (or specify a particular domain)
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");

// Database credentials
$servername = "10.180.98.35"; // Change if your MySQL server is not on localhost
$username = "webuser";        // Change to your MySQL username
$password = "NewWebUserPassword";            // Change to your MySQL password
$dbname = "Khemen_OneTimeDatabase";     // Change to your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Get the raw POST data (the JSON sent by fetch)
$jsonData = file_get_contents('php://input');

// Decode the JSON data into a PHP associative array
$data = json_decode($jsonData, true);

// Check if decoding was successful
if ($data === null) {
    // Handle error if JSON is invalid
    echo json_encode(['status' => 'error', 'message' => 'Invalid JSON data']);
    exit;
}

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Collect form data
    $firstName = htmlspecialchars($_POST['firstname']);
    $lastName = htmlspecialchars($_POST['lastname']);
    $email = htmlspecialchars($_POST['email']);
    $phone = htmlspecialchars($_POST['phone']);
    $address = htmlspecialchars($_POST['address']);
    $city = htmlspecialchars($_POST['city']);
    $province = htmlspecialchars($_POST['province']);
    $postalCode = htmlspecialchars($_POST['postalcode']);
    $amount = htmlspecialchars($_POST['amount']);
    $cardNumber = htmlspecialchars($_POST['cardnumber']);
    $expiry = htmlspecialchars($_POST['expiry']);
    $cvv = htmlspecialchars($_POST['cvv']);

    // Validate form data (Add your validation here)
    // Example: Check if email is valid
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Save form data to a database or process it (Add your code here)
    // Example: Save to donations table
    $stmt = $conn->prepare("INSERT INTO Khemen_OneTimeDonors (firstname, lastname, email, phone, address, city, province, postalcode, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
if ($stmt === false) {
    die("Prepare failed: " . $conn->error);
}
    $stmt->bind_param("ssssssssd", $firstName, $lastName, $email, $phone, $address, $city, $province, $postalCode, $amount);

    // Execute the query
    // Return json response
    if ($stmt->execute()) {
        echo json_encode(['status' => 'success', 'message' => '<h2>Donation processed successfully.</h2>']);
    } else {
        echo json_encode(['status' => 'error', 'message' => '<h2>Failed to process donation.</h2>']);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>
