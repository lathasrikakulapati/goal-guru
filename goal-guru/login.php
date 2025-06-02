<?php 
session_start();
require 'db.php';

// Redirect to profile if already logged in

if (isset($_SESSION['user_id'])) {
    header("Location: dashboard.php");
    exit();
}


// Enable error reporting (optional for development)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = trim($_POST['email']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE email = ?");
    if ($stmt) {
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();

        if ($stmt->num_rows === 1) {
            $stmt->bind_result($user_id, $hashed_password);
            $stmt->fetch();

            if (password_verify($password, $hashed_password)) {
                // Login successful
                $_SESSION['user_id'] = $user_id;
                $_SESSION['email'] = $email;

                header("Location: profile.php");
                exit();
            } else {
                $error = "Invalid password.";
            }
        } else {
            $error = "User not found.";
        }

        $stmt->close();
    } else {
        $error = "Database error.";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Goal Guru</title>
  <style>
    * {
      box-sizing: border-box;
      font-family: Arial, sans-serif;
    }
    body, html {
      margin: 0;
      padding: 0;
      height: 100%;
      background-color: #f9f6f2;
      display: flex;
      justify-content: center;
      align-items: center;
    }
    .login-container {
      text-align: center;
      width: 320px;
      padding: 24px;
      background-color: #fff;
      border: 1px solid #ddd;
      border-radius: 10px;
      box-shadow: 0 0 10px rgba(0,0,0,0.1);
    }
    h1 {
      font-size: 2rem;
      margin-bottom: 1.5rem;
      color: #333;
    }
    label {
      display: block;
      text-align: left;
      font-size: 0.8rem;
      margin-bottom: 0.3rem;
      margin-top: 1rem;
      color: #000;
    }
    input[type="email"],
    input[type="password"] {
      width: 100%;
      padding: 10px;
      font-size: 1rem;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-bottom: 0.5rem;
    }
    input[type="email"]:focus,
    input[type="password"]:focus {
      border-color: #000;
      outline: none;
    }
    .forgot-link {
      display: block;
      text-align: right;
      margin: 0.5rem 0 1.5rem;
      font-size: 0.85rem;
      color: #007BFF;
      text-decoration: none;
    }
    .forgot-link:hover {
      text-decoration: underline;
    }
    button {
      width: 100%;
      padding: 10px;
      font-size: 1rem;
      font-weight: bold;
      background-color: #000;
      color: white;
      border: none;
      cursor: pointer;
      border-radius: 4px;
      transition: background-color 0.3s;
    }
    button:hover {
      background-color: #333;
    }
    .error {
      color: red;
      font-size: 0.9rem;
      margin-bottom: 1rem;
    }
  </style>
</head>
<body>
  <div class="login-container">
    <h1>Login</h1>
    <?php if (!empty($error)): ?>
      <div class="error"><?= htmlspecialchars($error) ?></div>
    <?php endif; ?>
    <form action="login.php" method="POST" autocomplete="off">
      <label for="email">EMAIL</label>
      <input type="email" id="email" name="email" placeholder="hello@domain.com" required />

      <label for="password">PASSWORD</label>
      <input type="password" id="password" name="password" required />

      <a href="#" class="forgot-link">Forgot password?</a>

      <button type="submit">Login</button>
    </form>
  </div>
</body>
</html>
