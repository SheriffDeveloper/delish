<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>DelishGo - Menu</title>
  <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css">
  <style>
    body {
      font-family: 'Poppins', sans-serif;
      background: #f8f9fa;
      padding: 0;
      margin: 0;
    }

    .navbar {
      background: #ff4d00;
      padding: 10px 20px;
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
      position: fixed;
      margin-top: -50px;
    }

    .brand {
      font-size: 26px;
      font-weight: bold;
      color: white;
    }

    .nav-toggle {
      display: none;
      font-size: 28px;
      color: white;
      background: none;
      border: none;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 20px;
    }

    .nav-links a {
      color: white;
      text-decoration: none;
      font-size: 18px;
      transition: color 0.3s ease;
    }

    .nav-links a:hover {
      color: #ffddcc;
    }

    .cart {
      position: relative;
      cursor: pointer;
    }

    .cart-icon {
      font-size: 24px;
      color: white;
    }

    .cart-counter {
      position: absolute;
      top: -5px;
      right: -10px;
      background: red;
      color: white;
      font-size: 14px;
      border-radius: 50%;
      width: 20px;
      height: 20px;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
    }

    .menu-container {
      max-width: 1100px;
      margin: 40px auto;
      background: white;
      padding: 30px;
      border-radius: 15px;
      box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
    }

    .menu-title {
      text-align: center;
      color: #ff4d00;
      font-size: 28px;
      font-weight: bold;
      margin-bottom: 20px;
    }

    .menu-grid {
      display: flex;
      flex-wrap: wrap;
      gap: 20px;
      justify-content: center;
    }

    .menu-item {
      background: #fff;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      transition: transform 0.3s ease;
      width: calc(33.333% - 20px);
      max-width: 300px;
      text-align: center;
    }

    .menu-item:hover {
      transform: translateY(-5px);
    }

    .menu-item img {
      width: 120px;
      height: 120px;
      border-radius: 10px;
    }

    .menu-item h5 {
      color: #ff4d00;
      margin-top: 15px;
      font-size: 20px;
    }

    .menu-item p {
      font-size: 14px;
      color: #555;
    }

    .price {
      font-size: 18px;
      font-weight: bold;
      margin-top: 10px;
    }

    .old-price {
      text-decoration: line-through;
      color: #888;
      margin-right: 5px;
    }

    .new-price {
      color: #ff4d00;
    }

    .add-to-cart {
      margin-top: 15px;
      background: #ff4d00;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
      transition: background 0.3s ease;
    }

    .add-to-cart:hover {
      background: #e64500;
    }

    .cart-popup {
      display: none;
      position: fixed;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      background: white;
      padding: 20px;
      border-radius: 10px;
      box-shadow: 0 4px 10px rgba(0, 0, 0, 0.2);
      width: 300px;
      text-align: center;
      z-index: 1000;
    }

    .cart-popup.active {
      display: block;
    }

    .cart-popup button {
      margin-top: 10px;
      background: #ff4d00;
      color: white;
      border: none;
      padding: 10px 15px;
      border-radius: 5px;
      cursor: pointer;
    }

    .overlay {
      display: none;
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      background: rgba(0, 0, 0, 0.5);
      z-index: 999;
    }

    /* Mobile responsive nav toggle */
@media (max-width: 768px) {
  .toggle-btn {
    display: block;
  }

  .navbar{
    width: 250px;
    border: 2px solid red;
    padding: 10px;
    border-radius: 50px 20px;
  }

  .nav-links {
    display: none;
    flex-direction: column;
    width: 100%;
    background-color: #ff4d00;
    margin-top: 10px;
    padding: 10px 0;
  }

  .nav-links.show {
    display: flex;
  }

  .nav-links a {
    padding: 10px 20px;
  }
}

    @media (max-width: 991px) {
      .menu-item {
        width: calc(50% - 20px);
      }
    }

    @media (max-width: 576px) {
      .menu-item {
        width: 100%;
      }

      .nav-links {
        display: none;
        flex-direction: column;
        width: 100%;
        margin-top: 10px;
      }

      .nav-links.active {
        display: flex;
      }

      .nav-toggle {
        display: block;
      }

      .navbar {
        flex-direction: column;
        align-items: flex-start;
      }

      .cart {
        align-self: flex-end;
        margin-top: 10px;
      }
    }
    .star-rating {
        display: flex;
        gap: 5px;
        font-size: 1.8rem;
        color: #ccc;
        justify-content: center;
        margin-right:5px;
        margin-top: 10px;
    }

    .star-rating span {
        color: gold; /* Change how many stars are filled by applying this selectively */
    }

    /* Example: To show 3 out of 5 stars filled, apply gold color to first 3 spans only */
    /* You can do this manually or dynamically later */
    .bottom-nav {
  position: fixed;
  bottom: 0;
  left: 0;
  right: 0;
  height: 60px;
  background-color: #ffffff;
  border-top: 1px solid #ddd;
  display: flex;
  justify-content: space-around;
  align-items: center;
  z-index: 1000;
}

.nav-item {
  text-align: center;
  color: #555;
  font-size: 12px;
  text-decoration: none;
  flex: 1;
  transition: color 0.3s;
}

.nav-item i {
  font-size: 20px;
  display: block;
  margin-bottom: 3px;
}

.nav-item:hover {
  color: #ff4d00;
}
/* Back to top code start here */
#backToTopBtn {
  display: none;
  position: fixed;
  bottom: 80px; /* above bottom nav */
  right: 20px;
  z-index: 1001;
  font-size: 18px;
  border: none;
  outline: none;
  background-color: #ff4d00;
  color: white;
  cursor: pointer;
  padding: 12px 19px;
  border-radius: 50%;
  box-shadow: 0 2px 10px rgba(0,0,0,0.3);
  transition: background-color 0.3s ease;
}

#backToTopBtn:hover {
  background-color: #e64500;
}
/* Back to top code ends here */
  </style>
</head>
<body>
  <nav class="navbar">
    <div>
        <div class="brand">DelishGo</div>
        <button class="nav-toggle" onclick="toggleNav()">☰</button>
    </div>
    <div class="nav-links" id="nav-links">
      <a href="index.html">Home</a>
      <a href="restaurants.php">Restaurants</a>
      <a href="menu.html">Menu</a>
      <a href="login.html">Login</a>
    </div>
  </nav>

  <div class="cart-popup" id="cart-popup">
    <h4>Cart Items</h4>
    <ul id="cart-items">Your cart is empty.</ul>
    <button onclick="toggleCartPopup()">Close</button>
    <button onclick="payWithSquad()">Checkout</button>
  </div>

  <div class="overlay" id="overlay" onclick="toggleCartPopup()"></div>

  <div class="menu-container">
    <h3 class="menu-title">Our Menu</h3>
    <div class="menu-grid">
      <!-- Repeated Items -->
      <div class="menu-item">
        <img src="assets/images/food3.png" alt="Dish 1">
        <h5>Jollof Rice</h5>
        <p>Spicy and delicious West African favorite.</p>
        <div class="price"><span class="old-price">₦2500</span><span class="new-price">₦2000</span></div>
        <button class="add-to-cart" onclick="incrementCart('Jollof Rice', '₦2000')">Add to Cart</button>
      </div>
      <div class="menu-item">
        <img src="assets/images/food3.png" alt="Dish 1">
        <h5>Jollof Rice</h5>
        <p>Spicy and delicious West African favorite.</p>
        <div class="price"><span class="old-price">₦2500</span><span class="new-price">₦2000</span></div>
        <button class="add-to-cart" onclick="incrementCart('Jollof Rice', '₦2000')">Add to Cart</button>
      </div>
      <div class="menu-item">
        <img src="assets/images/food3.png" alt="Dish 1">
        <h5>Jollof Rice</h5>
        <p>Spicy and delicious West African favorite.</p>
        <div class="price"><span class="old-price">₦2500</span><span class="new-price">₦2000</span></div>
        <button class="add-to-cart" onclick="incrementCart('Jollof Rice', '₦2000')">Add to Cart</button>
      </div>
      <div class="menu-item">
        <img src="assets/images/food3.png" alt="Dish 1">
        <h5>Jollof Rice</h5>
        <p>Spicy and delicious West African favorite.</p>
        <div class="price"><span class="old-price">₦2500</span><span class="new-price">₦2000</span></div>
        <button class="add-to-cart" onclick="incrementCart('Jollof Rice', '₦2000')">Add to Cart</button>
      </div>
      <div class="menu-item">
        <img src="assets/images/food3.png" alt="Dish 1">
        <h5>Jollof Rice</h5>
        <p>Spicy and delicious West African favorite.</p>
        <div class="price"><span class="old-price">₦2500</span><span class="new-price">₦2000</span></div>
        <div style="display:flex;">
            <div class="star-rating">
                <span>★</span>
                <span>★</span>
                <span>★</span>
                <span>★</span>
                <span>★</span>
            </div>
            <button class="add-to-cart" onclick="incrementCart('Jollof Rice', '₦2000')">Add to Cart</button>
        </div>
      </div>
      <!-- Add more items here -->
    </div>
  </div>

  <div class="bottom-nav">
    <a href="index.html" class="nav-item">
        <i class="fas fa-home"></i>
        <span>Home</span>
    </a>
    <a href="order.html" class="nav-item">
        <i class="fas fa-shopping-bag"></i>
        <span>Order</span>
    </a>
    <a href="explore.html" class="nav-item">
        <i class="fas fa-compass"></i>
        <span>Explore</span>
    </a>
    <a href="profile.html" class="nav-item">
        <i class="fas fa-user"></i>
        <span>Profile</span>
    </a>
    </div>
    <!-- Moved cart div here -->
<div class="cart" onclick="toggleCartPopup()" style="position: fixed; bottom: 140px; right: 20px; z-index: 1001;">
  <span class="cart-icon">🛒</span>
  <span class="cart-counter" id="cart-counter">0</span>
</div>

<!-- Back to Top button stays below -->
<button onclick="scrollToTop()" id="backToTopBtn" title="Go to top">↑</button>
  <script>
    let cartCount = 0;
    let cartItems = [];

    function toggleNav() {
      const navLinks = document.getElementById("nav-links");
      navLinks.classList.toggle("active");
    }

    function incrementCart(item, price) {
      cartCount++;
      cartItems.push(`${item} - ${price}`);
      document.getElementById("cart-counter").textContent = cartCount;
      document.getElementById("cart-items").innerHTML = cartItems.map(i => `<li>${i}</li>`).join('');
    }

    function toggleCartPopup() {
      const popup = document.getElementById("cart-popup");
      const overlay = document.getElementById("overlay");
      popup.classList.toggle("active");
      overlay.style.display = popup.classList.contains("active") ? "block" : "none";
    }

    function payWithSquad() {
      alert("Checkout triggered."); // You can integrate Squad here
    }

    /*  Back to top js code */
    // Show the button when scrolling down
    window.onscroll = function () {
        const btn = document.getElementById("backToTopBtn");
        if (document.body.scrollTop > 300 || document.documentElement.scrollTop > 300) {
            btn.style.display = "block";
        } else {
            btn.style.display = "none";
        }
        };

        // Scroll to top when button is clicked
        function scrollToTop() {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    }

  </script>
</body>
</html>
