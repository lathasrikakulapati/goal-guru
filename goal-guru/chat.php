<?php
session_start();
require 'db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$friend_id = isset($_GET['friend_id']) ? intval($_GET['friend_id']) : 0;

if ($friend_id === 0) {
    die('Invalid friend ID');
}

// Verify if $friend_id is actually a friend of $user_id (for security)
$stmt = $conn->prepare("
    SELECT 1 FROM friends WHERE
    (user1_id = ? AND user2_id = ?) OR (user1_id = ? AND user2_id = ?)
");
$stmt->bind_param("iiii", $user_id, $friend_id, $friend_id, $user_id);
$stmt->execute();
$stmt->store_result();
if ($stmt->num_rows === 0) {
    die('You are not friends with this user.');
}
$stmt->close();

// Fetch friend's name
$stmt = $conn->prepare("SELECT name FROM users WHERE id = ?");
$stmt->bind_param("i", $friend_id);
$stmt->execute();
$stmt->bind_result($friend_name);
$stmt->fetch();
$stmt->close();

?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <title>Chat with <?= htmlspecialchars($friend_name) ?></title>
  <style>
    body { font-family: 'Segoe UI', sans-serif; max-width: 700px; margin: auto; padding: 2rem; background: #fff; }
    #chat-box { border: 1px solid #ccc; height: 300px; overflow-y: scroll; padding: 10px; background: #f9f9f9; margin-bottom: 1rem; }
    .message { margin-bottom: 10px; }
    .message.self { text-align: right; }
    .message .text { display: inline-block; padding: 6px 10px; border-radius: 10px; max-width: 70%; }
    .message.self .text { background-color: #a8745b; color: #fff; }
    .message.other .text { background-color: #e2e2e2; color: #000; }
    #message-input { width: 100%; padding: 10px; font-size: 1rem; }
    #send-btn { background-color: #a8745b; color: #fff; border: none; padding: 10px 20px; border-radius: 20px; cursor: pointer; margin-top: 0.5rem; }
    #send-btn:hover { background-color: #8b5e47; }
  </style>
</head>
<body>

<h1>Chat with <?= htmlspecialchars($friend_name) ?></h1>

<div id="chat-box"></div>

<textarea id="message-input" placeholder="Type your message here..."></textarea>
<button id="send-btn">Send</button>

<script>
const userId = <?= json_encode($user_id) ?>;
const friendId = <?= json_encode($friend_id) ?>;
const chatBox = document.getElementById('chat-box');
const messageInput = document.getElementById('message-input');
const sendBtn = document.getElementById('send-btn');

function escapeHtml(text) {
  var div = document.createElement('div');
  div.textContent = text;
  return div.innerHTML;
}

function loadMessages() {
  fetch('chat_api.php?action=get_messages&friend_id=' + friendId)
    .then(res => res.json())
    .then(data => {
      chatBox.innerHTML = '';
      data.messages.forEach(msg => {
        const div = document.createElement('div');
        div.classList.add('message');
        div.classList.add(msg.sender_id === userId ? 'self' : 'other');
        div.innerHTML = '<div class="text">' + escapeHtml(msg.message) + '</div>';
        chatBox.appendChild(div);
      });
      chatBox.scrollTop = chatBox.scrollHeight;
    });
}

sendBtn.addEventListener('click', () => {
  const message = messageInput.value.trim();
  if (!message) return;
  
  fetch('chat_api.php', {
    method: 'POST',
    headers: {'Content-Type': 'application/x-www-form-urlencoded'},
    body: new URLSearchParams({
      action: 'send_message',
      friend_id: friendId,
      message: message
    })
  }).then(res => res.json())
    .then(data => {
      if (data.status === 'success') {
        messageInput.value = '';
        loadMessages();
      } else {
        alert('Failed to send message');
      }
    });
});

// Poll new messages every 3 seconds
setInterval(loadMessages, 3000);
loadMessages();
</script>

</body>
</html>
