<?php
// Database credentials
$servername = "10.180.98.21"; // MariaDB server IP
$username = "webuser";        // Corrected username
$password = "webpassword";    // Change to your MariaDB password
$dbname = "Khemen_database";  // Your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
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
    $cardNumber = htmlspecialchars($_POST['cardnumber']); // For processing only
    $expiry = htmlspecialchars($_POST['expiry']);         // For processing only
    $cvv = htmlspecialchars($_POST['cvv']);              // For processing only

    // Validate form data
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        die("Invalid email format");
    }

    // Prepare and bind the SQL statement to prevent SQL injection
    $stmt = $conn->prepare("INSERT INTO Khemen_donations (firstName, lastName, email, phone, address, city, province, postalcode, amount) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssssssd", $firstName, $lastName, $email, $phone, $address, $city, $province, $postalCode, $amount);

    // Execute the query and store non-sensitive data
    if ($stmt->execute()) {
        echo "Thank you for your donation! Data stored successfully.";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();

    // Placeholder for PayPal payment processing (commented out until you’re ready with the API key)
    /*
    // Process payment using PayPal (example, to be implemented when ready)
    require_once 'vendor/autoload.php'; // Include PayPal SDK (install via Composer: composer require paypal/rest-api-sdk-php)
    
    // Set up PayPal configuration
    $paypalConfig = [
        'mode' => 'sandbox', // Use 'live' for production
        'client_id' => 'your_paypal_client_id', // Replace with your PayPal Client ID
        'client_secret' => 'your_paypal_secret', // Replace with your PayPal Secret
    ];

    // Initialize PayPal API
    $apiContext = new \PayPal\Rest\ApiContext(
        new \PayPal\Auth\OAuthTokenCredential(
            $paypalConfig['client_id'],
            $paypalConfig['client_secret']
        )
    );

    try {
        // Create a payment
        $payment = new \PayPal\Api\Payment();
        $payment->setIntent('sale')
                ->setPayer(new \PayPal\Api\Payer(['payment_method' => 'credit_card']))
                ->setTransactions([
                    new \PayPal\Api\Transaction([
                        'amount' => new \PayPal\Api\Amount([
                            'total' => $amount,
                            'currency' => 'USD', // Change to your currency
                        ]),
                        'description' => 'Donation Payment'
                    ])
                ])
                ->setRedirectUrls([
                    'return_url' => 'http://10.180.98.20/MYwebpagefortest/success.php',
                    'cancel_url' => 'http://10.180.98.20/MYwebpagefortest/cancel.php'
                ]);

        // Process credit card payment
        $card = new \PayPal\Api\CreditCard();
        $card->setNumber($cardNumber)
             ->setType('visa') // Adjust based on card type (e.g., 'mastercard', 'amex')
             ->setExpireMonth(substr($expiry, 0, 2)) // Extract MM from MM/YYYY
             ->setExpireYear(substr($expiry, 3, 4))  // Extract YYYY from MM/YYYY
             ->setCvv($cvv)
             ->setFirstName($firstName)
             ->setLastName($lastName);

        $payment->getPayer()->setPaymentMethod('credit_card');
        $payment->setTransactions([$payment->getTransactions()[0]->setItemList(new \PayPal\Api\ItemList())]);

        // Execute the payment
        $payment->create($apiContext);

        // Payment successful, echo success message (optional, as data is already stored)
        echo " Payment processed successfully with PayPal.";
    } catch (\PayPal\Exception\PayPalConnectionException $ex) {
        echo "Payment failed: " . $ex->getMessage();
    }
    */
}
?>