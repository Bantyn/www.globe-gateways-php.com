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

// Handle review submission
if (isset($_POST['submit_review'])) {
    $bookingId = $_POST['booking_id'];
    $reviewText = $_POST['review_text'];
    $rating = $_POST['rating'];

    $bookingData = $conn->query("SELECT package_id FROM bookings WHERE booking_id='$bookingId'")->fetch_assoc();
    $package_id = $bookingData['package_id'];

    $stmt = $conn->prepare("INSERT INTO reviews (booking_id, package_id, user_id, review_text, rating, created_at) VALUES (?, ?, ?, ?, ?, NOW())");
    $stmt->bind_param("iiisi", $bookingId, $package_id, $user_id, $reviewText, $rating);
    $stmt->execute();

    header("Location: ".$_SERVER['PHP_SELF']); // refresh to show the new review
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

// Fetch reviews
$reviews = [];
$reviewResult = $conn->query("SELECT * FROM reviews WHERE user_id='$user_id'");
while ($r = $reviewResult->fetch_assoc()) {
    $reviews[$r['booking_id']] = $r;
}
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
                        <th>Review</th>
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
                        <td>
                            <?php if(isset($reviews[$row['booking_id']])): ?>
                                <span class="review-text"><?= htmlspecialchars($reviews[$row['booking_id']]['review_text']); ?> (<?= $reviews[$row['booking_id']]['rating']; ?>/5)</span>
                            <?php else: ?>
                                <button type="button" class="edit-button review-btn" data-id="<?= $row['booking_id']; ?>">Add Review</button>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php endwhile; ?>
                </tbody>
            </table>
        </div>
        <?php if($bookings->num_rows > 0): ?>
            <button type="submit" name="update_payment" class="edit-button save-btn">Update Payment</button>
        <?php endif; ?>
    </form>

    <!-- Review forms (separate from payment form) -->
    <?php foreach ($bookings as $row): ?>
        <?php if(!isset($reviews[$row['booking_id']])): ?>
        <div class="review-row" id="review-form-<?= $row['booking_id']; ?>" style="display:none; margin-top:1rem;">
            <form method="POST" class="review-card">
                <input type="hidden" name="booking_id" value="<?= $row['booking_id']; ?>">
                <textarea name="review_text" placeholder="Write your review..." required></textarea>
                <label>Rating:
                    <select name="rating">
                        <option value="1">1</option>
                        <option value="2">2</option>
                        <option value="3">3</option>
                        <option value="4">4</option>
                        <option value="5" selected>5</option>
                    </select>
                </label>
                <button type="submit" name="submit_review" class="save-btn">Submit Review</button>
            </form>
        </div>
        <?php endif; ?>
    <?php endforeach; ?>
</div>

<script>
// Toggle review form
document.querySelectorAll('.review-btn').forEach(btn => {
    btn.addEventListener('click', function() {
        const bookingId = this.getAttribute('data-id');
        const formRow = document.getElementById('review-form-' + bookingId);
        formRow.style.display = formRow.style.display === 'none' ? 'block' : 'none';
        formRow.scrollIntoView({behavior: "smooth", block: "center"});
    });
});
</script>

<style>
.dashboard-container { padding:2rem 4rem; font-family: var(--main-font-semibold); }
.dashboard-header { display:flex; justify-content:space-between; align-items:center; margin-bottom:2rem; font-size:3vmin; }
.dashboard-header h1 { font-family: var(--main-font-light); font-size:2.5rem; letter-spacing:0.05em; color:var(--black-color); }
.table-container { width:100%; overflow-x:auto; background:var(--white-color); border-radius:0.5rem; box-shadow:0 4px 12px rgba(0,0,0,0.1);}
.booking-table { width:100%; border-collapse:collapse;}
.booking-table th, .booking-table td { padding:1rem 1.2rem; text-align:left; border-bottom:1px solid var(--bg2-color); font-size:1rem;}
.booking-table th { background:var(--black-color); color:var(--white-color); text-transform:uppercase;}
.booking-table tr:hover { background:var(--bg2-color);}
.edit-button, .save-btn { background:var(--black-color); color:var(--white-color); border:none; padding:0.7rem 1.5rem; border-radius:0.25rem; cursor:pointer; transition:background 0.3s; font-family: var(--main-font-semibold);}
.edit-button:hover, .save-btn:hover { background:#858585ff;}
.status.pending { color: orange; font-weight: 600; }
.status.confirmed { color: green; font-weight: 600; }
.status.cancelled { color: crimson; font-weight: 600; }
.paid-status { color: green; font-weight: bold; }
.checkbox-pay { transform: scale(1.1); margin-right: 0.3rem; }
.review-card { background: var(--bg1-color); padding:1rem; border-radius:0.5rem; display:flex; flex-direction:column; gap:0.5rem; margin-bottom:1rem;}
.review-card textarea { width:100%; padding:0.5rem; font-family:var(--main-font-regular); font-size
