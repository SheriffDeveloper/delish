<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $vendor_name = $_POST['vendor_name'];
    $unique_id = $_POST['unique_id'];
    $description = $_POST['description'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Handle image upload
    $vendor_image = 'uploads/' . basename($_FILES['vendor_image']['name']);
    move_uploaded_file($_FILES['vendor_image']['tmp_name'], $vendor_image);

    $stmt = $conn->prepare("INSERT INTO vendors (vendor_name, vendor_image, unique_id, description, password) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $vendor_name, $vendor_image, $unique_id, $description, $password);

    if ($stmt->execute()) {
        header("Location: index.php?registration=success");
    } else {
        header("Location: index.php?error=registration_failed");
        exit();
    }
}
?>