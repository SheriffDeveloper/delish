<?php
session_start();
include "dbcon.php";

if (!isset($conn)) {
    die("Database connection not established.");
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['signup'])) {
        $username = htmlspecialchars($_POST['username']);
        $email = htmlspecialchars($_POST['email']);
        $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

        $query = "INSERT INTO user (username, email, password) VALUES (?, ?, ?)";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("sss", $username, $email, $password);

        if ($stmt->execute()) {
            $_SESSION['user_email'] = $email; // ✅ Store email
            $_SESSION['popup_message'] = "Signup successful! Redirecting...";
            $_SESSION['redirect_url'] = "restaurants.php";
        } else {
            $_SESSION['popup_message'] = "Signup failed! Try again.";
            $_SESSION['redirect_url'] = "";
        }
        $stmt->close();
    }

    if (isset($_POST['login'])) {
        $email = htmlspecialchars($_POST['email']);
        $password = $_POST['password'];

        $query = "SELECT id, password FROM user WHERE email = ?";
        $stmt = $conn->prepare($query);
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows > 0) {
            $stmt->bind_result($userId, $hashedPassword);
            $stmt->fetch();

            if (password_verify($password, $hashedPassword)) {
                $_SESSION['user_id'] = $userId;
                $_SESSION['user_email'] = $email; // ✅ Store email
                $_SESSION['popup_message'] = "Login successful! Redirecting...";
                $_SESSION['redirect_url'] = "restaurants.php";
            } else {
                $_SESSION['popup_message'] = "Incorrect password!";
                $_SESSION['redirect_url'] = "";
            }
        } else {
            $_SESSION['popup_message'] = "User not found!";
            $_SESSION['redirect_url'] = "";
        }
        $stmt->close();
    }

    $conn->close();
    header("Location: signin.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - DelishGo</title>
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
      padding: 3rem;
      border-radius: 10px;
      box-shadow: 0 10px 20px rgba(0,0,0,0.1);
      width: 100%;
      max-width: 400px;
      text-align: center;
    }

    .auth-container h2 {
      font-size: 1.8rem;
      margin-bottom: 2rem;
      color: #333;
    }

    .auth-form input {
      width: 100%;
      padding: 12px;
      margin: 10px 0;
      border: 1px solid #ddd;
      border-radius: 6px;
      font-size: 1rem;
      transition: border-color 0.3s ease;
    }

    .auth-form input:focus {
      border-color: #ff6347;
      outline: none;
    }

    .auth-form button {
      width: 100%;
      padding: 12px;
      background-color: #ff6347;
      color: white;
      border: none;
      border-radius: 6px;
      font-size: 1.1rem;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }

    .auth-form button:hover {
      background-color: #e55347;
    }

    .auth-switch {
      margin-top: 15px;
      font-size: 1rem;
      color: #555;
    }

    .auth-switch a {
      color: #ff6347;
      text-decoration: none;
    }

    .social-login {
      margin-top: 2rem;
    }

    .social-buttons button {
      padding: 12px;
      width: 100%;
      border: none;
      border-radius: 6px;
      font-size: 1.1rem;
      cursor: pointer;
      background-color: #4285f4;
      color: white;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: background-color 0.3s ease;
    }

    .social-buttons button:hover {
      background-color: #357ae8;
    }

    .social-buttons button img {
      width: 20px;
      margin-right: 10px;
    }

    #popup-message {
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: #ff4500;
      color: #fff;
      padding: 20px;
      box-shadow: 0px 0px 15px rgba(0,0,0,0.3);
      border-radius: 8px;
      text-align: center;
      z-index: 1000;
    }

    #popup-message button {
      background: #b22222;
      color: #fff;
      padding: 8px 16px;
      border: none;
      border-radius: 5px;
      cursor: pointer;
      margin-top: 10px;
    }

    #popup-message button:hover {
      background: #a11c1c;
    }
  </style>
</head>
<body>

  <main id="login" class="auth-container">
    <h2>Login to your account</h2>
    <form action="signin.php" method="POST" class="auth-form">
      <input type="email" name="email" placeholder="Email" required />
      <input type="password" name="password" placeholder="Password" required />
      <button type="submit" name="login">Login</button>
    </form>
    <p class="auth-switch">
      Don’t have an account? <a href="signup.php">Sign Up</a>
    </p>
    <div class="social-login">
      <p>Or continue with</p>
      <div class="social-buttons">
        <button class="google-btn">
          <img src="https://www.svgrepo.com/show/475656/google-color.svg" alt="Google" />
          Google
        </button>
      </div>
    </div>
  </main>

  <script>
    function showPopup(message, redirectUrl) {
      let popup = document.createElement("div");
      popup.id = "popup-message";
      popup.innerHTML = `
        <div class="popup-content">
          <p>${message}</p>
          <button onclick="closePopup('${redirectUrl}')">OK</button>
        </div>
      `;
      document.body.appendChild(popup);
    }

    function closePopup(redirectUrl) {
      document.getElementById("popup-message").remove();
      if (redirectUrl) {
        window.location.href = redirectUrl;
      }
    }

    <?php
    if (isset($_SESSION['popup_message'])) {
        $message = $_SESSION['popup_message'];
        $redirectUrl = isset($_SESSION['redirect_url']) ? $_SESSION['redirect_url'] : "";
        echo "showPopup('$message', '$redirectUrl');";
        unset($_SESSION['popup_message']);
        unset($_SESSION['redirect_url']);
    }
    ?>
  </script>
</body>
</html>
