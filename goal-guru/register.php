<?php
require 'db.php'; // Connect to DB
$error = '';
$success = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST['name']);
    $email = trim($_POST['email']);
    $password = password_hash(trim($_POST['password']), PASSWORD_DEFAULT);

    // Check if email already exists
    $check = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $check->bind_param("s", $email);
    $check->execute();
    $result = $check->get_result();

    if ($result->num_rows > 0) {
        $error = "Email already registered.";
    } else {
        // Insert new user
        $stmt = $conn->prepare("INSERT INTO users (name, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $name, $email, $password);
        if ($stmt->execute()) {
            $success = "Registration successful. <a href='login.php'>Login here</a>";
        } else {
            $error = "Registration failed. Try again.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Register</title>
  <style>
    body {
      background-color: #faf8f4;
      font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
      display: flex;
      flex-direction: column;
      align-items: center;
      justify-content: center;
      min-height: 100vh;
      margin: 0;
    }

    .register-container {
      width: 100%;
      max-width: 400px;
      background-color: transparent;
      padding: 40px 20px;
      box-sizing: border-box;
    }

    .register-container h2 {
      text-align: center;
      font-size: 32px;
      margin-bottom: 10px;
    }

    .register-container p {
      text-align: center;
      margin-bottom: 30px;
      color: #333;
    }

    .form-group {
      margin-bottom: 20px;
    }

    label {
      display: block;
      margin-bottom: 6px;
      color: #222;
      font-weight: 600;
    }

    input {
      width: 100%;
      padding: 10px 14px;
      border: 1px solid #ccc;
      border-radius: 6px;
      font-size: 16px;
      box-sizing: border-box;
    }

    .submit-btn {
      width: 100%;
      background-color: #000;
      color: #fff;
      padding: 12px;
      border: none;
      font-size: 16px;
      border-radius: 4px;
      cursor: pointer;
      text-transform: lowercase;
    }

    .submit-btn:hover {
      background-color: #222;
    }

    a {
      color: #000;
      text-decoration: underline;
    }

    .error, .success {
      text-align: center;
      font-size: 0.95rem;
      margin-bottom: 15px;
    }

    .error {
      color: red;
    }

    .success {
      color: green;
    }
  </style>
</head>
<body>
  <div class="register-container">
    <h2>Register</h2>
    <p>Already Registered? <a href="login.php">Login</a></p>

    <?php if ($error): ?>
      <div class="error"><?= $error ?></div>
    <?php endif; ?>
    <?php if ($success): ?>
      <div class="success"><?= $success ?></div>
    <?php endif; ?>

    <form action="register.php" method="POST">
      <div class="form-group">
        <label for="name">Name</label>
        <input type="text" id="name" name="name" required />
      </div>
      <div class="form-group">
        <label for="email">Email</label>
        <input type="email" id="email" name="email" required />
      </div>
      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" id="password" name="password" required />
      </div>
      <button type="submit" class="submit-btn">sign up</button>
    </form>
  </div>
</body>
</html>
