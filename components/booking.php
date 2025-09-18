<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}

include '../database/config.php';

$username = $_SESSION['username'];

// Get logged-in user
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);
$user_id = $user['user_id'] ?? 0;

// Safe defaults
$user_name   = $user['full_name'] ?? '';
$user_email  = $user['email'] ?? '';
$user_mobile = $user['mobile'] ?? '';

// Handle booking form submission
if (isset($_POST['book'])) {
    $package_id = intval($_POST['package_id']);
    $travel_from = $_POST['travel_from'];
    $travel_to = $_POST['travel_to'];
    $num_people = intval($_POST['num_people']);

    // Editable user info
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $mobile = mysqli_real_escape_string($conn, $_POST['mobile']);

    // Update user info
    mysqli_query($conn, "UPDATE users SET full_name='$name', email='$email', mobile='$mobile' WHERE user_id='$user_id'");

    if ($travel_to < $travel_from) {
        echo "<script>alert('End date must be after start date.');</script>";
    } else {
        $price_query = "SELECT price FROM packages WHERE package_id = '$package_id'";
        $price_result = mysqli_query($conn, $price_query);
        $package_data = mysqli_fetch_assoc($price_result);

        if ($package_data) {
            $package_price = $package_data['price'];
            $total_price = $package_price * $num_people;

            $insert_query = "INSERT INTO bookings 
                (user_id, package_id, travel_from, travel_to, number_of_people, package_price, total_price, status, created_at) 
                VALUES ('$user_id', '$package_id', '$travel_from', '$travel_to', '$num_people', '$package_price', '$total_price', 'pending', NOW())";

            if (mysqli_query($conn, $insert_query)) {
                echo "<script>alert('Booking successful!'); window.location='index.php?mybooking=mybooking';</script>";
                exit();
            } else {
                echo "<script>alert('Booking failed: " . mysqli_error($conn) . "');</script>";
            }
        } else {
            echo "<script>alert('Invalid package selected.');</script>";
        }
    }
}

// Fetch package
$package_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($package_id <= 0) { echo "<p>Invalid package ID.</p>"; exit; }

$packages_query = "SELECT * FROM packages WHERE package_id = $package_id";
$packages_result = mysqli_query($conn, $packages_query);
$package = mysqli_fetch_assoc($packages_result);
if (!$package) { echo "<p>Package not found.</p>"; exit; }

// Fetch all reviews for this package
$reviews_query = "SELECT r.*, u.full_name 
                  FROM reviews r
                  JOIN users u ON r.user_id = u.user_id
                  WHERE r.package_id = $package_id
                  ORDER BY r.created_at DESC";
$reviews_result = mysqli_query($conn, $reviews_query);
$reviews = [];
while($row = mysqli_fetch_assoc($reviews_result)) $reviews[] = $row;
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Package</title>
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
<style>
body { font-family: Arial, sans-serif; margin:20px; }
.dashboard-title { text-align:center; margin-bottom:20px; }
.package-card { border:1px solid #ddd; padding:20px; border-radius:10px; max-width:800px; margin:auto; }
.package-card img { max-width:100%; border-radius:10px; margin-bottom:10px; }
.package-card .sub-images { display:flex; gap:10px; flex-wrap:wrap; margin-bottom:10px; }
.sub-img { width:100px; height:80px; object-fit:cover; border-radius:5px; }
.booking-form { margin-top:20px; display:flex; flex-direction:column; gap:10px; }
.booking-form input, .booking-form textarea, .booking-form select, .booking-form button { padding:8px; font-size:14px; }
.book-btn { cursor:pointer; background:#000; color:#fff; border:none; border-radius:5px; }

.package-reviews { margin-top:40px; max-width:800px; margin:auto; }
.package-reviews h3 { margin-bottom:15px; }

.review-card { background:#f5f5f5; padding:15px; border-radius:8px; margin-bottom:10px; }
.review-card strong { font-weight:600; }
.review-card span { color:#f39c12; margin-left:10px; }
.review-card p { margin:5px 0; }
.review-card small { color:#666; }

.review-form { display:flex; flex-direction:column; gap:10px; margin-bottom:20px; }
.review-form textarea { min-height:60px; }
.review-form button { width:150px; cursor:pointer; background:#007BFF; color:#fff; border:none; border-radius:5px; }
</style>
</head>
<body>

<h1 class="dashboard-title">Book Your Package</h1>

<div class="package-card">
    <h2><?= htmlspecialchars($package['title']); ?></h2>

    <?php if (!empty($package['main_image'])): ?>
        <img src="../../www.globe-gateways-php.com/uploads/<?= htmlspecialchars($package['main_image']); ?>" alt="<?= htmlspecialchars($package['title']); ?>">
    <?php endif; ?>

    <p><strong>Location:</strong> <?= htmlspecialchars($package['location']); ?></p>
    <p><strong>Price:</strong> ₹ <?= htmlspecialchars($package['price']); ?> / person</p>
    <p><strong>Duration:</strong> <?= htmlspecialchars($package['duration']); ?></p>
    <p><strong>Package Type:</strong> <?= htmlspecialchars($package['package_type']); ?></p>

    <?php if (!empty($package['sub_images'])):
        $subImages = explode(',', $package['sub_images']); ?>
        <div class="sub-images">
            <?php foreach ($subImages as $img): ?>
                <img src="../../www.globe-gateways-php.com/uploads/<?= trim($img); ?>" alt="Sub Image" class="sub-img">
            <?php endforeach; ?>
        </div>
    <?php endif; ?>

    <form method="POST" class="booking-form">
        <input type="hidden" name="package_id" value="<?= $package['package_id']; ?>">
        <label>Full Name: <input type="text" name="name" value="<?= htmlspecialchars($user_name); ?>" required></label>
        <label>Email: <input type="email" name="email" value="<?= htmlspecialchars($user_email); ?>" required></label>
        <label>Mobile: <input type="tel" name="mobile" value="<?= htmlspecialchars($user_mobile); ?>" required pattern="[0-9]{10}"></label>
        <label>Travel From: <input type="date" name="travel_from" required></label>
        <label>Travel To: <input type="date" name="travel_to" required></label>
        <label>Number of People: <input type="number" name="num_people" min="1" required></label>
        <button type="submit" name="book" class="book-btn">Confirm Booking</button>
    </form>
</div>

<div class="package-reviews">
    <h3>Reviews</h3>

    <?php if (!isset($_SESSION['user_review_submitted'])): ?>
    <form id="reviewForm" class="review-form" data-package="<?= $package_id; ?>">
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
        <button type="submit">Submit Review</button>
    </form>
    <?php endif; ?>

    <div id="reviewsList">
        <?php foreach($reviews as $rev): ?>
            <div class="review-card">
                <strong><?= htmlspecialchars($rev['full_name']); ?></strong>
                <span>⭐ <?= $rev['rating']; ?>/5</span>
                <p><?= htmlspecialchars($rev['comment']); ?></p>
                <small><?= $rev['created_at']; ?></small>
            </div>
        <?php endforeach; ?>
    </div>
</div>

<script>
// Submit review via AJAX
document.getElementById('reviewForm')?.addEventListener('submit', function(e){
    e.preventDefault();
    const form = this;
    const formData = new FormData(form);
    formData.append('package_id', form.dataset.package);

    fetch('../client/api/submit_review.php', { method:'POST', body:formData })
    .then(res => res.json())
    .then(data => {
        if(data.success){
            const reviewsList = document.getElementById('reviewsList');
            const div = document.createElement('div');
            div.classList.add('review-card');
            div.innerHTML = `<strong>You</strong> <span>⭐ ${data.rating}/5</span>
                             <p>${data.review_text}</p>
                             <small>Just now</small>`;
            reviewsList.prepend(div);
            form.style.display = 'none'; // hide form after submit
        } else alert(data.message || 'Error submitting review');
    })
    .catch(err => console.error(err));
});
</script>
</body>
</html>
