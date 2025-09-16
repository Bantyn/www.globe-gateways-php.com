<?php
include ("../../database/config.php");
header('Content-Type: application/json');

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payment_id = $_POST['payment_id'] ?? null;
    $status = $_POST['status'] ?? null;

    if (!$payment_id || !$status) {
        echo json_encode([
            "success" => false,
            "message" => "Missing required fields."
        ]);
        exit;
    }

    // 1️⃣ Update payments table
    $sql = "UPDATE payments SET status=? WHERE payment_id=?";
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, "si", $status, $payment_id);

    if (!mysqli_stmt_execute($stmt)) {
        echo json_encode([
            "success" => false,
            "message" => "Failed to update payment status."
        ]);
        exit;
    }

    // 2️⃣ Optional: update bookings table if payment is done
    if ($status === "Done") {
        // Get booking_id linked to this payment
        $result = mysqli_query($conn, "SELECT booking_id FROM payments WHERE payment_id=$payment_id");
        $row = mysqli_fetch_assoc($result);
        if ($row) {
            $booking_id = $row['booking_id'];
            $sql2 = "UPDATE bookings SET status='Paid' WHERE booking_id=?";
            $stmt2 = mysqli_prepare($conn, $sql2);
            mysqli_stmt_bind_param($stmt2, "i", $booking_id);
            mysqli_stmt_execute($stmt2);
        }
    }

    echo json_encode([
        "success" => true,
        "message" => "Payment status updated successfully."
    ]);

} else {
    echo json_encode([
        "success" => false,
        "message" => "Invalid request method."
    ]);
}
?>
