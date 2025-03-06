<?php
// Include the database connection file
require 'db.php';

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Fetch user from the database
    try {
        $stmt = $conn->prepare("SELECT * FROM users WHERE username = :username");
        $stmt->bindParam(':username', $username);
        $stmt->execute();
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user && password_verify($password, $user['password'])) {
            echo "Login successful!";
            // Start a session or redirect to a dashboard
        } else {
            echo "Invalid username or password.";
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
    <title>Sign In - Khemen</title>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <div id="wrapper">
        <!-- Header and Menu (same as before) -->
        <div id="page" class="container">
            <div id="content">
                <div class="post">
                    <h2 class="title">Welcome Back!</h2>
                    <div class="entry">
                        <p>Sign in to your Khemen account to continue making a difference. Together, we can create a world where generosity fuels meaningful impact and sustainable change.</p>
                        <form action="signin.php" method="POST" class="centered-form">
                            <label for="username">Username:</label>
                            <input type="text" id="username" name="username" required><br><br>
                            <label for="password">Password:</label>
                            <input type="password" id="password" name="password" required><br><br>
                            <button type="submit" class="button">Sign In</button>
                        </form>
                        <p class="signup-link">Don't have an account? <a href="signup.php">Sign Up Now</a></p>
                    </div>
                </div>
            </div>
            <!-- Sidebar and Footer (same as before) -->
        </div>
    </div>
</body>
</html>