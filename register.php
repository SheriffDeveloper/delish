<?php include 'db.php'; ?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DelishGo - Create Account</title>
    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Arial', sans-serif;
        position: relative;
        overflow: hidden;
      }
      .background-slider {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 60%;
        background-size: cover;
        background-position: center;
        animation: slide 15s infinite;
      }
      @keyframes slide {
        0% { background-image: url('assets/images/deliverycover1.png'); }
        20% { background-image: url('assets/images/deliverycover2.png'); }
        40% { background-image: url('assets/images/deliverycover3.png'); }
        60% { background-image: url('assets/images/deliverycover4.png'); }
        80% { background-image: url('assets/images/deliverycover5.png'); }
        100% { background-image: url('assets/images/deliverycover6.png'); }
      }
      .register-container {
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        text-align: center;
        position: relative;
        z-index: 1;
      }
      .register-container h4 {
        color: #ff4d00;
        font-weight: bold;
      }
      .register-container input {
        border-radius: 10px;
        background-color: black;
      }
      .register-container .btn-primary {
        background: #ff4d00;
        border: none;
        transition: 0.3s;
      }
      .register-container .btn-primary:hover {
        background: #e64500;
      }
    </style>
  </head>
  <body>
    <div style="height: 50%;" class="background-slider"></div>
    <div class="register-container">
      <img src="assets/images/DelishGo Logo Ng.jpg" alt="logo" width="150">
      <h4>Create Your Merchant Account</h4>
      <p>Sign up to start managing your restaurant on DelishGo.</p>
      <form action="register_command.php" method="POST" enctype="multipart/form-data" onsubmit="return validateForm()">
        <div class="form-group">
          <input type="text" class="form-control" name="vendor_name" placeholder="Vendor Name" required>
        </div>
        <div class="form-group">
          <input type="file" name="vendor_image" class="form-control" placeholder="Profile Picture" required>
        </div>
        <div class="form-group">
          <input type="text" class="form-control" name="unique_id" placeholder="Unique ID" required>
        </div>
        <div class="form-group">
          <textarea name="description" class="form-control" placeholder="Description" required></textarea>
        </div>
        <div class="form-group">
          <input type="password" name="password" class="form-control" placeholder="Password" required>
        </div>

        <button type="submit" class="btn btn-primary btn-block">Sign Up</button>
        <div class="mt-3">
          <p>Already have an account? <a href="index.php">Sign In</a></p>
        </div>
      </form>
      <?php
            if (isset($_GET['error'])) {
                echo "<p style='color: red;'>Registration failed. Please try again.</p>";
            }
            if (isset($_GET['registration'])) {
                echo "<p style='color: green;'>Registration successful! Please login.</p>";
            }
            ?>
    </div>

    <script>
    function validateForm() {
        const vendorName = document.querySelector('input[name="vendor_name"]').value;
        const uniqueId = document.querySelector('input[name="unique_id"]').value;
        const password = document.querySelector('input[name="password"]').value;

        if (vendorName.length < 3) {
            alert("Vendor Name must be at least 3 characters long.");
            return false;
        }
        if (uniqueId.length < 5) {
            alert("Unique ID must be at least 5 characters long.");
            return false;
        }
        if (password.length < 6) {
            alert("Password must be at least 6 characters long.");
            return false;
        }
        return true;
    }

    function checkPasswordStrength(password) {
        const strength = {
            0: "Very Weak",
            1: "Weak",
            2: "Moderate",
            3: "Strong",
            4: "Very Strong"
        };
        let score = 0;
        if (password.length >= 8) score++;
        if (/[A-Z]/.test(password)) score++;
        if (/[0-9]/.test(password)) score++;
        if (/[^A-Za-z0-9]/.test(password)) score++;
        return strength[score];
    }

    document.querySelector('input[name="password"]').addEventListener('input', function() {
        const strength = checkPasswordStrength(this.value);
        document.getElementById('password-strength').innerText = `Password Strength: ${strength}`;
    });
    </script>
  </body>
</html>
