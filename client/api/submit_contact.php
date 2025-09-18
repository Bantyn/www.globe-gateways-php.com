<?php
include '../../database/config.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $full_name = trim($_POST['full_name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $subject = trim($_POST['subject'] ?? '');
    $message = trim($_POST['message'] ?? '');
    $created_at = date("Y-m-d H:i:s");

    if (empty($full_name) || empty($email) || empty($subject) || empty($message)) {
        echo json_encode(['success' => false, 'message' => 'All fields are required.']);
        exit;
    }

    $stmt = $conn->prepare("INSERT INTO contact (full_name, email, subject, message, created_at) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $full_name, $email, $subject, $message, $created_at);

    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Message sent successfully!']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to store message.']);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode(['success' => false, 'message' => 'Invalid request method.']);
}
?>
