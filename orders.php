<?php
session_start();
include "dbcon.php";

if (!isset($_SESSION['user_id'])) {
    echo "User Not Found!";
    header("Location: signin.php");
    exit();
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
  <title>DELISHGO UI</title>
  <style>
    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      font-family: 'Segoe UI', sans-serif;
      background-color: #fdf7f5;
      padding: 16px;
    }

    .nav {
      position: fixed;
      bottom: 0;
      left: 0;
      right: 0;
      background: white;
      border-top: 1px solid #ddd;
      display: flex;
      justify-content: space-around;
      padding: 10px 0;
    }

    .nav div {
      flex: 1;
      text-align: center;
      color: #999;
      font-size: 12px;
    }

    .nav i {
      display: block;
      font-size: 18px;
      margin-bottom: 4px;
    }

    .nav .active {
      color: #FF6C22;
    }

    header {
      text-align: center;
      margin-bottom: 16px;
      display: flex;
    }

    header h1 {
      color: #ff5a00;
      font-size: 14px;
    }

    header h2 {
      font-size: 24px;
      margin-top: 4px;
    }

    .brand {
      color: #ff5722;
      font-weight: bold;
      font-size: 14px;
    }

    .location {
      font-size: 20px;
      font-weight: 600;
      color: #000;
      flex: 1;
      text-align: center;
      white-space: nowrap;
      overflow: hidden;
      text-overflow: ellipsis;
    }

    .filter {
      font-size: 16px;
      color: #333;
    }

    .carousel {
      position: relative;
      border-radius: 16px;
      overflow: hidden;
      margin-bottom: 12px;
    }

    .carousel img {
      width: 100%;
      height: auto;
      display: block;
    }

    .dots {
      position: absolute;
      bottom: 10px;
      left: 50%;
      transform: translateX(-50%);
      display: flex;
      gap: 5px;
    }

    .dot {
      width: 8px;
      height: 8px;
      border-radius: 50%;
      background-color: #ddd;
    }

    .dot.active {
      background-color: #fff;
    }

    .section-title {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin: 16px 0 8px;
    }

    .section-title h2 {
      font-size: 20px;
      font-weight: 600;
      color: #333;
    }

    .see-all {
      color: green;
      font-weight: 500;
      font-size: 14px;
    }

    .card-list {
      display: grid;
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
      width: 50%;
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
      background-color: #4caf50;
      color: white;
      font-weight: bold;
      padding: 2px 6px;
      border-radius: 6px;
      font-size: 12px;
    }

    .restaurant-section {
      margin-top: 24px;
    }

    .restaurant-section h3 {
      font-size: 20px;
      margin-bottom: 12px;
    }

    .restaurant-card {
      /* margin-top: 8px; */
      min-width: 180px;
      background-color: #fff;
      border-radius: 16px;
      overflow: hidden;
      flex-shrink: 0;
      margin-bottom: 20px;
      box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2); /* x, y, blur, color */
    }

    .restaurant-card img{
        display: block;
        border-top-left-radius: 10px;
        border-top-right-radius: 10px;
        width: 100%;
        height: 200px;
        object-fit: cover;
    }

    .restaurant-title {
      font-size: 20px;
      font-weight: bold;
      margin-bottom: 4px;
    }

    .restaurant-tags {
      font-size: 14px;
      color: gray;
      margin-bottom: 8px;
    }

    .restaurant-details {
      display: flex;
      flex-wrap: wrap;
      gap: 12px;
      font-size: 14px;
      color: #444;
    }

    .restaurant-details span {
      display: flex;
      align-items: center;
    }

    .res-content {
      padding: 8px 12px;
    }
    .card-list {
      display: relative;
      overflow-x: auto;
      gap: 16px;
      padding-bottom: 8px;
    }
    .bot button{
      color: white;
      font-weight: bold;
      padding: 2px 6px;
      border-radius: 6px;
      font-size: 12px;
      width:100px;
      height:30px;
      margin-left: 20px;
    }
    .bot .a{
        background-color:rgb(255, 30, 0);
        margin-top:10px;
    }
    .bot .b{
        background-color: #4caf50;
    }
    .bot button:hover{
        background-color:rgb(112, 116, 112);
    }

    @media (min-width: 768px) {
      .card-list {
        gap: 24px;
      }

      .card {
        min-width: 200px;
      }

      .carousel img {
        height: 300px;
        object-fit: cover;
      }

      .restaurant-card{
        min-width: 200px;
      }

      .restaurant-card img{
        height: 300px;
        object-fit: cover;
      }
    }
    a {
  text-decoration: none;
}

header {
  position: sticky;
  top: 0;
  z-index: 999;
  background-color: #fff;
  display: flex;
  align-items: center;
  justify-content: space-between;
  padding: 14px 26px;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05);
  animation: slideInTop 0.5s ease-out;
  border-bottom-right-radius: 10px;
  border-bottom-left-radius: 10px;
}

@keyframes slideInTop {
  from {
    transform: translateY(-100%);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.brand {
  font-size: 14px;
  font-weight: 700;
  color: #FF6C22;
}

.location {
  flex: 1;
  text-align: center;
  font-size: 16px;
  font-weight: 600;
  color: #222;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  padding: 0 10px;
}

.filter {
  font-size: 14px;
  padding: 6px 10px;
  background-color: #ffe6d9;
  border-radius: 10px;
  color: #FF6C22;
  transition: background-color 0.3s ease, transform 0.2s ease;
  cursor: pointer;
}

.filter:hover {
  background-color: #FF6C22;
  color: #fff;
  transform: scale(1.05);
}

@media (min-width: 768px) {
  .location {
    font-size: 18px;
  }

  .filter {
    font-size: 16px;
  }
}

  </style>
</head>
<body>

  <header>
    <div class="brand">DELISHGO</div>
    <div class="location">Track Your Order Here!</div>
    <div class="filter">Real Time</div>
  </header>

  <!-- Featured Patner Started Here! -->
  <div class="card-list">
  <?php
    $menu_query = "SELECT * FROM orderss WHERE user_id = $user_id";
    $menu_result = mysqli_query($conn, $menu_query);
    ?>
    <div class="card">
    <?php
        if (mysqli_num_rows($menu_result) > 0) {
            while ($item = mysqli_fetch_assoc($menu_result)) {
                ?>
      <div style="display: flex;">
        <img src="<?php echo htmlspecialchars($item['product_picture']); ?>" alt="<?php echo htmlspecialchars($item['product_name']); ?>" />
      <div>
        <h5 style="margin-left:30%;width:100px;margin-top:10px;color:orangered;">Order Status</h5>
        <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Pending...</h4><span>0 min</span></div>
        <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Accepted</h4><span>2 min</span></div>
        <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Picked-Up</h4><span>3 min</span></div>
        <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Pending...</h4><span>0 min</span></div>
        <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Delivered</h4><span>0 min</span></div>
      </div>
      </div>
      <div style="display:flex;">
            <div style="margin-button:10px;">
                <h5 style="margin-left:30%;width:100px;margin-top:10px;color:orangered;">Order Info</h5>
                <div>
                    <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Order Name:</h4><span><?php echo htmlspecialchars($item['product_name']); ?></span></div>
                    <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Vendor Name:</h4><span><?php echo htmlspecialchars($item['vendor_name']); ?></span></div>
                    <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Tracking ID:</h4><span><?php echo htmlspecialchars($item['Order_id']); ?></span></div>
                    <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Quantity:</h4><span><?php echo htmlspecialchars($item['order_quantity']); ?></span></div>
                </div>
            </div>
            <div class="bot" style="display:grid;">
                <button class="a">Cancel Order</button>
                <button class="b">Track Order</button>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<p>No Orders Available .</p>";
        }
        ?>
    </div>



    <div class="card">
      <div style="display: flex;">
        <img src="images/Coppee1.jpg" alt="The Halal Guys" />
      <div>
        <h5 style="margin-left:30%;width:100px;margin-top:10px;color:orangered;">Order Status</h5>
        <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Pending...</h4><span>0 min</span></div>
        <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Accepted</h4><span>2 min</span></div>
        <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Picked-Up</h4><span>3 min</span></div>
        <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Pending...</h4><span>0 min</span></div>
        <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Delivered</h4><span>0 min</span></div>
      </div>
      </div>
      <div style="display:flex;">
            <div style="margin-button:10px;">
                <h5 style="margin-left:30%;width:100px;margin-top:10px;color:orangered;">Order Info</h5>
                <div>
                    <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Order Name:</h4><span>Pizza 5 Slides</span></div>
                    <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Vendor Name:</h4><span>LM Barkery</span></div>
                    <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Tracking ID:</h4><span>TYHB-284</span></div>
                    <div class="meta-info" style="display:flex; margin-left:10px;"><i class="fas fa-hospital"></i><h4>Quantity:</h4><span>4</span></div>
                </div>
            </div>
            <div class="bot" style="display:grid;">
                <button class="a">Cancel Order</button>
                <button class="b">Track Order</button>
            </div>
        </div>
    </div>

    <div class="card">
      <img src="images/Coppee1.jpg" alt="Mario's" />
      <div class="card-content">
        <div class="restaurant-name">Mario's</div>
        <div class="location-text">Colarodo, San Francisco</div>
        <div class="meta-info">
          <span class="rating">4.6</span>
          <span>25 min</span>
          <span>•</span>
          <span>Free delivery</span>
        </div>
      </div>
    </div>
  </div>
  <!-- Featured Patner Ended Here! -->

  <!-- Navigation Bar -->
  <div class="nav">
    <div><i class="fas fa-home"></i>Home</div>
    <div> <a href="stores.php"><i class="fas fa-building"></i></a>Stores</div>
    <div><i class="fas fa-hospital"></i>Health</div>
    <div class="active"><i class="fas fa-location-arrow tracker-icon"></i>Orders</div>
    <div><a href="profile.html"><i class="fas fa-user"></i></a>Profile</div>
  </div>
</body>
</html>
