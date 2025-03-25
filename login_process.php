<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$servername = "10.180.98.35";
$username = "webuser"; // Adjust accordingly
$password = "NewWebUserPassword"; // Adjust accordingly
$dbname = "Khemen_OneTimeDatabase";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Get input value
    $email = $_POST['email']; // Assuming email is coming from a POST request

    // Check if email is provided and not empty
    if (empty($email)) {
        die('Email is empty');
    }

    // Prepare statement
    $stmt = $conn->prepare("SELECT * FROM Khemen_OneTimeDonors WHERE email = ?");
    if ($stmt === false) {
        die('MySQL prepare error: ' . $conn->error);
    }

    // Bind parameters
    $stmt->bind_param("s", $email);

    // Execute the query
    $stmt->execute();

    // Get results
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Process the result
        while ($row = $result->fetch_assoc()) {
            // Do something with the row
            echo "You are now logged in.";
        }
    } else {
        echo "No user found with that email.";
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
}
?>