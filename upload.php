<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>DelishGo - Upload Product</title>
    <link rel="stylesheet" href="assets/vendors/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/style.css">
    <style>
      body {
        height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        font-family: 'Arial', sans-serif;
        position: relative;
        overflow: hidden;
        background: linear-gradient(135deg, #ffedd5, #ff7b00);
      }
      .background-slider {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 50%;
        background-size: cover;
        background-position: center;
        animation: slide 15s infinite;
      }
      @keyframes slide {
        0% { background-image: url('assets/images/deliverycover1.png'); }
        20% { background-image: url('assets/images/deliverycover2.png'); }
        40% { background-image: url('assets/images/deliverycover3.png'); }
        60% { background-image: url('assets/images/deliverycover4.png'); }
        80% { background-image: url('assets/images/deliverycover5.png'); }
        100% { background-image: url('assets/images/deliverycover6.png'); }
      }
      .upload-container {
        background: rgba(255, 255, 255, 0.95);
        padding: 30px;
        border-radius: 15px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.3);
        text-align: center;
        position: relative;
        z-index: 1;
        width: 400px;
      }
      .upload-container h4 {
        color: #ff4d00;
        font-weight: bold;
        margin-bottom: 15px;
      }
      .upload-container input, .upload-container textarea {
        border-radius: 10px;
        padding: 10px;
        border: 1px solid #ddd;
        transition: all 0.3s ease;
      }
      .upload-container input:focus, .upload-container textarea:focus {
        border-color: #ff4d00;
        box-shadow: 0 0 5px rgba(255, 77, 0, 0.5);
      }
      .upload-container .btn-primary {
        background: #ff4d00;
        border: none;
        transition: 0.3s;
        padding: 10px;
        border-radius: 10px;
      }
      .upload-container .btn-primary:hover {
        background: #e64500;
      }
      .floating-food {
        position: absolute;
        animation: float 3s infinite ease-in-out;
        z-index: 1;
      }
      @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
      }
      .food1 { top: 10px; left: 10px; width: 50px; }
      .food2 { bottom: 10px; right: 10px; width: 50px; }
    </style>
  </head>
  <body>
    <div style="height: 50%;" class="background-slider"></div>
    <div class="upload-container">
      <img src="assets/images/DelishGo Logo Ng.jpg" alt="logo" width="150">
      <h4>Upload a New Product</h4>
      <p>Fill in the details below to add a product to your store.</p>
      <form>
        <div class="form-group">
          <input type="text" class="form-control" placeholder="Product Name" required>
        </div>
        <div class="form-group">
          <textarea class="form-control" placeholder="Product Description" rows="3" required></textarea>
        </div>
        <div class="form-group">
          <input type="number" class="form-control" placeholder="Price (NGN)" required>
        </div>
        <div class="form-group">
          <input type="file" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Upload Product</button>
      </form>
    </div>
    <img style="width: 200px;" src="assets/images/food1.jfif.png" class="floating-food food1">
    <img style="width: 200px;" src="assets/images/food6.png" class="floating-food food2">
  </body>
</html>
