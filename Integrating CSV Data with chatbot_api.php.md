# Integrating CSV Data with chatbot_api.php

This guide explains how to integrate the generated CSV data (Restaurants, Customers, Deliveries) into your `chatbot_api.php` without requiring a heavy database setup. The approach focuses on reading data directly from the CSV files within your PHP script.

## Understanding chatbot_api.php

The `chatbot_api.php` file currently acts as a simple backend for your chatbot. It receives a user message via a POST request, processes it based on predefined keywords, and returns a text reply. The core logic is a series of `if-elseif` statements that check for keywords like 'hello', 'restaurant', 'order', 'delivery', 'help', and 'thank'.

```php
<?php
header("Content-Type: application/json");

$request = json_decode(file_get_contents("php://input"), true);
$userMessage = isset($request["message"]) ? strtolower($request["message"]) : "";

$botMessage = "I'm sorry, I don't understand. Can you rephrase?";

if (strpos($userMessage, 'hello') !== false || strpos($userMessage, 'hi') !== false) {
    $botMessage = 'Hi there! How can I help you today?';
} elseif (strpos($userMessage, 'restaurant') !== false) {
    $botMessage = 'You can find a list of restaurants on our Restaurants page. We have amazing local options!';
} elseif (strpos($userMessage, 'order') !== false) {
    $botMessage = 'To place an order, please select a restaurant and add items to your cart. It\'s quick and easy!';
} elseif (strpos($userMessage, 'delivery') !== false) {
    $botMessage = 'We offer fast delivery to your location. Enter your address to see available restaurants.';
} elseif (strpos($userMessage, 'help') !== false) {
    $botMessage = 'I can help you find restaurants, place orders, or answer questions about our delivery service.';
} elseif (strpos($userMessage, 'thank') !== false) {
    $botMessage = 'You\'re welcome! Is there anything else I can help you with?';
}

echo json_encode(['reply' => $botMessage]);
?>
```

## Strategy for CSV Integration

To integrate the CSV data, we will:

1.  **Define a function to read CSV files**: This function will parse a given CSV file and return its contents as an array of associative arrays, making it easy to work with the data.
2.  **Extend the chatbot logic**: Add new `elseif` conditions to `chatbot_api.php` to handle queries related to restaurants, customers, and deliveries. When a relevant keyword is detected, the script will read the appropriate CSV file and use its data to formulate a more dynamic response.

This approach avoids the need for a database server (like MySQL) and complex database connection logic, keeping the setup lightweight.

## Step-by-Step Implementation

### Step 1: Create a CSV Reading Function

First, let's create a helper function to read and parse CSV files. You can place this function at the top of your `chatbot_api.php` file or in a separate utility file that you include.

```php
<?php

function readCsv($filename) {
    $data = [];
    if (($handle = fopen($filename, "r")) !== FALSE) {
        $headers = fgetcsv($handle, 1000, ","); // Read header row
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            if (count($headers) === count($row)) {
                $data[] = array_combine($headers, $row);
            }
        }
        fclose($handle);
    }
    return $data;
}

// ... rest of your chatbot_api.php code

?>
```

**Explanation of `readCsv` function:**

*   `$filename`: The path to the CSV file (e.g., `'restaurants.csv'`).
*   `fopen($filename, 


r"))`: Opens the CSV file in read mode.
*   `fgetcsv($handle, 1000, ",")`: Reads a line from the file, parsing it as a CSV record. The first line is assumed to be the header.
*   `array_combine($headers, $row)`: Creates an associative array for each row, where the keys are the header names (e.g., `Name`, `Location`) and the values are the row data.
*   This function returns an array of these associative arrays, which is a structured representation of your CSV data.

### Step 2: Update `chatbot_api.php` to Use the CSV Data

Now, let's modify the main logic of `chatbot_api.php` to use the `readCsv` function and provide more dynamic responses.

Here is the complete, updated `chatbot_api.php`:

```php
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
        $botMessage = "Here are some restaurants in Maiduguri:\n";
        foreach ($restaurants as $r) {
            $botMessage .= "- {$r['Name']} (Rating: {$r['Rating']}) - Specializes in {$r['Food_Produced']}\n";
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
```

### How the New Logic Works

1.  **Restaurant Queries**: If the user asks to "list restaurants" or "show me restaurants", the script:
    *   Calls `readCsv('restaurants.csv')` to get the restaurant data.
    *   Constructs a response string by looping through the restaurants and listing their name, rating, and food type.
    *   If the CSV is empty or not found, it returns a fallback message.

2.  **Order Status Queries**: If the user asks about their "order status" or wants to "check my order":
    *   It uses a regular expression (`preg_match`) to find an order ID (like `ORD001`) in the user's message.
    *   If an order ID is found:
        *   It reads `deliveries.csv`.
        *   It searches for a matching `Order_ID`.
        *   If found, it provides the `Delivery_Status` and `Driver_Name`.
        *   If not found, it informs the user.
    *   If no order ID is provided in the query, it prompts the user to provide one.

### Step 3: Place Your Files Correctly

For this to work, ensure that your file structure is correct. The `chatbot_api.php` script and the three CSV files (`restaurants.csv`, `customers.csv`, `deliveries.csv`) should all be in the same directory on your server. If they are in different directories, you will need to adjust the file paths in the `readCsv()` function calls (e.g., `readCsv('data/restaurants.csv')`).

## How to Use This in Your Chatbot

Your frontend JavaScript code, which sends requests to `chatbot_api.php`, does not need to change. It will continue to send the user's message and display the `reply` it receives from the API. The difference is that the replies will now be more dynamic and data-driven.

**Example User Interactions:**

*   **User**: "Show me restaurants in Maiduguri"
    *   **Bot**: "Here are some restaurants in Maiduguri:
        - Borno Bites (Rating: 4.5) - Specializes in Local Nigerian,Fast Food
        - Maiduguri Munchies (Rating: 4.2) - Specializes in Intercontinental,Grill
        - ..."

*   **User**: "What is my order status for ORD003?"
    *   **Bot**: "Your order ORD003 is currently In Transit. The driver is Hassan."

*   **User**: "I want to check my order"
    *   **Bot**: "Please provide an order ID (e.g., 'check order ORD001') so I can check the status."

This setup provides a simple yet effective way to integrate your CSV data into the chatbot without the overhead of a full database, making it ideal for lightweight applications and prototypes.

