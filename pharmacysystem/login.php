<?php
require_once 'functions.php';
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password']; // Use secure hashing in production
    if (loginUser($username, $password)) {
        global $conn;
        // Log the login event.
        $stmt = $conn->prepare("INSERT INTO login_history (username, login_time) VALUES (?, NOW())");
        $stmt->bind_param("s", $_SESSION['username']);
        $stmt->execute();

        header("Location: dashboard.php");
        exit();
    } else {
        $error = "Invalid username or password!";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Login - Pharmacy System</title>
  <!-- Google Fonts for modern typography -->
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="styles.css">
  <style>
    /* Background Image Styling */
    body {
      background: url('images/2.jpg') no-repeat center center fixed;
      background-size: cover;
      margin: 0;
      padding: 0;
      height: 100%;
    }
    /* Centered Login Container */
    .login-container {
      max-width: 400px;
      width: 100%;
      padding: 30px;
      background-color: rgba(255, 255, 255, 0.9);
      border-radius: 4px;
      box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
      position: absolute;
      top: 30%;
      left: 50%;
      transform: translate(-50%, -50%);
    }
    .login-container h2 {
      text-align: center;
      margin-bottom: 20px;
      color: #2c3e50;
    }
    .login-container form label {
      display: block;
      margin-top: 10px;
      font-weight: bold;
    }
    .login-container form input[type="text"],
    .login-container form input[type="password"] {
      width: 100%;
      padding: 10px;
      margin-top: 5px;
      border: 1px solid #ccc;
      border-radius: 4px;
    }
    .login-container form button {
      width: 100%;
      padding: 10px;
      margin-top: 20px;
      background-color: #3498db;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
      transition: background-color 0.3s ease;
    }
    .login-container form button:hover {
      background-color: #2980b9;
    }
    .error {
      color: white;
      margin-top: 10px;
      text-align: center;
    }
    /* Responsive Adjustments for Small Screens */
    @media (max-width: 480px) {
      .login-container {
        max-width: 90%;
        padding: 15px;
      }
      .login-container h2 {
        font-size: 1.5rem;
      }
      .login-container form button {
        padding: 8px;
        font-size: 0.9rem;
      }
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h2>Login</h2>
    <?php if(isset($error)) echo "<p class='error'>$error</p>"; ?>
    <form method="POST" action="login.php">
      <label for="username">Username:</label>
      <input type="text" name="username" id="username" required>
      
      <label for="password">Password:</label>
      <input type="password" name="password" id="password" required>
      
      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
