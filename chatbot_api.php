<?php
header("Content-Type: application/json");

// Function to read and parse a CSV file
function readCsv($filename) {
    $data = [];
    if (file_exists($filename) && ($handle = fopen($filename, "r")) !== FALSE) {
        $headers = fgetcsv($handle, 1000, ",");
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($headers) == count($row)) {
                $data[] = array_combine($headers, $row);
            }
        }
        fclose($handle);
    }
    return $data;
}

// Decode the incoming request
$request = json_decode(file_get_contents("php://input"), true);
$userMessage = isset($request["message"]) ? strtolower($request["message"]) : "";

$botMessage = "I'm sorry, I don't understand. Can you rephrase?";

// --- Basic Greetings and Help ---
if (strpos($userMessage, 'hello') !== false || strpos($userMessage, 'hi') !== false) {
    $botMessage = 'Hi there! How can I help you today? You can ask me about restaurants, your order status, or delivery information.';
} elseif (strpos($userMessage, 'help') !== false) {
    $botMessage = 'I can help you find restaurants, check order status, or track deliveries. What would you like to know?';
} elseif (strpos($userMessage, 'thank') !== false) {
    $botMessage = 'You\'re welcome! Is there anything else I can help you with?';

// --- Restaurant Queries ---
} elseif (strpos($userMessage, 'list restaurants') !== false || strpos($userMessage, 'show me restaurants') !== false) {
    $restaurants = readCsv('restaurants.csv');
    if (!empty($restaurants)) {
        $botMessage = "Here are some of our top-rated restaurants in Maiduguri:\n\n";
        foreach ($restaurants as $r) {
            $botMessage .= "🍽️ *{$r['Name']}*\n";
            $botMessage .= "⭐ Rating: {$r['Rating']}\n";
            $botMessage .= "🍲 Specialities: {$r['Food_Produced']}\n\n";
        }
    } else {
        $botMessage = "I couldn't find any restaurant information right now.";
    }

// --- Order Status Queries ---
} elseif (strpos($userMessage, 'order status') !== false || strpos($userMessage, 'check my order') !== false) {
    // Extract order ID from the message, e.g., "check my order ORD001"
    preg_match('/(ord\d+)/i', $userMessage, $matches);
    $orderId = !empty($matches[1]) ? strtoupper($matches[1]) : null;

    if ($orderId) {
        $deliveries = readCsv('deliveries.csv');
        $found = false;
        foreach ($deliveries as $d) {
            if (strtoupper($d['Order_ID']) === $orderId) {
                $botMessage = "Your order {$orderId} is currently {$d['Delivery_Status']}. The driver is {$d['Driver_Name']}.";
                $found = true;
                break;
            }
        }
        if (!$found) {
            $botMessage = "Sorry, I couldn't find any information for order ID {$orderId}.";
        }
    } else {
        $botMessage = "Please provide an order ID (e.g., 'check order ORD001') so I can check the status.";
    }

// --- Delivery Queries ---
} elseif (strpos($userMessage, 'delivery') !== false) {
    $botMessage = 'We offer fast delivery across Maiduguri. To check on a specific delivery, please provide your order ID.';

}

// Send the response as JSON
echo json_encode(['reply' => $botMessage]);
?>