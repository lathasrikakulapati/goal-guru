<?php
session_start();
require 'db.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit();
}

$user_id = $_SESSION['user_id'];
$action = $_REQUEST['action'] ?? '';

function check_stmt_error($stmt) {
    if ($stmt->errno) {
        error_log("SQL Error: " . $stmt->error);
        echo json_encode(['status' => 'error', 'message' => 'Database error']);
        exit();
    }
}

if ($action === 'get_messages') {
    $friend_id = intval($_GET['friend_id'] ?? 0);
    if ($friend_id === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Invalid friend id']);
        exit();
    }
    // Verify friendship (same as in chat.php)
    global $conn;
    $stmt = $conn->prepare("
        SELECT 1 FROM friends WHERE
        (user1_id = ? AND user2_id = ?) OR (user1_id = ? AND user2_id = ?)
    ");
    $stmt->bind_param("iiii", $user_id, $friend_id, $friend_id, $user_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Not friends']);
        exit();
    }
    $stmt->close();

    // Fetch last 50 messages between the two users ordered by created_at
    $stmt = $conn->prepare("
        SELECT sender_id, message, created_at
        FROM messages
        WHERE (sender_id = ? AND receiver_id = ?) OR (sender_id = ? AND receiver_id = ?)
        ORDER BY created_at ASC
        LIMIT 50
    ");
    $stmt->bind_param("iiii", $user_id, $friend_id, $friend_id, $user_id);
    $stmt->execute();
    check_stmt_error($stmt);
    $result = $stmt->get_result();
    $messages = [];
    while ($row = $result->fetch_assoc()) {
        $messages[] = $row;
    }
    $stmt->close();

    echo json_encode(['status' => 'success', 'messages' => $messages]);
    exit;
}

if ($action === 'send_message' && $_SERVER['REQUEST_METHOD'] === 'POST') {
    $friend_id = intval($_POST['friend_id'] ?? 0);
    $message = trim($_POST['message'] ?? '');

    if ($friend_id === 0 || $message === '') {
        echo json_encode(['status' => 'error', 'message' => 'Invalid input']);
        exit();
    }

    // Verify friendship (same as above)
    global $conn;
    $stmt = $conn->prepare("
        SELECT 1 FROM friends WHERE
        (user1_id = ? AND user2_id = ?) OR (user1_id = ? AND user2_id = ?)
    ");
    $stmt->bind_param("iiii", $user_id, $friend_id, $friend_id, $user_id);
    $stmt->execute();
    $stmt->store_result();
    if ($stmt->num_rows === 0) {
        echo json_encode(['status' => 'error', 'message' => 'Not friends']);
        exit();
    }
    $stmt->close();

    // Insert message into messages table
    $stmt = $conn->prepare("
        INSERT INTO messages (sender_id, receiver_id, message, created_at)
        VALUES (?, ?, ?, NOW())
    ");
    $stmt->bind_param("iis", $user_id, $friend_id, $message);
    $stmt->execute();
    check_stmt_error($stmt);
    $stmt->close();

    echo json_encode(['status' => 'success']);
    exit;
}

echo json_encode(['status' => 'error', 'message' => 'Invalid action']);
exit;
