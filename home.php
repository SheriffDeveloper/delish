<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DelishGo - Restaurants</title>
    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      body {
        font-family: 'Arial', sans-serif;
        background: linear-gradient(135deg, #ffedd5, #ff7b00);
        padding: 20px;
      }
      .navbar {
        background: #ff4d00;
        padding: 10px 20px;
        display: flex;
        align-items: center;
        justify-content: space-between;
      }
      .navbar .brand {
        font-size: 24px;
        font-weight: bold;
        color: white;
      }
      .navbar .nav-links {
        display: flex;
        gap: 15px;
      }
      .navbar a {
        color: white;
        text-decoration: none;
        font-size: 18px;
        padding: 8px 15px;
        transition: background 0.3s;
      }
      .navbar a:hover {
        background: #e64500;
        border-radius: 5px;
      }
      .restaurant-container {
        max-width: 900px;
        margin: auto;
        background: rgba(255, 255, 255, 0.95);
        padding: 20px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        margin-top: 20px;
      }
      .restaurant {
        display: flex;
        align-items: center;
        background: #fff;
        padding: 15px;
        margin-bottom: 15px;
        border-radius: 10px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease;
      }
      .restaurant:hover {
        transform: scale(1.02);
      }
      .restaurant img {
        width: 80px;
        height: 80px;
        border-radius: 10px;
        margin-right: 15px;
      }
      .restaurant-details {
        flex-grow: 1;
      }
      .restaurant h5 {
        color: #ff4d00;
        margin-bottom: 5px;
      }
      .restaurant p {
        margin: 0;
        font-size: 14px;
        color: #555;
      }
      /* Chatbot styles */
      .chatbot-container {
        position: fixed;
        bottom: 30px;
        right: 30px;
        z-index: 9999;
      }
      .chatbot-icon {
        width: 60px;
        height: 60px;
        background: #fff;
        border-radius: 50%;
        box-shadow: 0 2px 8px rgba(0,0,0,0.2);
        display: flex;
        align-items: center;
        justify-content: center;
        cursor: pointer;
        transition: box-shadow 0.3s;
      }
      .chatbot-icon img {
        width: 40px;
        height: 40px;
      }
      .chatbot-icon:hover {
        box-shadow: 0 4px 16px rgba(0,0,0,0.3);
      }
      .chat-window {
        display: none;
        flex-direction: column;
        position: absolute;
        bottom: 70px;
        right: 0;
        width: 320px;
        background: #fff;
        border-radius: 12px;
        box-shadow: 0 4px 24px rgba(0,0,0,0.25);
        overflow: hidden;
        animation: fadeIn 0.3s;
      }
      .chat-header {
        background: #ff4d00;
        color: #fff;
        padding: 12px;
        font-weight: bold;
        text-align: center;
      }
      .chat-messages {
        flex: 1;
        padding: 12px;
        background: #f9f9f9;
        overflow-y: auto;
        max-height: 220px;
      }
      .chat-input {
        display: flex;
        border-top: 1px solid #eee;
        background: #fff;
      }
      .chat-input input {
        flex: 1;
        border: none;
        padding: 10px;
        font-size: 15px;
        outline: none;
      }
      .chat-input button {
        background: #ff4d00;
        color: #fff;
        border: none;
        padding: 0 18px;
        font-size: 15px;
        cursor: pointer;
        transition: background 0.2s;
      }
      .chat-input button:hover {
        background: #e64500;
      }
      .message {
        margin-bottom: 8px;
        padding: 7px 12px;
        border-radius: 8px;
        max-width: 80%;
        word-break: break-word;
      }
      .message-user {
        background: #ffedd5;
        align-self: flex-end;
      }
      .message-bot {
        background: #eee;
        align-self: flex-start;
      }
      @keyframes fadeIn {
        from { opacity: 0; transform: translateY(30px); }
        to { opacity: 1; transform: translateY(0); }
      }
    </style>
  </head>
  <body>
    <nav class="navbar">
      <div class="brand">DelishGo</div>
      <div class="nav-links">
        <a href="index.html">Home</a>
        <a href="restaurants.php">Restaurants</a>
        <a href="login.html">Login</a>
      </div>
    </nav>
    <div class="restaurant-container">
      <h3 class="text-center" style="color: #ff4d00;">Discover Restaurants</h3>
      <p class="text-center">Find amazing places to eat around you.</p>
      
      <div class="restaurant">
        <img src="assets/images/restaurant1.jpg" alt="Restaurant 1">
        <div class="restaurant-details">
          <h5>Spicy Delight</h5>
          <p>Authentic Nigerian cuisine with a touch of spice.</p>
          <p><strong>Location:</strong> Lagos, Nigeria</p>
        </div>
      </div>

      <div class="restaurant">
        <img src="assets/images/restaurant2.jpg" alt="Restaurant 2">
        <div class="restaurant-details">
          <h5>Urban Bites</h5>
          <p>Modern dining experience with delicious meals.</p>
          <p><strong>Location:</strong> Abuja, Nigeria</p>
        </div>
      </div>

      <div class="restaurant">
        <img src="assets/images/food3.png" alt="Restaurant 3">
        <div class="restaurant-details">
          <h5>Golden Spoon</h5>
          <p>Exquisite dishes prepared with fresh ingredients.</p>
          <p><strong>Location:</strong> Borno, Nigeria</p>
        </div>
      </div>
    </div>

    <!-- Chatbot -->
    <div class="chatbot-container">
      <div class="chatbot-icon">
        <img src="https://cdn-icons-png.flaticon.com/512/121/121135.png" alt="Chatbot">
      </div>
      <div class="chat-window">
        <div class="chat-header">DelishGo Assistant</div>
        <div class="chat-messages"></div>
        <div class="chat-input">
          <input type="text" placeholder="Ask me anything...">
          <button>Send</button>
        </div>
      </div>
    </div>

    <script>
      const chatbotIcon = document.querySelector('.chatbot-icon');
      const chatWindow = document.querySelector('.chat-window');
      const chatMessages = document.querySelector('.chat-messages');
      const chatInput = document.querySelector('.chat-input input');
      const sendButton = document.querySelector('.chat-input button');

      chatbotIcon.addEventListener('click', () => {
        chatWindow.style.display = chatWindow.style.display === 'flex' ? 'none' : 'flex';
      });

      sendButton.addEventListener('click', () => {
        const userMessage = chatInput.value;
        if (userMessage.trim() !== '') {
          addMessage('user', userMessage);
          handleBotResponse(userMessage);
          chatInput.value = '';
        }
      });

      function addMessage(sender, message) {
        const messageElement = document.createElement('div');
        messageElement.classList.add('message', `message-${sender}`);
        messageElement.textContent = message;
        chatMessages.appendChild(messageElement);
        chatMessages.scrollTop = chatMessages.scrollHeight;
      }

      function handleBotResponse(userMessage) {
        let botMessage = "I'm sorry, I don't understand. Can you rephrase?";

        if (userMessage.toLowerCase().includes('hello')) {
          botMessage = 'Hi there! How can I help you today?';
        } else if (userMessage.toLowerCase().includes('restaurant')) {
          botMessage = 'You can find a list of restaurants on our Restaurants page.';
        } else if (userMessage.toLowerCase().includes('order')) {
          botMessage = 'To place an order, please select a restaurant and add items to your cart.';
        }

        setTimeout(() => {
          addMessage('bot', botMessage);
        }, 500);
      }
    </script>
  </body>
</html>

