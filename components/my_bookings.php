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
    foreach ($_POST['pay_booking'] as $bookingId) {
        $conn->query("UPDATE bookings SET payment_status='Paid', status='Pending' WHERE booking_id='$bookingId'");
        $bookingData = $conn->query("SELECT total_price FROM bookings WHERE booking_id='$bookingId'")->fetch_assoc();
        $amount = $bookingData['total_price'];
        $conn->query("INSERT INTO payments (user_id, booking_id, payment_method, amount, payment_date, payment_recevied)
            VALUES ('$user_id','$bookingId','Demo','$amount', NOW(), 'Paid')");
    }
    header("Location: index.php?profile=profile"); // refresh to show updated status
    exit();
}

// Fetch bookings
$bookings = $conn->query("
    SELECT b.booking_id, p.package_id, p.title, b.booking_date, b.number_of_people, b.package_price, b.total_price, b.status, b.payment_status
    FROM bookings b 
    JOIN packages p ON b.package_id = p.package_id 
    WHERE b.user_id='$user_id' 
    ORDER BY b.booking_date DESC
");
?>

<div class="dashboard-container" style="margin-top:5vw;">
    <div class="dashboard-header">
        <h1>Your Booking History</h1>
        <div>Welcome <?= htmlspecialchars($username); ?></div>
    </div>

    <!-- Payment update form -->
    <form method="POST">
        <div class="table-container">
            <table class="booking-table">
                <thead>
                    <tr>
                        <th>ID</th>
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
                        <td><?= htmlspecialchars($row['title']); ?></td>
                        <td><?= $row['booking_date']; ?></td>
                        <td><?= $row['number_of_people']; ?></td>
                        <td>₹ <?= $row['package_price']; ?></td>
                        <td>₹ <?= $row['total_price']; ?></td>
                        <td>
                            <?php if($row['payment_status'] == 'Paid'): ?>
                                <span class="paid-status">Paid</span>
                            <?php else: ?>
                                <input type="checkbox" name="pay_booking[]" value="<?= $row['booking_id']; ?>" class="checkbox-pay"> Mark Paid
                            <?php endif; ?>
                        </td>
                        <td><span class="status <?= strtolower($row['status']); ?>"><?= ucfirst($row['status']); ?></span></td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php if($bookings->num_rows > 0): ?>
            <button type="submit" name="update_payment" class="edit-button save-btn">Update Payment</button>
        <?php endif; ?>
    </form>
</div>

<style>
.dashboard-container { padding:2rem 4rem; font-family: Arial, sans-serif; }
.dashboard-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; font-size:3vmin; }
.dashboard-header h1 { font-size:2.5rem; color:#1B1B1B; }
.table-container { width:100%; overflow-x:auto; background:#EBEBEB; border-radius:0.5rem; box-shadow:0 4px 12px rgba(0,0,0,0.1);}
.booking-table { width:100%; border-collapse:collapse;}
.booking-table th, .booking-table td { padding:1rem 1.2rem; text-align:left; border-bottom:1px solid #C7C2BC; font-size:1rem;}
.booking-table th { background:#1B1B1B; color:#EBEBEB; text-transform:uppercase;}
.booking-table tr:hover { background:#C7C2BC;}
.edit-button, .save-btn { background:#1B1B1B; color:#EBEBEB; border:none; padding:0.7rem 1.5rem; border-radius:0.25rem; cursor:pointer; transition:background 0.3s;}
.edit-button:hover, .save-btn:hover { background:#858585ff;}
.status.pending { color: orange; font-weight: 600; }
.status.confirmed { color: green; font-weight: 600; }
.status.cancelled { color: crimson; font-weight: 600; }
.paid-status { color: green; font-weight: bold; }
.checkbox-pay { transform: scale(1.1); margin-right: 0.3rem; }
</style>
