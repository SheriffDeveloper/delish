<?php
// Get JSON input from frontend
$data = json_decode(file_get_contents("php://input"));

// Squad API Secret Key
$secret_key = "sandbox_sk_cdce2a1ec6c1b59517e2a8add324c354d468b418e6b3";

// Squad API endpoint to verify transactions
$transaction_ref = $data->transaction_ref;
$url = "https://api.squadco.com/transaction/verify/{$transaction_ref}";

// Initialize cURL
$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
curl_setopt($ch, CURLOPT_HTTPHEADER, [
    "Authorization: Bearer $secret_key",
    "Content-Type: application/json"
]);

$response = curl_exec($ch);
curl_close($ch);

// Decode response
$result = json_decode($response, true);

if ($result && $result['status'] === 'successful') {
    // Payment verified - update your database
    echo json_encode(["success" => true, "message" => "Payment verified", "data" => $result]);
} else {
    echo json_encode(["success" => false, "message" => "Payment verification failed"]);
}
?>





<div class="cart" onclick="incrementCart()">
        <span class="cart-icon">🛒</span>
        <span class="cart-counter" id="cart-counter">0</span>
      </div>
    </nav>
    <div class="success-message" id="success-message">Item added to cart successfully!</div>
    <script>
      let cartCount = 0;
      function incrementCart() {
        const successMessage = document.getElementById("success-message");
        cartCount++;
        document.getElementById("cart-counter").textContent = cartCount;
        successMessage.style.display = "block";
        setTimeout(() => {
          successMessage.style.display = "none";
        }, 2000);
      }
    </script>