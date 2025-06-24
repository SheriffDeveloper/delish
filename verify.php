<?php
session_start();
include "dbcon.php";
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';
require 'PHPMailer/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if (!isset($_SESSION['pending_signup'])) {
    header("Location: signin.php");
    exit();
}

$otpError = "";
$success = false;

// Function to send OTP email
function sendOTPEmail($toEmail, $otpCode) {
    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = 'mail.delishgofoods.com'; // Truehost SMTP host
        $mail->SMTPAuth = true;
        $mail->Username = 'verify@delishgofoods.com'; // your custom email
        $mail->Password = 'verify752nL';  // replace this securely
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom('verify@delishgofoods.com', 'DelishGo Verify');
        $mail->addAddress($toEmail);

        $mail->Subject = 'Your DelishGo OTP Code';
        $mail->Body = "Your new OTP is: $otpCode";

        $mail->send();
        return true;
    } catch (Exception $e) {
        return false;
    }
}

// If user clicks resend OTP
if (isset($_POST['resend_otp'])) {
    $newOtp = rand(100000, 999999);
    $_SESSION['pending_signup']['otp'] = $newOtp;
    $_SESSION['pending_signup']['otp_created_at'] = time();
    $email = $_SESSION['pending_signup']['email'];

    if (sendOTPEmail($email, $newOtp)) {
        $_SESSION['popup_message'] = "New OTP sent to $email.";
    } else {
        $_SESSION['popup_message'] = "Failed to resend OTP.";
    }

    header("Location: verify.php");
    exit();
}

// If user submits OTP
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['verify_otp'])) {
    $enteredOtp = $_POST['otp'];
    $storedOtp = $_SESSION['pending_signup']['otp'];
    $createdAt = $_SESSION['pending_signup']['otp_created_at'];

    if (time() - $createdAt > 300) {
        $otpError = "OTP expired. Please sign up again.";
        unset($_SESSION['pending_signup']);
    } elseif ($enteredOtp == $storedOtp) {
        $name = $_SESSION['pending_signup']['username'];
        $email = $_SESSION['pending_signup']['email'];
        $password = $_SESSION['pending_signup']['password'];

        $stmt = $conn->prepare("INSERT INTO user (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);

        if ($stmt->execute()) {
            $success = true;
            unset($_SESSION['pending_signup']);
            $_SESSION['popup_message'] = "Account verified and created!";
            $_SESSION['redirect_url'] = "signin.php";
        } else {
            $otpError = "Error saving user. Try again.";
        }

        $stmt->close();
        $conn->close();
    } else {
        $otpError = "Invalid OTP entered.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Verify OTP - DelishGo</title>
  <link rel="stylesheet" href="stylee.css" />
  <style>
    body {
      font-family: 'Arial', sans-serif;
      background-color: #f5f7fa;
      display: flex;
      justify-content: center;
      align-items: center;
      min-height: 100vh;
    }
    .auth-container {
      background: #fff;
      padding: 2.5rem;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }
    input[type="text"] {
      width: 100%;
      padding: 12px;
      margin-bottom: 15px;
      border: 1px solid #ddd;
      border-radius: 6px;
    }
    button {
      width: 100%;
      padding: 12px;
      background-color: #ff6347;
      color: white;
      border: none;
      border-radius: 6px;
      cursor: pointer;
    }
    .resend-btn {
      background-color: #888;
      margin-top: 10px;
    }
    .error {
      color: red;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="auth-container">
    <h2>Enter the OTP</h2>
    <?php if ($otpError): ?>
        <p class="error"><?= $otpError ?></p>
    <?php endif; ?>
    <form method="POST">
      <input type="text" name="otp" placeholder="Enter 6-digit OTP" required />
      <button type="submit" name="verify_otp">Verify</button>
    </form>

    <form method="POST">
      <button class="resend-btn" type="submit" name="resend_otp">Resend OTP</button>
    </form>
  </div>

  <script>
    <?php
    if (isset($_SESSION['popup_message'])) {
        $message = $_SESSION['popup_message'];
        $redirect = $_SESSION['redirect_url'] ?? "";
        echo "alert('$message');";
        if ($redirect) {
            echo "window.location.href = '$redirect';";
        }
        unset($_SESSION['popup_message']);
        unset($_SESSION['redirect_url']);
    }
    ?>
  </script>
</body>
</html>
