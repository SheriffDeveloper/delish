<?php
header("Content-Type: application/json");

// Database config
$host = "localhost";
$dbname = "bdtavkfz_delishgo";
$username = "bdtavkfz_sheriff";
$password = "07012927918Sms@";


$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Receive input
$name = trim($_POST["name"] ?? '');
$email = trim($_POST["email"] ?? '');
$password = trim($_POST["password"] ?? '');

// Validate
if (empty($name) || empty($email) || empty($password)) {
    echo json_encode(["error" => "All fields are required"]);
    exit();
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo json_encode(["error" => "Invalid email address"]);
    exit();
}
if (strlen($password) < 6) {
    echo json_encode(["error" => "Password must be at least 6 characters"]);
    exit();
}

// Check if email exists
$stmt = $conn->prepare("SELECT id FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows > 0) {
    echo json_encode(["error" => "Email already registered"]);
    exit();
}

// Generate unique user_id
$user_id = bin2hex(random_bytes(16)); // 32-char unique ID

// Hash password
$hashedPassword = password_hash($password, PASSWORD_BCRYPT);

// Insert user
$stmt = $conn->prepare("INSERT INTO users (user_id, name, email, password) VALUES (?, ?, ?, ?)");
$stmt->bind_param("ssss", $user_id, $name, $email, $hashedPassword);

if ($stmt->execute()) {
    echo json_encode([
        "success" => "Registration successful",
        "user_id" => $user_id // Optional: return to Flutter
    ]);
} else {
    echo json_encode(["error" => "Registration failed"]);
}

$stmt->close();
$conn->close();
?>
