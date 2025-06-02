<?php
require 'session.php';
require 'db.php';
$uid = $_SESSION['id'];
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $title = $_POST['title'];
    $desc = $_POST['description'];
    $conn->query("INSERT INTO goals (user_id, title, description) VALUES ($uid, '$title', '$desc')");
}
$res = $conn->query("SELECT * FROM goals WHERE user_id = $uid ORDER BY created_at DESC");
?>
<html><body>
<h2>My Goals</h2>
<form method="POST">
    Title: <input name="title" required><br>
    Description: <input name="description"><br>
    <button>Add Goal</button>
</form>
<ul>
<?php while ($g = $res->fetch_assoc()) echo "<li><strong>{$g['title']}</strong> - {$g['status']}</li>"; ?>
</ul>
<a href="dashboard.php">Back</a>
</body></html>