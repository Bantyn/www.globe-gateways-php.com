<?php
include '../../database/config.php';
header('Content-Type: application/json');

$data = json_decode(file_get_contents("php://input"), true);

if(isset($data['review_id'])){
    $review_id = intval($data['review_id']);
    
    $sql = "DELETE FROM reviews WHERE review_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $review_id);

    if($stmt->execute()){
        echo json_encode(['success' => true]);
    } else {
        echo json_encode(['success' => false, 'error' => $stmt->error]);
    }

    $stmt->close();
} else {
    echo json_encode(['success' => false, 'error' => 'No review ID provided']);
}

$conn->close();
?>
