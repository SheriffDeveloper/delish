<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");

$host = "localhost";
$dbname = "bdtavkfz_delishgo";
$username = "bdtavkfz_sheriff";
$password = "07012927918Sms@";

$conn = new mysqli($host, $username, $password, $dbname);

if ($conn->connect_error) {
    die(json_encode(["error" => "Connection failed"]));
}

$sql = "SELECT name, rating, numOfRating, deliveryTime, foodType, images FROM restaurants";
$result = $conn->query($sql);

$restaurants = [];

while ($row = $result->fetch_assoc()) {
    $rating = is_numeric($row['rating']) ? (float)$row['rating'] : 0.0;
    $numOfRating = is_numeric($row['numOfRating']) ? (int)$row['numOfRating'] : 0;

    preg_match('/(\d{2}):(\d{2}):(\d{2})/', $row['deliveryTime'], $matches);
    $deliveryTime = isset($matches[3]) ? (int)$matches[3] : 30;

    $restaurants[] = [
        'name' => $row['name'],
        'rating' => $rating,
        'numOfRating' => $numOfRating,
        'deliveryTime' => $deliveryTime,
        'food_type' => array_filter(array_map('trim', explode(',', $row['foodType']))),
        'images' => array_map(function ($img) {
            return 'https://delishgofoods.com/uploads/' . trim($img);
        }, explode(',', $row['images']))
    ];
}

echo json_encode($restaurants);
$conn->close();
?>
