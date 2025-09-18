<?php
include "../database/config.php"; 

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $contact_id = isset($_POST["contact_id"]) ? intval($_POST["contact_id"]) : 0;

    if ($contact_id > 0) {
        $stmt = $conn->prepare("DELETE FROM contact WHERE contact_id = ?");
        $stmt->bind_param("i", $contact_id);

        if ($stmt->execute()) {
            echo json_encode(["success" => true, "message" => "Contact deleted successfully."]);
        } else {
            echo json_encode(["success" => false, "message" => "Failed to delete contact."]);
        }

        $stmt->close();
    } else {
        echo json_encode(["success" => false, "message" => "Invalid contact ID."]);
    }
} else {
    echo json_encode(["success" => false, "message" => "Invalid request method."]);
}
?>
