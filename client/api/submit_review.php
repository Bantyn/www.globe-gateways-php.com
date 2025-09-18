<?php
session_start();
include '../../database/config.php';

// Check if user is logged in
if (!isset($_SESSION['username'])) {
    echo json_encode(['success' => false, 'message' => 'User not logged in.']);
    exit;
}

// Validate POST data
$user_query = $conn->query("SELECT user_id FROM users WHERE username='" . $_SESSION['username'] . "'");
$user = $user_query->fetch_assoc();
$user_id = $user['user_id'] ?? 0;

$booking_id = $_POST['booking_id'] ?? 0;
$package_id = $_POST['package_id'] ?? 0;
$review_text = trim($_POST['review_text'] ?? '');
$rating = intval($_POST['rating'] ?? 0);

if (!$booking_id || !$package_id || !$review_text || !$rating) {
    echo json_encode(['success' => false, 'message' => 'Invalid input.']);
    exit;
}

// Check if review already exists
$check = $conn->query("SELECT * FROM reviews WHERE booking_id='$booking_id' AND user_id='$user_id'");
if ($check->num_rows > 0) {
    // Update existing review
    $stmt = $conn->prepare("UPDATE reviews SET comment=?, rating=?, updated_at=NOW() WHERE booking_id=? AND user_id=?");
    $stmt->bind_param("siii", $review_text, $rating, $booking_id, $user_id);
    $stmt->execute();
} else {
    // Insert new review
    $stmt = $conn->prepare("INSERT INTO reviews (user_id, booking_id, package_id, comment, rating, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiisi", $user_id, $booking_id, $package_id, $review_text, $rating);
    $stmt->execute();
}

echo json_encode(['success' => true, 'review_text' => htmlspecialchars($review_text), 'rating' => $rating]);
exit;
