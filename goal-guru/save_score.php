<?php
require 'session.php';
require 'db.php';

$data = json_decode(file_get_contents("php://input"), true);

if ($data && isset($data['course']) && isset($data['score'])) {
    $course = $data['course'];
    $score = (int)$data['score'];
    $email = $_SESSION['email'];

    if ($score >= 80) {
        $stmt = $conn->prepare("INSERT INTO course_completed (user_email, course_name, score) 
                                VALUES (?, ?, ?) 
                                ON DUPLICATE KEY UPDATE score = VALUES(score), completed_at = CURRENT_TIMESTAMP");
        $stmt->bind_param("ssi", $email, $course, $score);
        $stmt->execute();
        echo "Course completion saved.";
    } else {
        echo "Score too low.";
    }
} else {
    echo "Invalid or missing input.";
}
?>