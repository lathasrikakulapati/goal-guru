<?php
// Enable error reporting for debugging — remove in production
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Start session and include database connection
require 'session.php'; // This should start session and set $_SESSION['user_id']
require 'db.php';      // This should set up $conn (MySQLi)

$user_id = $_SESSION['user_id'] ?? null;
$email = $_SESSION['email'] ?? null;

if (!$user_id || !$email) {
    header("Location: login.php");
    exit();
}

// Get user info
$stmt = $conn->prepare("SELECT name, email FROM users WHERE id = ?");
$stmt->bind_param("i", $user_id);
$stmt->execute();
$user_result = $stmt->get_result();
$user = $user_result->fetch_assoc();

if (!$user) {
    header("Location: logout.php");
    exit();
}

// Get completed courses
$course_stmt = $conn->prepare("SELECT course_name, completed_at FROM course_completed WHERE user_email = ?");
$course_stmt->bind_param("s", $email);
$course_stmt->execute();
$course_result = $course_stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Profile - Goal Guru</title>
  <link href="https://fonts.googleapis.com/css2?family=Montserrat:wght@400;600&display=swap" rel="stylesheet">
  <style>
    body {
      font-family: 'Montserrat', sans-serif;
      background-color: #f4f4f4;
      margin: 0;
    }
    .navbar {
      background-color: #ffffff;
      padding: 20px 40px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }
    .navbar div:first-child {
      font-size: 24px;
      font-weight: bold;
    }
    .navbar a {
      margin-left: 20px;
      text-decoration: none;
      color: #333;
      font-weight: 500;
    }
    .navbar a.active {
      border-bottom: 2px solid #333;
      padding-bottom: 4px;
    }
    .container {
      max-width: 800px;
      margin: 40px auto;
      background-color: #fff;
      padding: 30px;
      border-radius: 12px;
      box-shadow: 0 4px 12px rgba(0,0,0,0.05);
    }
    h2 {
      margin-bottom: 20px;
    }
    p {
      font-size: 16px;
      margin: 10px 0;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      margin-top: 20px;
    }
    th, td {
      padding: 12px;
      border: 1px solid #ddd;
    }
    th {
      background-color: #f0f0f0;
    }
  </style>
</head>
<body>

  <div class="navbar">
    <div>GOAL GURU</div>
    <div>
      <a href="dashboard.php">Home</a>
      <a href="learn.php">Learn</a>
      <a href="connect.php">Connect</a>
      <a href="profile.php" class="active">Profile</a>
      
      <a href="logout.php">Logout</a>
    </div>
  </div>

  <div class="container">
    <h2>User Profile</h2>
    <p><strong>Name:</strong> <?= htmlspecialchars($user['name']) ?></p>
    <p><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></p>

    <h2>Completed Courses</h2>
    <?php if ($course_result && $course_result->num_rows > 0): ?>
      <table>
        <thead>
          <tr>
            <th>Course Name</th>
            <th>Completed On</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($course = $course_result->fetch_assoc()): ?>
            <tr>
              <td><?= htmlspecialchars($course['course_name']) ?></td>
              <td><?= htmlspecialchars($course['completed_at']) ?></td>
            </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    <?php else: ?>
      <p>No courses completed yet.</p>
    <?php endif; ?>
  </div>

</body>
</html>
