<?php
header("Content-Type: application/json");
include "../database/config.php"; // adjust path if needed

try {
    $sql = "SELECT contact_id, full_name, email, subject, message, created_at FROM contact ORDER BY created_at DESC";
    $result = $conn->query($sql);

    $contacts = [];
    if ($result && $result->num_rows > 0) {
        while ($row = $result->fetch_assoc()) {
            $contacts[] = $row;
        }
    }

    echo json_encode($contacts);
} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(["success" => false, "message" => $e->getMessage()]);
}
?>
