<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DelishGo - Merchants Login</title>
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
      .login-container {
        background: rgba(255, 255, 255, 0.9);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
        text-align: center;
        position: relative;
        z-index: 1;
      }
      .login-container h4 {
        color: #ff4d00;
        font-weight: bold;
      }
      .login-container input {
        border-radius: 10px;
      }
      .login-container .btn-primary {
        background: #ff4d00;
        border: none;
        transition: 0.3s;
      }
      .login-container .btn-primary:hover {
        background: #e64500;
      }
      .floating-food {
        position: absolute;
        animation: float 3s infinite ease-in-out;
        z-index: 1;
      }
      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
      }
      .food1 { top: 10px; left: 10px; width: 50px; }
      .food2 { bottom: 10px; right: 10px; width: 50px; }
      .food3 { top: 50px; right: 30px; width: 40px; }
      .food4 { bottom: 50px; left: 30px; width: 40px; }
      .food5 { top: 20px; right: 50%; width: 45px; }
    </style>
  </head>
  <body>
    <div style="height: 50%;" class="background-slider"></div>
    <div class="login-container">
      <img src="assets/images/DelishGo Logo Ng.jpg" alt="logo" width="150">
      <h4>Welcome Back, Merchant!</h4>
      <p>Sign in to manage your restaurant on DelishGo.</p>
      <form>
        <div class="form-group">
          <input type="email" class="form-control" placeholder="Email" required>
        </div>
        <div class="form-group">
          <input type="password" class="form-control" placeholder="Password" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Sign In</button>
        <div class="mt-3">
          <a href="/Admin%20Dashbord%20DelishGo/dashboard.php">Forgot Password?</a>
        </div>
      </form>
    </div>
    <img style="width: 200px;" src="assets/images/food1.jfif.png" class="floating-food food1">
    <img style="width: 200px;" src="assets/images/food6.png" class="floating-food food2">
    <img style="width: 200px;" src="assets/images/food3.png" class="floating-food food3">
    <img style="width: 200px;" src="assets/images/food4.png" class="floating-food food4">
    <img style="width: 200px;" src="assets/images/food5.png" class="floating-food food5">
  </body>
</html>
