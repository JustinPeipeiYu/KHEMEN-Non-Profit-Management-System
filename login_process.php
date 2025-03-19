<?php
session_start();
$db = new PDO("mysql:host=10.180.98.21;dbname=khemen-database", "dbuser", "dbpass");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $input = $_POST['email_or_id'];
    $password = $_POST['password'];

    // Get email from MySQL based on email or user_id
    try {
        $stmt = $db->prepare("SELECT email FROM users WHERE email = ? OR user_id = ?");
        $stmt->execute([$input, $input]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);
        $email = $user['email'] ?? $input; // Use input directly if it’s an email not found as user_id
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }

    // Authenticate against AD (Windows Server at 10.180.98.22)
    $ldap = ldap_connect("ldap://10.180.98.22");
    if ($ldap) {
        $bind = @ldap_bind($ldap, $email, $password); // Suppress warnings with @
        if ($bind) {
            // Get user_id for session
            $stmt = $db->prepare("SELECT user_id FROM users WHERE email = ?");
            $stmt->execute([$email]);
            $user_id = $stmt->fetchColumn();
            if ($user_id) {
                $_SESSION['user_id'] = $user_id;
                header("Location: dashboard.php"); // Redirect to donation page
                exit;
            } else {
                echo "User not found in database.";
            }
        } else {
            echo "Invalid credentials.";
        }
        ldap_close($ldap);
    } else {
        echo "LDAP connection failed.";
    }
} else {
    echo "Invalid request method.";
}
?>