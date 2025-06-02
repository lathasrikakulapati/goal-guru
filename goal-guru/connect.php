<?php 
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];

function check_stmt_error($stmt) {
    if ($stmt->errno) {
        error_log("SQL Error: " . $stmt->error);
        die("A database error occurred. Please try again later.");
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    header('Content-Type: application/json');

    $action = $_POST['action'];
    $target_id = intval($_POST['user_id']);

    if ($action === 'send_request') {
        $check_stmt = $conn->prepare("SELECT * FROM friend_requests WHERE sender_id = ? AND receiver_id = ? AND status = 'pending'");
        $check_stmt->bind_param("ii", $user_id, $target_id);
        $check_stmt->execute();
        check_stmt_error($check_stmt);
        $result = $check_stmt->get_result();

        if ($result->num_rows === 0) {
            $insert_stmt = $conn->prepare("INSERT INTO friend_requests (sender_id, receiver_id, status) VALUES (?, ?, 'pending')");
            $insert_stmt->bind_param("ii", $user_id, $target_id);
            $insert_stmt->execute();
            check_stmt_error($insert_stmt);
            $insert_stmt->close();
        }
        $check_stmt->close();

        echo json_encode(['status' => 'success', 'message' => 'Request sent']);
        exit;
    }

    if ($action === 'accept_request') {
        $update_stmt = $conn->prepare("UPDATE friend_requests SET status='accepted' WHERE sender_id=? AND receiver_id=? AND status='pending'");
        $update_stmt->bind_param("ii", $target_id, $user_id);
        $update_stmt->execute();
        check_stmt_error($update_stmt);
        $update_stmt->close();

        $userA = min($user_id, $target_id);
        $userB = max($user_id, $target_id);

        $check_friend_stmt = $conn->prepare("SELECT * FROM friends WHERE user1_id=? AND user2_id=?");
        $check_friend_stmt->bind_param("ii", $userA, $userB);
        $check_friend_stmt->execute();
        check_stmt_error($check_friend_stmt);
        $result = $check_friend_stmt->get_result();

        if ($result->num_rows === 0) {
            $insert_friend_stmt = $conn->prepare("INSERT INTO friends (user1_id, user2_id) VALUES (?, ?)");
            $insert_friend_stmt->bind_param("ii", $userA, $userB);
            $insert_friend_stmt->execute();
            check_stmt_error($insert_friend_stmt);
            $insert_friend_stmt->close();
        }

        $check_friend_stmt->close();
        echo json_encode(['status' => 'success', 'message' => 'Request accepted']);
        exit;
    }

    if ($action === 'reject_request') {
        $reject_stmt = $conn->prepare("UPDATE friend_requests SET status='rejected' WHERE sender_id=? AND receiver_id=? AND status='pending'");
        $reject_stmt->bind_param("ii", $target_id, $user_id);
        $reject_stmt->execute();
        check_stmt_error($reject_stmt);
        $reject_stmt->close();

        echo json_encode(['status' => 'success', 'message' => 'Request rejected']);
        exit;
    }

    echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
    exit;
}

// 1. Pending Friend Requests
$stmt1 = $conn->prepare("
    SELECT fr.id, u.id AS user_id, u.name 
    FROM friend_requests fr 
    JOIN users u ON fr.sender_id = u.id 
    WHERE fr.receiver_id = ? AND fr.status = 'pending'
");
$stmt1->bind_param("i", $user_id);
$stmt1->execute();
check_stmt_error($stmt1);
$friend_requests = $stmt1->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt1->close();

// 2. Find other users (exclude self, current friends, rejected requests)
$stmt2 = $conn->prepare("
    SELECT u.id, u.name
    FROM users u
    WHERE u.id != ?
      AND u.id NOT IN (
        SELECT CASE
            WHEN f.user1_id = ? THEN f.user2_id
            ELSE f.user1_id
        END
        FROM friends f
        WHERE f.user1_id = ? OR f.user2_id = ?
      )
      AND u.id NOT IN (
        SELECT CASE
            WHEN fr.sender_id = ? THEN fr.receiver_id
            ELSE fr.sender_id
        END
        FROM friend_requests fr
        WHERE (fr.sender_id = ? OR fr.receiver_id = ?) AND fr.status = 'rejected'
      )
");
$stmt2->bind_param("iiiiiii", $user_id, $user_id, $user_id, $user_id, $user_id, $user_id, $user_id);
$stmt2->execute();
check_stmt_error($stmt2);
$users = $stmt2->get_result()->fetch_all(MYSQLI_ASSOC);
$stmt2->close();

// 3. Sent Friend Requests
$stmt3 = $conn->prepare("SELECT receiver_id, status FROM friend_requests WHERE sender_id = ?");
$stmt3->bind_param("i", $user_id);
$stmt3->execute();
check_stmt_error($stmt3);
$sent_requests = [];
$result3 = $stmt3->get_result();
while ($row = $result3->fetch_assoc()) {
    $sent_requests[$row['receiver_id']] = $row['status'];
}
$stmt3->close();

// 4. Friend Count
$stmt4 = $conn->prepare("
    SELECT COUNT(*) AS friend_count
    FROM friends
    WHERE user1_id = ? OR user2_id = ?
");
$stmt4->bind_param("ii", $user_id, $user_id);
$stmt4->execute();
check_stmt_error($stmt4);
$friend_count = 0;
$result4 = $stmt4->get_result();
if ($row = $result4->fetch_assoc()) {
    $friend_count = $row['friend_count'];
}
$stmt4->close();

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
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>GOAL GURU - Connect</title>
  <style>
    body {
      font-family: 'Segoe UI', sans-serif;
      background: #fafafa;
      margin: 0;
      padding: 0;
      color: #333;
    }
    .container {
      max-width: 700px;
      margin: auto;
      padding: 2rem;
      background-color: #fff;
    }
    header {
      display: flex;
      justify-content: space-between;
      align-items: center;
      margin-bottom: 1.5rem;
    }
    header h1 {
      font-size: 1.8rem;
      margin: 0;
    }
    nav a {
      margin-left: 1rem;
      text-decoration: none;
      color: #555;
    }
    nav a.active {
      font-weight: bold;
      border-bottom: 2px solid #a8745b;
    }
    .intro {
      font-size: 1.1rem;
      margin-bottom: 1rem;
    }
    .request, .user {
      display: flex;
      justify-content: space-between;
      align-items: center;
      padding: 0.6rem;
      background: #f2f2f2;
      border-radius: 6px;
      margin-bottom: 0.5rem;
    }
    .btn-group-inline {
      display: flex;
      gap: 0.5rem;
    }
    button {
      background-color: #a8745b;
      color: #fff;
      border: none;
      padding: 0.4rem 1rem;
      border-radius: 20px;
      cursor: pointer;
      transition: background-color 0.2s;
    }
    button:hover:not(:disabled) {
      background-color: #8b5e47;
    }
    button:disabled {
      cursor: not-allowed;
      opacity: 0.7;
    }
    .chat-btn {
      background-color: #4CAF50;
      padding: 0.4rem 1rem;
      border-radius: 20px;
      border: none;
      color: white;
      cursor: pointer;
      transition: background-color 0.2s;
    }
    .chat-btn:hover {
      background-color: #45a049;
    }
  </style>
  <script>
    function ajaxPost(data, callback) {
      fetch('connect.php', {
        method: 'POST',
        headers: {'Content-Type': 'application/x-www-form-urlencoded'},
        body: new URLSearchParams(data)
      })
      .then(res => res.json())
      .then(callback)
      .catch(console.error);
    }

    function acceptRequest(userId, elem) {
      ajaxPost({action: 'accept_request', user_id: userId}, res => {
        if(res.status === 'success') {
          elem.parentElement.parentElement.remove();
          incrementFriendCount(1);
          // Optional: reload to show new friend with chat
          location.reload();
        } else {
          alert(res.message || 'Error accepting request');
        }
      });
    }

    function rejectRequest(userId, elem) {
      ajaxPost({action: 'reject_request', user_id: userId}, res => {
        if(res.status === 'success') {
          elem.parentElement.parentElement.remove();
        } else {
          alert(res.message || 'Error rejecting request');
        }
      });
    }

    function sendRequest(userId, elem) {
      ajaxPost({action: 'send_request', user_id: userId}, res => {
        if(res.status === 'success') {
          elem.disabled = true;
          elem.textContent = 'Request Sent';
        } else {
          alert(res.message || 'Error sending request');
        }
      });
    }

    function incrementFriendCount(n) {
      const span = document.getElementById('friend-count');
      if (span) {
        span.textContent = parseInt(span.textContent) + n;
      }
    }

    function openChat(friendId) {
      window.location.href = 'chat.php?friend_id=' + friendId;
    }
  </script>
</head>
<body>
  <div class="container">
    <header>
      <h1>Connect</h1>
      <nav>
        <a href="dashboard.php">Home</a>
        <a href="learn.php">learn</a>
        <a href="connect.php" class="active">Connect</a>
        <a href="profile.php">Profile</a>
        
        
        <a href="logout.php">Logout</a>
      </nav>
    </header>

    <p class="intro">Connect with your GOAL GURU community. Total friends: <span id="friend-count"><?= $friend_count ?></span></p>

    <section>
      <h2>Pending Friend Requests</h2>
      <?php if (count($friend_requests) > 0): ?>
        <?php foreach($friend_requests as $request): ?>
          <div class="request">
            <div><?= htmlspecialchars($request['name']) ?></div>
            <div class="btn-group-inline">
              <button onclick="acceptRequest(<?= $request['user_id'] ?>, this)">Accept</button>
              <button onclick="rejectRequest(<?= $request['user_id'] ?>, this)">Reject</button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No pending friend requests.</p>
      <?php endif; ?>
    </section>

    <section>
      <h2>Find New Friends</h2>
      <?php if (count($users) > 0): ?>
        <?php foreach($users as $user): 
          $status = $sent_requests[$user['id']] ?? null;
        ?>
          <div class="user">
            <div><?= htmlspecialchars($user['name']) ?></div>
            <div>
              <?php if (!$status): ?>
                <button onclick="sendRequest(<?= $user['id'] ?>, this)">Add Friend</button>
              <?php elseif ($status === 'pending'): ?>
                <button disabled>Request Sent</button>
              <?php elseif ($status === 'rejected'): ?>
                <button disabled>Request Rejected</button>
              <?php elseif ($status === 'accepted'): ?>
                <button disabled>Friends</button>
              <?php endif; ?>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>No new users to add.</p>
      <?php endif; ?>
    </section>

    <section>
      <h2>Your Friends</h2>
      <?php if (count($friends) > 0): ?>
        <?php foreach ($friends as $friend): ?>
          <div class="user">
            <div><?= htmlspecialchars($friend['name']) ?></div>
            <div>
              <button class="chat-btn" onclick="openChat(<?= $friend['id'] ?>)">Chat</button>
            </div>
          </div>
        <?php endforeach; ?>
      <?php else: ?>
        <p>You have no friends yet.</p>
      <?php endif; ?>
    </section>
  </div>
</body>
</html>
