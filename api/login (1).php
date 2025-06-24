<?php
header("Content-Type: application/json");

// DB config
$host = "localhost";
$dbname = "bdtavkfz_delishgo";
$username = "bdtavkfz_sheriff";
$password = "07012927918Sms@";

// Connect to DB
$conn = new mysqli($host, $username, $password, $dbname);
if ($conn->connect_error) {
    http_response_code(500);
    echo json_encode(["error" => "Database connection failed"]);
    exit();
}

// Get JSON input
$data = json_decode(file_get_contents("php://input"), true);
$emailRaw = $data["email"] ?? '';
$password = trim($data["password"] ?? '');

// Sanitize and validate email
$email = filter_var(trim($emailRaw), FILTER_SANITIZE_EMAIL);
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Invalid email format"]);
    exit();
}

// Validate password (basic length check)
if (strlen($password) < 6) {
    http_response_code(400);
    echo json_encode(["status" => "error", "message" => "Password must be at least 6 characters"]);
    exit();
}

// Check user
$stmt = $conn->prepare("SELECT id, name, password FROM users WHERE email = ?");
$stmt->bind_param("s", $email);
$stmt->execute();
$stmt->store_result();

if ($stmt->num_rows === 0) {
    http_response_code(401);
    echo json_encode(["status" => "error", "message" => "Email not found"]);
    exit();
