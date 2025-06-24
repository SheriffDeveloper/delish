<?php
session_start();

// Include the database connection
$dbcon_path = "dbcon.php";
if (file_exists($dbcon_path)) {
    include $dbcon_path;
} else {
    die("Error: dbcon.php file not found at $dbcon_path");
}

// Ensure the connection is established
if (!$conn) {
    die("Database connection failed: " . mysqli_connect_error());
}
if (!isset($_SESSION['user_id'])) {
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
      display: flex;
      overflow-x: auto;
      gap: 16px;
      padding-bottom: 8px;
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
  padding: 14px 16px;
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
    <div class="location">Maiduguri, Borno Sta...</div>
    <div class="filter">Filter</div>
  </header>

    <!-- Adverts 1 Section Started Here! -->
  <div class="carousel">
    <img src="images/Coppee1.jpg" alt="Hero Dish" />
    <div class="dots">
      <div class="dot active"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  </div>
    <!-- Adverts 1 Section Ended Here! -->
     <!-- Break/Launch/Dinner Park Started Here! -->
  <div class="section-title">
    <h2>Break Past Parks</h2>
    <div class="see-all">See all</div>
  </div>

  <div class="card-list">
    <div class="card">
      <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93" alt="Coffee Shop" />
      <div class="card-content">
        <div class="restaurant-name">Coffee</div>
        <div class="location-text">Maiduguri</div>
        <div class="meta-info">
          <span class="rating">4.6</span>
          <span>25 min</span>
          <span>•</span>
          <span>Free delivery</span>
        </div>
      </div>
    </div>

    <div class="card">
      <img src="https://images.unsplash.com/photo-1589302168068-964664d93dc0" alt="The Halal Guys" />
      <div class="card-content">
        <div class="restaurant-name">The Halal Guys</div>
        <div class="location-text">Colarodo, San Francisco</div>
        <div class="meta-info">
          <span class="rating">4.6</span>
          <span>25 min</span>
          <span>•</span>
          <span>Free delivery</span>
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
  <!-- Break/Launch/Dinner Park Ended Here! -->

  <!-- Featured Patner Started Here! -->
  <div class="section-title">
    <h2>Featured Partners</h2>
    <div class="see-all">See all</div>
  </div>

  <div class="card-list">
  <?php
        // Fetch products from the database
        $query = "SELECT id, vendor_name, address, description, vendor_image, time_to_delivery FROM featured_partners";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("<p>Error fetching products: " . mysqli_error($conn) . "</p>");
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $vendor_name = $row['vendor_name'];
                $address = $row['address'];
                $description = $row['description'];
                $vendor_image = "uploads/" . $row['vendor_image'];
                $time_to_delivery = $row['time_to_delivery'];

                echo '
                    <a href="menupage.php?vendor_id=' . urlencode($id) . '" style="text-decoration: none; color: inherit;">
      <div class="card">
        <img src="' . htmlspecialchars($vendor_image) . '" alt="' . htmlspecialchars($vendor_name) . '" onerror="this.onerror=null; this.src=\'../uploads/default.jpg\';"/>
        <div class="card-content">
          <div class="restaurant-name">' . htmlspecialchars($vendor_name) . '</div>
          <div class="location-text">' . htmlspecialchars($address) . '</div>
          <div class="meta-info">
            <span class="rating">4.6</span>
            <span>' . htmlspecialchars($time_to_delivery) . ' min</span>
            <span>•</span>
            <span>Free delivery</span>
          </div>
        </div>
      </div>
    </a>';

            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>

    <div class="card">
      <img src="https://images.unsplash.com/photo-1589302168068-964664d93dc0" alt="The Halal Guys" />
      <div class="card-content">
        <div class="restaurant-name">The Halal Guys</div>
        <div class="location-text">Colarodo, San Francisco</div>
        <div class="meta-info">
          <span class="rating">4.6</span>
          <span>25 min</span>
          <span>•</span>
          <span>Free delivery</span>
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
   <!-- Adverts 2 Section Started Here! -->
  <div style="margin-top: 5px;" class="carousel">
    <img src="images/Coppee1.jpg" alt="Hero Dish" />
    <div class="dots">
      <div class="dot active"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  </div>
    <!-- Adverts 2 Section Ended Here! -->

    <!-- Break/Launch/Dinner Park Started Here! -->
  <div class="section-title">
    <h2>Recomended Restaurants</h2>
    <div class="see-all">See all</div>
  </div>

  <div class="card-list">
  <?php
        // Fetch products from the database
        $query = "SELECT id, vendor_name, address, description, vendor_image, time_to_delivery FROM recomended";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("<p>Error fetching products: " . mysqli_error($conn) . "</p>");
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $vendor_name = $row['vendor_name'];
                $address = $row['address'];
                $description = $row['description'];
                $vendor_image = "uploads/" . $row['vendor_image'];
                $time_to_delivery = $row['time_to_delivery'];

                echo '
                    <a href="menupage.php?vendor_id=' . urlencode($id) . '" style="text-decoration: none; color: inherit;">
      <div class="card">
        <img src="' . htmlspecialchars($vendor_image) . '" alt="' . htmlspecialchars($vendor_name) . '" onerror="this.onerror=null; this.src=\'../uploads/default.jpg\';"/>
        <div class="card-content">
          <div class="restaurant-name">' . htmlspecialchars($vendor_name) . '</div>
          <div class="location-text">' . htmlspecialchars($address) . '</div>
          <div class="meta-info">
            <span class="rating">4.6</span>
            <span>' . htmlspecialchars($time_to_delivery) . ' min</span>
            <span>•</span>
            <span>Free delivery</span>
          </div>
        </div>
      </div>
    </a>';

            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>


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
  <!-- Break/Launch/Dinner Park Ended Here! -->


  <div class="restaurant-section">
    <div class="section-title">
        <h2>All Restaurants</h2>
        <a href=""><div class="see-all">See all</div></a>
      </div>
      <?php
        // Fetch products from the database
        $query = "SELECT id, vendor_name, address, description, vendor_image, time_to_delivery FROM vendors";
        $result = mysqli_query($conn, $query);

        if (!$result) {
            die("<p>Error fetching products: " . mysqli_error($conn) . "</p>");
        }

        if (mysqli_num_rows($result) > 0) {
            while ($row = mysqli_fetch_assoc($result)) {
                $id = $row['id'];
                $vendor_name = $row['vendor_name'];
                $address = $row['address'];
                $description = $row['description'];
                $vendor_image = "uploads/" . $row['vendor_image'];
                $time_to_delivery = $row['time_to_delivery'];

                echo '
    <a href="menupage.php?vendor_id=' . urlencode($id) . '" style="text-decoration: none; color: inherit;">
        <div class="restaurant-card">
            <img src="' . htmlspecialchars($vendor_image) . '" alt="' . htmlspecialchars($vendor_name) . '" onerror="this.onerror=null; this.src=\'../uploads/default.jpg\';">
          <div class="res-content">
            <div class="restaurant-title">' . htmlspecialchars($vendor_name) . '</div>
            <div class="restaurant-tags">' . htmlspecialchars($address) . '</div>
            <div class="restaurant-tags">' . htmlspecialchars($description) . '</div>
            <div class="restaurant-details">
                <span>3</span>
                <span>7+ Ratings</span>
                <span>' . htmlspecialchars($time_to_delivery) . ' min</span>
                <span>Free</span>
            </div>
          </div>
        </div>
    </a>';

            }
        } else {
            echo "<p>No products available.</p>";
        }
        ?>
    <a href="res_info.php">
    <div class="restaurant-card">
        <img src="images/restaurant1.jpg" alt="">
      <div class="res-content">
        <div class="restaurant-title">Chell-In Eatery & Barkery</div>
        <div class="restaurant-tags">$$ &bull; African &bull; American &bull; Kanuri food</div>
        <div class="restaurant-details">
            <span>3</span>
            <span>7+ Ratings</span>
            <span>30 Min</span>
            <span>Free</span>
        </div>
      </div>
    </div>
    </a>
  </div>


  <!-- Break/Launch/Dinner Park Started Here! -->
  <div class="section-title">
    <h2>Break Past Parks</h2>
    <div class="see-all">See all</div>
  </div>

  <div class="card-list">
    <div class="card">
      <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93" alt="Coffee Shop" />
      <div class="card-content">
        <div class="restaurant-name">Coffee</div>
        <div class="location-text">Maiduguri</div>
        <div class="meta-info">
          <span class="rating">4.6</span>
          <span>25 min</span>
          <span>•</span>
          <span>Free delivery</span>
        </div>
      </div>
    </div>

    <div class="card">
      <img src="https://images.unsplash.com/photo-1589302168068-964664d93dc0" alt="The Halal Guys" />
      <div class="card-content">
        <div class="restaurant-name">The Halal Guys</div>
        <div class="location-text">Colarodo, San Francisco</div>
        <div class="meta-info">
          <span class="rating">4.6</span>
          <span>25 min</span>
          <span>•</span>
          <span>Free delivery</span>
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
  <!-- Break/Launch/Dinner Park Ended Here! -->

  <!-- Adverts 2 Section Started Here! -->
  <div style="margin-top: 5px;" class="carousel">
    <img src="images/Coppee1.jpg" alt="Hero Dish" />
    <div class="dots">
      <div class="dot active"></div>
      <div class="dot"></div>
      <div class="dot"></div>
      <div class="dot"></div>
    </div>
  </div>
    <!-- Adverts 2 Section Ended Here! -->

    <!-- Break/Launch/Dinner Park Started Here! -->
  <div class="section-title">
    <h2>Break Past Parks</h2>
    <div class="see-all">See all</div>
  </div>

  <div class="card-list">
    <div class="card">
      <img src="https://images.unsplash.com/photo-1509042239860-f550ce710b93" alt="Coffee Shop" />
      <div class="card-content">
        <div class="restaurant-name">Coffee</div>
        <div class="location-text">Maiduguri</div>
        <div class="meta-info">
          <span class="rating">4.6</span>
          <span>25 min</span>
          <span>•</span>
          <span>Free delivery</span>
        </div>
      </div>
    </div>

    <div class="card">
      <img src="https://images.unsplash.com/photo-1589302168068-964664d93dc0" alt="The Halal Guys" />
      <div class="card-content">
        <div class="restaurant-name">The Halal Guys</div>
        <div class="location-text">Colarodo, San Francisco</div>
        <div class="meta-info">
          <span class="rating">4.6</span>
          <span>25 min</span>
          <span>•</span>
          <span>Free delivery</span>
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
  <!-- Break/Launch/Dinner Park Ended Here! -->

..
<
  <!-- Navigation Bar -->
  <div class="nav">
    <div><a href="restaurants.php"><i class="fas fa-home"></i></a>Home</div>
    <div class="active"><i class="fas fa-building"></i>Stores</div>
    <div><i class="fas fa-hospital"></i>Health</div>
    <div><i class="fas fa-location-arrow tracker-icon"></i>Orders</div>
    <div><a href="profile.html"><i class="fas fa-user"></i></a>Profile</div>
  </div>
</body>
</html>
