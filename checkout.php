<?php
// Get data from the previous page
$email = isset($_GET['email']) ? $_GET['email'] : '';
$name = isset($_GET['name']) ? $_GET['name'] : '';
$price = isset($_GET['price']) ? $_GET['price'] : '';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Page</title>
    <script src="https://checkout.squadco.com/widget/squad.min.js"></script>
</head>
<body>
    <h2>Checkout</h2>
    <form id="checkout-form">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" readonly><br><br>

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo htmlspecialchars($email); ?>" required><br><br>

        <label for="amount">Amount (NGN):</label>
        <input type="text" id="amount" name="amount" value="<?php echo htmlspecialchars($price); ?>" readonly><br><br>

        <button type="button" onclick="payWithSquad()">Pay Now</button>
    </form>

    <script>
        function payWithSquad() {
            const email = document.getElementById("email").value;
            const amount = document.getElementById("amount").value * 100; // Convert to Kobo

            if (!email || !amount) {
                alert("Please enter valid email and amount.");
                return;
            }

            const squadInstance = new squad({
                onClose: () => console.log("Payment modal closed"),
                onLoad: () => console.log("Payment modal loaded"),
                onSuccess: (response) => console.log("Payment successful", response),
                key: "sandbox_pk_cdce2a1ec6c1b59517e2aea5d724cc47a06ec96e9cd1", // Replace with your Squad public key
                email: email,
                amount: amount,
                currency_code: "NGN"
            });
            squadInstance.setup();
            squadInstance.open();
        }
    </script>
</body>
</html>
