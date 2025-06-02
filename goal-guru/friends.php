<?php
session_start();
require 'db.php';

if (!isset($_SESSION['id'])) {
    header('Location: login.php');
    exit;
}

$user_id = $_SESSION['id'];

// Fetch friends
$stmt = $conn->prepare("
    SELECT u.id, u.name 
    FROM friends f 
    JOIN users u ON 
        (u.id = f.user1_id AND f.user2_id = ?) 
        OR (u.id = f.user2_id AND f.user1_id = ?)
");
$stmt->bind_param("ii", $user_id, $user_id);
$stmt->execute();
$friends = $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
// 5. Friends List
$stmt5 = $conn->prepare("
    SELECT u.id, u.name
    FROM users u
    JOIN friends f ON 
        (f.user1_id = u.id AND f.user2_id = ?) OR 
        (f.user2_id = u.id AND f.user1_id = ?)
");
$stmt5->bind_param("ii", $user_id, $user_id);
$stmt5->execute();
check_stmt_error($stmt5);
$friends = $stmt5->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt5->close();

?>

<!DOCTYPE html>
<html>
<head>
    <title>My Friends</title>
    <style>
        body { font-family: sans-serif; background: #f9f9f9; padding: 2rem; }
        .friend { background: #fff; padding: 1rem; border-radius: 8px; margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; }
        h2 { margin-bottom: 1rem; }
        .chat-button {
            padding: 6px 12px;
            background: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 5px;
        }
        .chat-button:hover {
            background: #0056b3;
        }
    </style>
</head>
<body>
    <h2>My Friends</h2>
    <?php if (empty($friends)): ?>
        <p>You don't have any friends yet.</p>
    <?php else: ?>
        <?php foreach ($friends as $friend): ?>
            <div class="friend">
                <?= htmlspecialchars($friend['name']) ?>
                <a class="chat-button" href="chat.php?friend_id=<?= $friend['id'] ?>">Chat</a>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
    <p><a href="connect.php">← Back to Connect</a></p>
</body>
</html>
