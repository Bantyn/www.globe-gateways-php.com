<?php
header("Content-Type: application/json");
include "../../database/config.php"; 

if ($_SERVER["REQUEST_METHOD"] === "GET") {
    $package_id = isset($_GET['id']) ? intval($_GET['id']) : 0;

    if ($package_id > 0) {
        $stmt = $conn->prepare("DELETE FROM packages WHERE package_id = ?");
        $stmt->bind_param("i", $package_id);

        if ($stmt->execute()) {
            echo json_encode([
                "success" => true,
                "message" => "Package deleted successfully."
            ]);
        } else {
            echo json_encode([
                "success" => false,
                "message" => "Failed to delete package."
            ]);
        }

        $stmt->close();
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Invalid package ID."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method. Use GET."
    ]);
}
?>
