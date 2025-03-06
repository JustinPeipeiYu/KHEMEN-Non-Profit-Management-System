<?php
// Include the database connection file
require 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash the password

    // Insert user into the database
    try {
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (:username, :email, :password)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':password', $password);

        if ($stmt->execute()) {
            echo "Signup successful!";
        } else {
            echo "Error during signup.";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up - Khemen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="wrapper">
        <!-- Header and Menu (same as before) -->
        <div id="page" class="container">
            <div id="content">
                <div class="post">
                    <h2 class="title">Join Us Today!</h2>
                    <div class="entry">
                        <p>Create a Khemen account to start making a difference. By joining us, you become part of a community dedicated to supporting those in need through charitable donations and impactful programs.</p>
                        <form action="signup.php" method="POST" class="centered-form">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" required><br><br>
                            <label for="email">Email:</label>
                            <input type="email" id="email" name="email" required><br><br>
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required><br><br>
                            <button type="submit" class="button">Sign Up</button>
                        </form>
                        <p class="signin-link">Already have an account? <a href="signin.php">Sign In Here</a></p>
                    </div>
                </div>
            </div>
            <!-- Sidebar and Footer (same as before) -->
        </div>
    </div>
</body>
</html>