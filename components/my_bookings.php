<?php
include '../database/config.php';

if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

$username = $_SESSION['username'];

$result = $conn->query("SELECT * FROM users WHERE username='$username'");
if ($result && $result->num_rows > 0) {
    $user = $result->fetch_assoc();
    $user_id = $user['user_id'];
} else {
    die("User not found!");
}

// Handle payment update
if (isset($_POST['update_payment']) && !empty($_POST['pay_booking'])) {
    $paidBookings = $_POST['pay_booking'];
    foreach ($paidBookings as $bookingId) {

        // 1️⃣ Update booking table
        $conn->query("UPDATE bookings SET payment_status='Paid', status='Pending' WHERE booking_id='$bookingId'");

        // 2️⃣ Get booking details to insert into payment table
        $bookingResult = $conn->query("SELECT total_price FROM bookings WHERE booking_id='$bookingId'");
        $bookingData = $bookingResult->fetch_assoc();
        $amount = $bookingData['total_price'];

        // 3️⃣ Insert into payment table
        $paymentMethod = 'Demo'; 
        $paymentDate = date('Y-m-d H:i:s');
        $paymentStatus = 'Paid';

        $conn->query("
            INSERT INTO payments (user_id,booking_id, payment_method, amount, payment_date, payment_recevied)
            VALUES ('$user_id','$bookingId', '$paymentMethod', '$amount', '$paymentDate', '$paymentStatus')
        ");
    }

    // echo "<script>window.location.reload();</script>";
}

// Fetch bookings
$bookings = $conn->query("
    SELECT b.booking_id, p.title, b.booking_date, b.number_of_people, b.package_price, b.total_price, b.status, b.payment_status
    FROM bookings b 
    JOIN packages p ON b.package_id = p.package_id 
    WHERE b.user_id='$user_id' 
    ORDER BY b.booking_date DESC
");
?>


<div class="mybooking-container" style="margin-top: 10vw;">
    <h2>Your Booking History</h2>
    <form method="POST">
    <table class="booking-table"  cellspacing="6">
        <thead>
            <tr>
                <th>ID</th>
                <th>User ID</th>
                <th>Package</th>
                <th>Date</th>
                <th>People</th>
                <th>Package Price</th>
                <th>Total Price</th>
                <th>Payment</th>
                <th>Booking Status</th>
            </tr>
        </thead>
        <tbody>
            <?php while ($row = $bookings->fetch_assoc()): ?>
            <tr>
                <td><?= $row['booking_id']; ?></td>
                <td><?= $user_id; ?></td>
                <td><?= htmlspecialchars($row['title']); ?></td>
                <td><?= $row['booking_date']; ?></td>
                <td><?= $row['number_of_people']; ?></td>
                <td>₹ <?= $row['package_price']; ?></td>
                <td>₹ <?= $row['total_price']; ?></td>
                <td>
                    <?php if($row['payment_status'] == 'Paid'): ?>
                        Paid
                    <?php else: ?>
                        <input type="checkbox" name="pay_booking[]" value="<?= $row['booking_id']; ?>"> Mark To Paid
                    <?php endif; ?>
                </td>
                <td><span class="status <?= $row['status']; ?>"><?= ucfirst($row['status']); ?></span></td>
            </tr>
            <?php endwhile; ?>
        </tbody>
    </table>
    <button type="submit" name="update_payment" class="save-btn" type="submit">Update Payment</button>
    </form>
</div>
