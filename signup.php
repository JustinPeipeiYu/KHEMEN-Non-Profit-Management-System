<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sign Up</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .signup-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        .signup-container h2, .signup-container h3 {
            color: #333;
        }
        .signup-container input[type="text"], 
        .signup-container input[type="email"], 
        .signup-container input[type="tel"], 
        .signup-container input[type="number"], 
        .signup-container select {
            width: 100%;
            padding: 10px;
            margin: 10px 0;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .signup-container .payment-row {
            display: flex;
            gap: 10px;
        }
        .signup-container .payment-row input {
            flex: 1;
        }
        .signup-container button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .signup-container button:hover {
            background-color: #0056b3;
        }
    </style>
    <script>
        function validateForm() {
            // Validate phone number
            var phoneNumber = document.getElementById("phone").value;
            var phonePattern = /^\+1\s\d{3}\s\d{3}\s\d{4}$/;
            if (!phonePattern.test(phoneNumber)) {
                alert("Please enter a valid Canadian phone number in the format +1 xxx xxx xxxx.");
                return false;
            }

            // Validate card number (16 digits)
            var cardNumber = document.getElementById("cardnumber").value;
            var cardPattern = /^\d{16}$/;
            if (!cardPattern.test(cardNumber)) {
                alert("Please enter a valid 16-digit card number.");
                return false;
            }

            // Validate expiration date (MM/YY format)
            var expiry = document.getElementById("expiry").value;
            var expiryPattern = /^(0[1-9]|1[0-2])\/\d{2}$/;
            if (!expiryPattern.test(expiry)) {
                alert("Please enter a valid expiration date in MM/YY format.");
                return false;
            }

            // Validate CVV (3-4 digits)
            var cvv = document.getElementById("cvv").value;
            var cvvPattern = /^\d{3,4}$/;
            if (!cvvPattern.test(cvv)) {
                alert("Please enter a valid CVV (3 or 4 digits).");
                return false;
            }

            // Validate amount (must be greater than 0)
            var amount = document.getElementById("amount").value;
            if (isNaN(amount) || amount <= 0) {
                alert("Please enter a valid amount greater than 0.");
                return false;
            }

            return true;
        }
    </script>
</head>
<body>
    <div class="signup-container">
        <h2>Sign Up</h2>
        <form action="signup_process.php" method="post" onsubmit="return validateForm()">
            <input type="text" name="firstname" placeholder="First Name" required>
            <input type="text" name="lastname" placeholder="Last Name" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="tel" id="phone" name="phone" placeholder="Phone Number (with Country Code)" required>
            <input type="text" name="address" placeholder="Street Address" required>
            <input type="text" name="city" placeholder="City" required>
            <select name="province" required>
                <option value="" disabled selected>Select Province</option>
                <option value="Alberta">Alberta</option>
                <option value="British Columbia">British Columbia</option>
                <option value="Manitoba">Manitoba</option>
                <option value="New Brunswick">New Brunswick</option>
                <option value="Newfoundland and Labrador">Newfoundland and Labrador</option>
                <option value="Nova Scotia">Nova Scotia</option>
                <option value="Ontario">Ontario</option>
                <option value="Prince Edward Island">Prince Edward Island</option>
                <option value="Quebec">Quebec</option>
                <option value="Saskatchewan">Saskatchewan</option>
            </select>
            <input type="text" name="postalcode" placeholder="Postal Code" required>
            
            <!-- Payment Details -->
            <h3>Payment Information</h3>
            <input type="number" id="amount" name="amount" placeholder="Amount (CAD)" step="0.01" min="0.01" required>
            <input type="number" id="cardnumber" name="cardnumber" placeholder="Card Number" required>
            <div class="payment-row">
                <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                <input type="number" id="cvv" name="cvv" placeholder="CVV" required>
            </div>

            <button type="submit">Sign Up</button>
        </form>
    </div>
</body>
</html>