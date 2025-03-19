<?php
$db = new PDO("mysql:host=10.180.98.21;dbname=khemen-database", "dbuser", "dbpass");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $uuid = bin2hex(random_bytes(16)); // Generate unique user_id
    $first_name = $_POST['firstname'];
    $last_name = $_POST['lastname'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $city = $_POST['city'];
    $province = $_POST['province'];
    $postal_code = $_POST['postalcode'];
    $password = $_POST['password'];

    // Insert into MySQL (no password stored)
    try {
        $stmt = $db->prepare("INSERT INTO users (user_id, first_name, last_name, email, phone_number, address, city, province, postal_code) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$uuid, $first_name, $last_name, $email, $phone, $address, $city, $province, $postal_code]);
    } catch (PDOException $e) {
        echo "Database error: " . $e->getMessage();
        exit;
    }

    // Add to AD (Windows Server at 10.180.98.22)
    $ldap = ldap_connect("ldap://10.180.98.22");
    if ($ldap) {
        $bind = ldap_bind($ldap, "admin@yourdomain.local", "adminpass");
        if ($bind) {
            $entry = [
                "cn" => "$first_name $last_name",
                "mail" => $email,
                "telephoneNumber" => $phone,
                "streetAddress" => $address,
                "l" => $city,
                "st" => $province,
                "postalCode" => $postal_code,
                "objectClass" => ["top", "person", "organizationalPerson", "user"],
                "userPrincipalName" => $email,
                "samAccountName" => strtolower($first_name . $last_name),
                "unicodePwd" => iconv("UTF-8", "UTF-16LE", "\"$password\""), // Encode password for AD
            ];
            $dn = "CN=$first_name $last_name,OU=Users,DC=yourdomain,DC=local";
            $add = ldap_add($ldap, $dn, $entry);
            if ($add) {
                echo "Signup successful! Your ID: $uuid (Use your email and password to sign in)";
            } else {
                echo "Failed to add user to AD: " . ldap_error($ldap);
            }
        } else {
            echo "LDAP bind failed: " . ldap_error($ldap);
        }
        ldap_close($ldap);
    } else {
        echo "LDAP connection failed.";
    }
} else {
    echo "Invalid request method.";
}
?>