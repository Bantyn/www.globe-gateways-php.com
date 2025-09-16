<?php
include("../../database/config.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_id = $_POST['booking_id'] ?? null;
    $status = $_POST['status'] ?? null;

    // Only allow ENUM values
    $allowed_status = ['Pending', 'Confirmed', 'Cancelled'];
    if (!$booking_id || !in_array($status, $allowed_status)) {
        echo json_encode([
            "success" => false,
            "message" => "Invalid booking ID or status."
        ]);
        exit;
    }

    $sql = "UPDATE bookings SET status=? WHERE booking_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $booking_id);

    if (mysqli_stmt_execute($stmt)) {
        echo json_encode([
            "success" => true,
            "message" => "Booking status updated successfully."
        ]);
    } else {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update booking status."
        ]);
    }
} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}
?>
