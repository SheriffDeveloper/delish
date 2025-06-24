<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DelishGo - Restaurants</title>
    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #ffedd5, #ff7b00);
        padding: 20px;
      }
      .navbar {
        background: #ff4d00;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
      .navbar .brand {
        font-size: 24px;
        font-weight: bold;
        color: white;
      }
      .navbar .nav-links {
        display: flex;
        gap: 15px;
      }
      .navbar a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        padding: 8px 15px;
        transition: background 0.3s;
      }
      .navbar a:hover {
        background: #e64500;
        border-radius: 5px;
      }
      .restaurant-container {
        max-width: 900px;
        margin: auto;
        background: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        margin-top: 20px;
      }
      .restaurant {
        display: flex;
        align-items: center;
        background: #fff;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
      }
      .restaurant:hover {
        transform: scale(1.02);
      }
      .restaurant img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        margin-right: 15px;
      }
      .restaurant-details {
        flex-grow: 1;
      }
      .restaurant h5 {
        color: #ff4d00;
        margin-bottom: 5px;
      }
      .restaurant p {
        margin: 0;
        font-size: 14px;
        color: #555;
      }
    </style>
  </head>
  <body>
    <nav class="navbar">
      <div class="brand">DelishGo</div>
      <div class="nav-links">
        <a href="index.html">Home</a>
        <a href="restaurants.php">Restaurants</a>
        <a href="login.html">Login</a>
      </div>
    </nav>
    <div class="restaurant-container">
      <h3 class="text-center" style="color: #ff4d00;">Discover Restaurants</h3>
      <p class="text-center">Find amazing places to eat around you.</p>
      
      <div class="restaurant">
        <img src="assets/images/restaurant1.jpg" alt="Restaurant 1">
        <div class="restaurant-details">
          <h5>Spicy Delight</h5>
          <p>Authentic Nigerian cuisine with a touch of spice.</p>
          <p><strong>Location:</strong> Lagos, Nigeria</p>
        </div>
      </div>

      <div class="restaurant">
        <img src="assets/images/restaurant2.jpg" alt="Restaurant 2">
        <div class="restaurant-details">
          <h5>Urban Bites</h5>
          <p>Modern dining experience with delicious meals.</p>
          <p><strong>Location:</strong> Abuja, Nigeria</p>
        </div>
      </div>

      <div class="restaurant">
        <img src="assets/images/food3.png" alt="Restaurant 3">
        <div class="restaurant-details">
          <h5>Golden Spoon</h5>
          <p>Exquisite dishes prepared with fresh ingredients.</p>
          <p><strong>Location:</strong> Port Harcourt, Nigeria</p>
        </div>
      </div>
    </div>
  </body>
</html>
