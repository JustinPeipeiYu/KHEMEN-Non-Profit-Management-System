<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Donate Now</title>
    <style>
        body {
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            background-color: #f0f0f0;
        }
        .donate-container {
            background-color: #fff;
            padding: 20px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
            width: 300px;
        }
        .donate-container h2, .donate-container h3 {
            color: #333;
        }
        .donate-container label {
            display: block;
            text-align: left;
            margin: 10px 0 5px;
            color: #333;
        }
        .donate-container input[type="text"], 
        .donate-container input[type="email"], 
        .donate-container input[type="tel"], 
        .donate-container input[type="number"], 
        .donate-container select {
            width: 100%;
            padding: 10px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .donate-container .payment-row {
            display: flex;
            gap: 10px;
        }
        .donate-container .payment-row input {
            flex: 1;
        }
        .donate-container button {
            background-color: #007BFF;
            color: #fff;
            padding: 10px 20px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .donate-container button:hover {
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
    <div class="donate-container">
        <h2>Donate Now</h2>
        <form action="donatenow_process.php" method="post" onsubmit="return validateForm()">
            <label for="firstname">First Name</label>
            <input type="text" id="firstname" name="firstname" placeholder="First Name" required>
            
            <label for="lastname">Last Name</label>
            <input type="text" id="lastname" name="lastname" placeholder="Last Name" required>
            
            <label for="email">Email</label>
            <input type="email" id="email" name="email" placeholder="Email" required>
            
            <label for="phone">Phone Number</label>
            <input type="tel" id="phone" name="phone" placeholder="Phone Number" required>
            
            <label for="address">Street Address</label>
            <input type="text" id="address" name="address" placeholder="Street Address" required>
            
            <label for="city">City</label>
            <input type="text" id="city" name="city" placeholder="City" required>
            
            <label for="province">Province</label>
            <select id="province" name="province" required>
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
            
            <label for="postalcode">Postal Code</label>
            <input type="text" id="postalcode" name="postalcode" placeholder="Postal Code" required>
            
            <!-- Payment Details -->
            <h3>Payment Information</h3>
            
            <label for="amount">Amount (CAD)</label>
            <input type="number" id="amount" name="amount" placeholder="Amount (CAD)" step="0.01" min="0.01" required>
            
            <label for="cardnumber">Card Number</label>
            <input type="number" id="cardnumber" name="cardnumber" placeholder="Card Number" required>
            
            <div class="payment-row">
                <div>
                    <label for="expiry">Expiry Date</label>
                    <input type="text" id="expiry" name="expiry" placeholder="MM/YY" required>
                </div>
                <div>
                    <label for="cvv">CVV</label>
                    <input type="number" id="cvv" name="cvv" placeholder="CVV" required>
                </div>
            </div>

            <button type="submit">Donate Now</button>
        </form>
    </div>
</body>
</html>

