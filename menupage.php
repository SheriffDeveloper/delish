<?php
session_start();
include "dbcon.php";

// $_SESSION['email'];
// $_SESSION['name'];
// $vendor = ['vendor_name' => 'DelishGo']; // Just as fallback

if (!isset($_SESSION['user_email'])) {
  header("Location: signin.php");
  exit();
}

$userEmail = $_SESSION['user_email']; // ✅ You can now use this in payment logic

if (!isset($_GET['vendor_id'])) {
    echo "Vendor ID not provided!";
    exit();
}

$vendor_id = intval($_GET['vendor_id']); // Prevent SQL injection
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Menu Page</title>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
  <script src="https://checkout.flutterwave.com/v3.js"></script>
</head>
<style>
     body {
  margin: 0;
  font-family: sans-serif;
  background-color: #fceeea;
}

#topBar {
  position: fixed;
  top: 0;
  left: 0;
  right: 0;
  background: #fceeea;
  height: 56px;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 0 16px;
  z-index: 1000;
  box-shadow: 0 2px 5px rgba(0,0,0,0.1);
}

.topBar-title {
  font-weight: bold;
  font-size: 16px;
  opacity: 0;
  transition: opacity 0.3s ease;
}

.backBtn,
.shareBtn {
  background: none;
  border: none;
  font-size: 18px;
  cursor: pointer;
}

.container {
  margin-top: 56px;
}

.restaurant-header {
  padding: 16px;
}

.restaurant-header h1 {
  margin: 0;
  font-size: 24px;
}

.categories, .ratings, .delivery-info {
  color: gray;
  font-size: 14px;
  margin: 6px 0;
}

.takeaway-btn {
  margin-left: 10px;
  padding: 8px 16px;
  border: 1px solid #8b4d3b;
  background: none;
  color: #8b4d3b;
  border-radius: 10px;
  cursor: pointer;
}

.featured-section {
  background-color: white;
  padding: 16px;
}

.featured-scroll {
  display: flex;
  overflow-x: auto;
  gap: 12px;
  padding: 12px 0;
}

.featured-scroll a {
  text-decoration: none;
  color: black;
  min-width: 140px;
}

.featured-scroll img {
  width: 100%;
  height: 120px;
  border-radius: 12px;
  object-fit: cover;
}

.tabs {
  display: flex;
  justify-content: space-around;
  padding: 16px;
  background-color: white;
  font-size: 18px;
}

.tabs span {
  cursor: pointer;
  padding: 6px;
}

.tabs .active {
  font-weight: bold;
  border-bottom: 2px solid #8b4d3b;
}

.menu-list {
  background-color: white;
  padding: 0 16px 80px 16px;
  /* margin-top: 10px; */
  display: grid;
  grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
  gap: 20px;
  transition: all 0.3s ease;
}

.menu-item {
  display: flex;
  gap: 12px;
  /* margin: 16px 0; */
  min-width: 180px;
  background-color: #fff;
  border-radius: 16px;
  overflow: hidden;
  /* flex-shrink: 0; */
  box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* x, y, blur, color */
  transition: transform 0.2s ease, ox-shadow 0.2s ease;
  margin-bottom: 10px;
}

.menu-item:hover{
  transform: translateY(-5px);
  box-shadow: 0.4px 16px rgba(0, 0, 0, 0.15);
}

.menu-item.clicked {
  transform: scale(0.98);
  box-shadow: 0 0 10px rgba(0,0,0,0.1);
}

.menu-item img {
  width: 90px;
  height: 90px;
  margin-top: 10px;
  border-radius: 12px;
  object-fit: cover;
}

.menu-text {
  flex: 1;
}

.menu-text h3 {
  margin: 0;
  font-size: 18px;
  margin-top: 20px;
}

.menu-text p {
  color: gray;
  font-size: 14px;
  margin-top: -2px;
}

@media (max-width: 768px) {
  .menu-list {
    grid-template-columns: repeate(auto-fit, minmax(150px, 1fr));
  }
}

.price-info {
  display: flex;
  justify-content: space-between;
  margin-top: -5px;
  font-size: 14px;
}

.price {
  color: rgb(255, 60, 0);
  font-weight: bold;
  margin-top: -10px;
  margin-right: 30px;
}

.dish-type{
  margin-top: -10px;
}
.price-infos {
  display: flex;
  justify-content: space-between;
  margin-top: -5px;
  font-size: 14px;
}

.prices {
  color: rgb(0, 0, 0);
  font-weight: bold;
  margin-top: 10px;
  margin-right: 30px;
}
.not_prices{
  color: rgb(0, 0, 0);
  font-weight: bold;
  margin-top: 10px;
  margin-right: 30px;
}

/* Back to Top Button */
#backToTop {
  position: fixed;
  width: 50px;
  height: 50px;
  bottom: 24px;
  right: 24px;
  display: none;
  padding: 12px;
  border-radius: 50%;
  background-color: #ff4800;
  color: white;
  border: none;
  font-size: 18px;
  cursor: pointer;
  z-index: 999;
}
a {
  text-decoration: none;
}
.section-title {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: -20px 0 8px;
    }

    .section-title h2 {
      font-size: 20px;
      font-weight: 600;
      color: #333;
    }

    .see-all {
      color: rgb(255, 94, 0);
      font-weight: 500;
      font-size: 14px;
    }

    .card-list {
      display: flex;
      overflow-x: auto;
      gap: 16px;
      padding-bottom: 8px;
    }

    .card {
      min-width: 180px;
      background-color: #fff;
      border-radius: 16px;
      overflow: hidden;
      flex-shrink: 0;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* x, y, blur, color */
    }

    .card img {
      width: 100%;
      height: 120px;
      object-fit: cover;
    }

    .card-content {
      padding: 8px 12px;
    }
    .restaurant-name {
      font-size: 16px;
      font-weight: 600;
      color: #222;
    }

    .location-text {
      font-size: 13px;
      color: #888;
      margin-bottom: 6px;
    }

    .meta-info {
      display: flex;
      flex-wrap: wrap;
      align-items: center;
      gap: 8px;
      font-size: 13px;
      color: #666;
    }

    .rating {
      background-color: #ff4800;
      color: white;
      font-weight: bold;
      padding: 2px 6px;
      border-radius: 6px;
      font-size: 12px;
    }


  /* Floating Cart Button */
#floatingCart {
  position: fixed;
  bottom: 90px;
  right: 24px;
  width: 50px;
  height: 50px;
  background-color: #8b4d3b;
  color: white;
  border: none;
  border-radius: 50%;
  font-size: 20px;
  cursor: pointer;
  z-index: 1000;
  display: flex;
  justify-content: center;
  align-items: center;
  box-shadow: 0 4px 12px rgba(0,0,0,0.2);
}

.modal {
  display: none;
  position: fixed;
  z-index: 2000;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;
  overflow-y: auto;
  background-color: rgba(0,0,0,0.5);
}

.modal-content {
  background-color: #fff;
  margin: 10% auto;
  padding: 20px;
  border-radius: 16px;
  width: 90%;
  max-width: 400px;
  position: relative;
  box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
}

.close {
  position: absolute;
  right: 16px;
  top: 12px;
  font-size: 24px;
  font-weight: bold;
  cursor: pointer;
}

.cart-item {
  display: flex;
  align-items: center;
  gap: 12px;
  margin-bottom: 16px;
  border-bottom: 1px solid #eee;
  padding-bottom: 10px;
}

.cart-item img {
  width: 60px;
  height: 60px;
  border-radius: 10px;
  object-fit: cover;
}

.cart-item-info {
  flex: 1;
}

.cart-summary {
  margin-top: 16px;
  border-top: 1px solid #ccc;
  padding-top: 10px;
}

.cart-summary p {
  margin: 6px 0;
  font-size: 16px;
  display: flex;
  justify-content: space-between;
}

.price {
  color: #ff4800;
  font-weight: bold;
}

.checkout-btn {
  width: 100%;
  margin-top: 12px;
  padding: 12px;
  background-color: #ff4800;
  color: white;
  font-size: 16px;
  border: none;
  border-radius: 10px;
  cursor: pointer;
}

/* Quantity Controls */
.qty-controls {
  display: flex;
  align-items: center;
  margin-top: 6px;
}

.qty-controls button {
  background-color: #eee;
  border: none;
  font-size: 18px;
  width: 28px;
  height: 28px;
  cursor: pointer;
  border-radius: 6px;
  margin: 0 4px;
}

.qty-controls span {
  min-width: 20px;
  text-align: center;
  font-weight: bold;
}

/* Responsive Adjustments */
@media (max-width: 480px) {
  .modal-content {
    margin-top: 20%;
    padding: 16px;
  }

  .cart-item img {
    width: 50px;
    height: 50px;
  }

  .checkout-btn {
    font-size: 14px;
    padding: 10px;
  }
}
.delete-btn {
  background: none;
  border: none;
  color: #c00;
  font-size: 18px;
  margin-left: 8px;
  cursor: pointer;
  transition: transform 0.2s;
}

.delete-btn:hover {
  transform: scale(1.2);
}
.undo-snackbar {
  position: fixed;
  bottom: 80px;
  left: 50%;
  transform: translateX(-50%);
  background-color: #333;
  color: white;
  padding: 12px 20px;
  border-radius: 8px;
  display: flex;
  gap: 16px;
  align-items: center;
  opacity: 0;
  pointer-events: none;
  transition: all 0.3s ease;
  z-index: 1000;
}

.undo-snackbar button {
  background: none;
  border: 1px solid white;
  color: white;
  padding: 4px 10px;
  border-radius: 6px;
  cursor: pointer;
}

.undo-snackbar.show {
  opacity: 1;
  pointer-events: auto;
}
.cart-item {
  transition: opacity 0.3s ease;
}

.cart-item.fade-in {
  opacity: 0;
  animation: fadeIn 0.3s forwards;
}

@keyframes fadeIn {
  to { opacity: 1; }
}


#snackbar {
  visibility: hidden;
  min-width: 200px;
  background-color: #323232;
  color: #fff;
  text-align: center;
  border-radius: 8px;
  padding: 10px;
  position: fixed;
  z-index: 10;
  bottom: 30px;
  left: 50%;
  transform: translateX(-50%);
  opacity: 0;
  transition: opacity 0.5s, bottom 0.5s;
}

#snackbar.show {
  visibility: visible;
  opacity: 1;
  bottom: 50px;
}

#cart-icon {
  position: fixed;
  top: 20px;
  right: 20px;
  font-size: 24px;
  cursor: pointer;
  position: fixed;
}

#cart-icon.animate {
  animation: cartBounce 0.6s ease;
}

@keyframes cartBounce {
  0%, 100% { transform: scale(1); }
  50% { transform: scale(1.3); }
}

#cart-count {
  background: red;
  color: white;
  border-radius: 50%;
  padding: 2px 6px;
  font-size: 12px;
  position: relative;
  top: -10px;
  right: -10px;
}

.add-to-cart-btn {
  margin-top: 10px;
  padding: 10px 16px;
  background-color: #8b4d3b;
  color: #fff;
  border: none;
  border-radius: 12px;
  font-size: 14px;
  font-weight: 500;
  cursor: pointer;
  transition: background-color 0.3s ease;
  width: fit-content;
}

.add-to-cart-btn:hover {
  background-color:rgb(148, 142, 140);
}


/*//Double Model Start Here*/
.payment-btn {
      margin: 1rem;
      padding: 1rem 2rem;
      font-size: 1rem;
      border: none;
      border-radius: 0.75rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }
.crypto-btn {
      background: #10b981;
      color: white;
    }

    .bank-btn:hover {
      background: #1d4ed8;
    }

    .crypto-btn:hover {
      background: #059669;
    }

    .modal {
      position: fixed;
      top: 0; left: 0;
      width: 100%; height: 100%;
      background: rgba(0, 0, 0, 0.5);
      display: none;
      justify-content: center;
      align-items: center;
    }

    .modal-content {
      background: white;
      padding: 2rem;
      border-radius: 1rem;
      max-width: 400px;
      width: 90%;
      text-align: center;
      box-shadow: 0 5px 15px rgba(0,0,0,0.2);
    }

    .wallet-option {
      margin-top: 1rem;
      padding: 0.75rem 1rem;
      border: 2px solid #e5e7eb;
      border-radius: 0.5rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .wallet-option:hover {
      background-color: #f3f4f6;
    }

    .close-btn {
      margin-top: 1.5rem;
      background: #ef4444;
      color: white;
      border: none;
      padding: 0.5rem 1.5rem;
      border-radius: 0.5rem;
      cursor: pointer;
    }

</style>
<body>

<?php
$vendor_query = "SELECT * FROM vendors WHERE id = $vendor_id";
$vendor_result = mysqli_query($conn, $vendor_query);

if (!$vendor_result || mysqli_num_rows($vendor_result) == 0) {
    echo "Restaurant not found!";
    exit();
}

$vendor = mysqli_fetch_assoc($vendor_result);
?>

<!-- Top Bar -->
<header id="topBar">
  <button class="backBtn"><a href="restaurants.php"><i class="fas fa-arrow-left"></a></i></button>
  <span class="topBar-title" id="scrollTitle"><?php echo htmlspecialchars($vendor['vendor_name']); ?></span>
  <button class="shareBtn">
    <i class="fas fa-shopping-cart cart-icon" title="Cart"></i>
    </button>
</header>


<!-- Main Content -->
<div class="container">

  <!-- Header Section -->
  <section class="restaurant-header">
    <h1><?php echo htmlspecialchars($vendor['vendor_name']); ?></h1>
    <div class="categories"><?php echo htmlspecialchars($vendor['description']); ?></div>
    <div class="categories"><?php echo htmlspecialchars($vendor['address']); ?></div>
    <div class="ratings">
      <span>4.3 ⭐</span>
      <span>200+ Ratings</span>
    </div>
    <div class="delivery-info">
      <span>💵 Free Delivery</span>
      <span>⏱ 25 Minutes</span>
      <button class="takeaway-btn">Contact Us</button>
    </div>
  </section>

  <?php
    $menu_query = "SELECT * FROM products WHERE vendor_id = $vendor_id";
    $menu_result = mysqli_query($conn, $menu_query);
    ?>

  <!-- Tabs -->
  <div class="tabs">
    <span class="active">Most Populars</span>
    <span>Recomended</span>
  </div>

  <!-- Menu Items -->
    <!-- Hello cart gpt. this is the menu (Start)-->
  <section class="menu-list">
  <?php
        if (mysqli_num_rows($menu_result) > 0) {
            while ($item = mysqli_fetch_assoc($menu_result)) {
                ?>
                    <div class="menu-item">
                        <img src="uploads/<?php echo htmlspecialchars($item['product_picture']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>">
                        <div class="menu-text">
                            <h3><?php echo htmlspecialchars($item['product_name']); ?></h3>
                            <p><?php echo htmlspecialchars($item['description']); ?></p>
                            <div class="price-info">
                                <span class="dish-type"><?php echo htmlspecialchars($item['category']); ?></span>
                                <span class="price"><?php echo htmlspecialchars($item['quantity']); ?> kg</span>
                                <!-- <button>Add</button> -->
                            </div>
                            <div class="price-infos">
                                <span style="margin-top:10px;" class="price"><?php echo htmlspecialchars($item['no_of_product']); ?></span>
                                <del class="not_prices"><span>&#8358;</span><?php echo number_format($item['not_price']); ?></del>
                                <span class="prices"><span>&#8358;</span><?php echo number_format($item['price']); ?></span>
                                <button class="add-to-cart-btn"> <span>&#43;</span></button>
                            </div>
                        </div>
                    </div>
    <?php
            }
        } else {
            echo "<p>No menu items available for this restaurant.</p>";
        }
        ?>
  </section>
</div>

<!-- Back to Top Button -->
<button id="backToTop" title="Back to Top"><i class="fas fa-arrow-up"></i></button>

<!-- Floating Cart Icon -->
<button style="background-color: green;" id="floatingCart" title="View Cart">
  <i class="fas fa-shopping-cart"></i>
</button>

<div id="snackbar">Added to cart successfully!</div>


<!-- Cart Modal -->
<div id="cartModal" class="modal">
  <div class="modal-content">
    <span class="close">&times;</span>
    <h4 style="">Your Cart</h4>
    <div class="cart-items" id="cartItemsContainer">
      <!-- Dynamic Items Inject Here -->
    </div>
    <div class="cart-summary">
        <p>Delivery Fee: <span class="price"><span>&#8358;</span> <span id="deliveryFee">500</span></span></p>
        <p>Quantity: <span class="price"><span id="quantity">10kg</span></span></p>
        <p><strong>Total: <span class="price"><span>&#8358;</span> <span id="cartTotal">0</span></span></strong></p>
        <button id="payNowBtn" class="checkout-btn">Pay with Flutterwave</button>
        <button class="checkout-btn crypto-btn" onclick="openCryptoModal()">Pay with Crypto</button>
    </div>
  </div>

</div>
<!-- Add this inside your HTML, below the main cart modal -->
<div id="cryptoModal" class="modal">
  <div class="modal-content">
    <h3>Select Crypto Network</h3>
    <div class="wallet-option" onclick="payWithPhantom()">Solana (Phantom)</div>
    <div class="wallet-option" onclick="payWithSolflare()">Solana (Solflare)</div>
    <div class="wallet-option" onclick="payWithMetaMask()">Ethereum (MetaMask)</div>
    <button class="close-btn" onclick="closeCryptoModal()">Cancel</button>
  </div>
</div>

<div id="undoSnackbar" class="undo-snackbar">
  <span>Item removed</span>
  <button onclick="undoDelete()">Undo</button>
</div>


<!-- Snackbar -->
<div id="snackbar">Item added to cart</div>


<script>
    const topBarTitle = document.getElementById('scrollTitle');
const backToTop = document.getElementById('backToTop');

window.addEventListener('scroll', () => {
  // Show title after 150px
  if (window.scrollY > 150) {
    topBarTitle.style.opacity = '1';
  } else {
    topBarTitle.style.opacity = '0';
  }

  // Show back to top
  if (window.scrollY > 300) {
    backToTop.style.display = 'block';
  } else {
    backToTop.style.display = 'none';
  }
});

backToTop.addEventListener('click', () => {
  window.scrollTo({
    top: 0,
    behavior: 'smooth'
  });
});
</script>

<script>
  const cartItems = [];

  document.addEventListener("DOMContentLoaded", () => {
    const menuItems = document.querySelectorAll(".menu-item");
    const cartItemsContainer = document.getElementById("cartItemsContainer");
    const cartTotalEl = document.getElementById("cartTotal");
    const deliveryFee = 500;
    const cartModal = document.getElementById("cartModal");
    const floatingCart = document.getElementById("floatingCart");
    const closeModal = document.querySelector(".modal .close");

    function calculateTotal() {
      let total = cartItems.reduce((sum, item) => sum + item.price * item.qty, 0);
      cartTotalEl.textContent = total + deliveryFee;
    }

    function renderCart() {
      cartItemsContainer.innerHTML = "";
      cartItems.forEach((item, index) => {
        const cartItem = document.createElement("div");
        cartItem.classList.add("cart-item", "fade-in");
        cartItem.innerHTML = `
          <img src="${item.image}" alt="${item.title}">
          <div class="cart-item-info">
            <strong>${item.title}</strong>
            <p>${item.desc}</p>
            <div class="qty-controls">
              <button class="decrease" data-index="${index}">-</button>
              <span>${item.qty}</span>
              <button class="increase" data-index="${index}">+</button>
              <button class="delete-btn" data-index="${index}">&times;</button>
              <p>${item.price}</p>
            </div>
          </div>
        `;
        cartItemsContainer.appendChild(cartItem);
      });
      calculateTotal();
    }

    function addToCart(title, desc, price, image) {
      const existing = cartItems.find(item => item.title === title);
      if (existing) {
        existing.qty += 1;
      } else {
        cartItems.push({ title, desc, price, image, qty: 1 });
      }
      renderCart();
    }

    menuItems.forEach(item => {
      item.addEventListener("click", () => {
        const title = item.querySelector("h3").innerText;
        const desc = item.querySelector("p").innerText;
        const priceText = item.querySelector(".price-infos .prices")?.innerText || "0";
        const price = parseFloat(priceText.replace(/[^\d.]/g, ""));
        const image = item.querySelector("img").src;

        addToCart(title, desc, price, image);
        cartModal.style.display = "block";
      });
    });

    floatingCart.addEventListener("click", () => {
      cartModal.style.display = "block";
      renderCart();
    });

    closeModal.addEventListener("click", () => {
      cartModal.style.display = "none";
    });

    cartItemsContainer.addEventListener("click", e => {
      const index = e.target.dataset.index;
      if (e.target.classList.contains("increase")) {
        cartItems[index].qty++;
        renderCart();
      } else if (e.target.classList.contains("decrease")) {
        cartItems[index].qty--;
        if (cartItems[index].qty <= 0) cartItems.splice(index, 1);
        renderCart();
      } else if (e.target.classList.contains("delete-btn")) {
        cartItems.splice(index, 1);
        renderCart();
      }
    });
  });


  </script>
  <script>
  document.querySelectorAll('.add-to-cart-btn').forEach(btn => {
    btn.addEventListener('click', () => {
      const snackbar = document.getElementById("snackbar");
      snackbar.textContent = "Added to cart successfully!";
      snackbar.className = "show";
      setTimeout(() => {
        snackbar.className = snackbar.className.replace("show", "");
      }, 3000);
    });
  });
</script>

<script>
document.getElementById('payNowBtn').addEventListener('click',
 function () {
   FlutterwaveCheckout({
   public_key: "FLWPUBK_TEST-746bfdf6fc4beca78103828e21289cb2-X", // Flutterwave public key
   tx_ref: "txref_" + Date.now(),
    amount: 5000, // total amount
    currency: "NGN",
    payment_options: "card,ussd,banktransfer,barter",
    customer: {
      email: "muhammadsheriffsmss@gmail.com",
      phone_number: "08048604462",
      name: "Sheriff Muhammad",
    },
    callback: function (data) {
       console.log(data);
       alert('Payment successful. TxRef: ' + data.tx_ref); // you can redirect or save transaction here
      },
      onclose: function () {
         console.log('Payment closed');
        },
        customizations: {
           title: "DelishGo Orders",
           description: "Payment for food delivery",
           logo: "https://delishgofoods.com/logo.png", // Optional
          },
        });
        });
</script>

<script>
  const cartModal = document.getElementById('cartModal');
  const floatingCart = document.getElementById('floatingCart');
  const closeModal = document.querySelector('.modal .close');

  // Open Modal
  floatingCart.addEventListener('click', () => {
    cartModal.style.display = 'block';
    document.body.style.overflow = 'hidden'; // Prevent background scroll
  });

  // Close Modal
  closeModal.addEventListener('click', () => {
    cartModal.style.display = 'none';
    document.body.style.overflow = ''; // Allow scrolling again
  });

  // Close on outside click
  window.addEventListener('click', (e) => {
    if (e.target === cartModal) {
      cartModal.style.display = 'none';
      document.body.style.overflow = '';
    }
  });
  
  // Open Crypto Modal
function openCryptoModal() {
  document.getElementById('cryptoModal').style.display = 'flex';
}

function closeCryptoModal() {
  document.getElementById('cryptoModal').style.display = 'none';
}

function getCartData() {
  return {
    items: cartItems,
    deliveryFee: 500,
    total: parseFloat(document.getElementById("cartTotal").textContent)
  };
}

async function payWithPhantom() {
  if (!window.solana || !window.solana.isPhantom) {
    alert("Please install Phantom Wallet!");
    return;
  }

  try {
    await window.solana.connect();
    const publicKey = window.solana.publicKey.toString();
    const cartData = getCartData();

    // Simulate payment (replace this with your backend/contract interaction)
    alert("Connected to Phantom: " + publicKey + "\nPaying: " + cartData.total + " SOL");

    closeCryptoModal();
    alert("Payment Successful via Phantom");
  } catch (err) {
    console.error(err);
    alert("Phantom Wallet payment failed.");
  }
}

function payWithSolflare() {
  alert("Solflare integration coming soon.");
  closeCryptoModal();
}

function payWithMetaMask() {
  if (typeof window.ethereum === 'undefined') {
    alert("Please install MetaMask!");
    return;
  }

  window.ethereum.request({ method: 'eth_requestAccounts' }).then(accounts => {
    const userAddress = accounts[0];
    const cartData = getCartData();

    alert("Connected to MetaMask: " + userAddress + "\nPaying: " + cartData.total + " ETH");

    closeCryptoModal();
    alert("Payment Successful via MetaMask");
  }).catch(err => {
    console.error(err);
    alert("MetaMask payment failed.");
  });
}
</script>

</body>
</html>
