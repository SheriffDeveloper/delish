<?php
include 'db.php';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $unique_id = $_POST['unique_id'];
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT * FROM vendors WHERE unique_id = ?");
    $stmt->bind_param("s", $unique_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $vendor = $result->fetch_assoc();

    if ($vendor && password_verify($password, $vendor['password'])) {
        session_start();
        $_SESSION['vendor_id'] = $vendor['id'];
        header("Location: dashboard.php");
    } else {
        header("Location: index.php?login_error=1");
        exit();
    }
}
?>