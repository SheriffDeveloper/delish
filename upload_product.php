<?php
// session_start();
// if (!isset($_SESSION['vendor_id'])) {
//     header("Location: index.php");
//     exit();
// }

// include 'db.php';

// if ($_SERVER['REQUEST_METHOD'] == 'POST') {
//     $vendor_id = $_SESSION['vendor_id'];
//     $product_name = $_POST['product_name'];
//     $not_price = $_POST['not_price'];
//     $price = $_POST['price'];
//     $quantity = $_POST['quantity'];
//     $description = $_POST['description'];

//     // Handle image upload
//     $product_picture = 'uploads/' . basename($_FILES['product_picture']['name']);
//     move_uploaded_file($_FILES['product_picture']['tmp_name'], $product_picture);

//     $stmt = $conn->prepare("INSERT INTO products (vendor_id, product_name, not_price, price, quantity, product_picture, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
//     $stmt->bind_param("isddiss", $vendor_id, $product_name, $not_price, $price, $quantity, $product_picture, $description);

//     // $stmt = $conn->prepare("INSERT INTO products (vendor_id, product_name, not_price, price, quantity, product_picture, description) VALUES (?, ?, ?, ?)");
//     // $stmt->bind_param("isss", $vendor_id, $product_name, $not_price, $price, $quantity, $product_picture, $description);

//     if ($stmt->execute()) {
//         // Send a notification
//         $message = "New product uploaded: $product_name";
//         $stmt = $conn->prepare("INSERT INTO notifications (vendor_id, message) VALUES (?, ?)");
//         $stmt->bind_param("is", $vendor_id, $message);
//         $stmt->execute();

//         header("Location: dashboard.php?upload=success");
//     } else {
//         echo "Error: " . $stmt->error;
//     }
// }

session_start();
if (!isset($_SESSION['vendor_id'])) {
    header("Location: index.php");
    exit();
}

include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vendor_id = $_SESSION['vendor_id'];
    $product_name = $_POST['product_name'];
    $not_price = floatval($_POST['not_price']);
    $price = floatval($_POST['price']);
    $quantity = intval($_POST['quantity']);
    $description = $_POST['description'];

    // Handle image upload
    $upload_dir = 'uploads/';
    $file_name = basename($_FILES['product_picture']['name']);
    $target_file = $upload_dir . $file_name;

    if (move_uploaded_file($_FILES['product_picture']['tmp_name'], $target_file)) {
        // Insert product into DB
        $stmt = $conn->prepare("INSERT INTO products (vendor_id, product_name, not_price, price, quantity, product_picture, description) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("isddiss", $vendor_id, $product_name, $not_price, $price, $quantity, $target_file, $description);

        if ($stmt->execute()) {
            $product_id = $conn->insert_id;

            // Insert notification with product ID
            $message = "New product uploaded: $product_name";
            $stmt = $conn->prepare("INSERT INTO notifications (vendor_id, product_id, message) VALUES (?, ?, ?)");
            $stmt->bind_param("iis", $vendor_id, $product_id, $message);
            $stmt->execute();

            header("Location: dashboard.php?upload=success");
            exit();
        } else {
            echo "Database Error: " . $stmt->error;
        }
    } else {
        echo "Image upload failed. Please try again.";
    }
}

?>