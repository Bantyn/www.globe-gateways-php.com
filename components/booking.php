<?php
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

// Handle booking form submission
if (isset($_POST['book'])) {
    $package_id = intval($_POST['package_id']);
    $travel_date = $_POST['travel_date'];
    $num_people = intval($_POST['num_people']);

    // Get package price
    $price_query = "SELECT price FROM packages WHERE package_id = '$package_id'";
    $price_result = mysqli_query($conn, $price_query);
    $package_data = mysqli_fetch_assoc($price_result);

    if ($package_data) {
        $package_price = $package_data['price']; // price per person
        $total_price = $package_price * $num_people;

        // Insert booking
        $insert_query = "INSERT INTO bookings 
            (user_id, package_id, booking_date, number_of_people, package_price, total_price, status, created_at) 
            VALUES ('$user_id', '$package_id', '$travel_date', '$num_people', '$package_price', '$total_price', 'pending', NOW())";

        if (mysqli_query($conn, $insert_query)) {
            echo "<script>alert('Booking successful!'); window.location='index.php?mybooking=mybooking';</script>";
        } else {
            echo "<script>alert('Booking failed: " . mysqli_error($conn) . "');</script>";
        }
    } else {
        echo "<script>alert('Invalid package selected.');</script>";
    }
}

// Fetch single package safely
$package_id = isset($_GET['id']) ? intval($_GET['id']) : 0;
if ($package_id <= 0) {
    echo "<p>Invalid package ID.</p>";
    exit;
}

$packages_query = "SELECT * FROM packages WHERE package_id = $package_id";
$packages_result = mysqli_query($conn, $packages_query);

if (!$packages_result) {
    echo "<p>Error fetching package: " . mysqli_error($conn) . "</p>";
    exit;
}

$package = mysqli_fetch_assoc($packages_result);
if (!$package) {
    echo "<p>Package not found.</p>";
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>Book Package</title>
<link href="https://cdn.jsdelivr.net/npm/remixicon/fonts/remixicon.css" rel="stylesheet">
<style>
/* Reuse your dashboard CSS */
:root {
    --bg1-color: #EBEBEB;
    --bg2-color: #C7C2BC;
    --bg3-color: #7C806F;
    --black-color: #1B1B1B;
    --white-color: #EBEBEB;
    --main-font: 'sheryFont', sans-serif;
    --main-font-light: 'sheryFont2', sans-serif;
    --main-font-regular: 'sheryFont3', sans-serif;
    --main-font-semibold: 'sheryFont4', sans-serif;
}

body {
    height: 100%;
    background: var(--bg1-color);
    font-family: var(--main-font-regular);
}

.dashboard-container {
    padding: 2rem 4rem;
}

.dashboard-title {
    font-family: var(--main-font);
    font-size: 3rem;
    margin-bottom: 2rem;
    color: var(--black-color);
}

.package-card {
    background: var(--white-color);
    padding: 2rem;
    margin-bottom: 2rem;
    border-radius: 0.5rem;
    box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    display: flex;
    flex-direction: column;
    gap: 1rem;
}

.package-card h2 {
    font-family: var(--main-font-semibold);
    color: var(--black-color);
    font-size: 2rem;
    margin-bottom: 1rem;
}

.package-img {
    width: 100%;
    height: auto;
    border-radius: 0.5rem;
    object-fit: cover;
}

.package-description {
    font-family: var(--main-font-regular);
    font-size: 1rem;
    color: var(--black-color);
}

.sub-images {
    display: flex;
    gap: 0.5rem;
    flex-wrap: wrap;
}

.sub-img {
    width: calc(33% - 0.5rem);
    border-radius: 0.5rem;
    object-fit: cover;
}

.package-video {
    position: relative;
    width: 100%;
    padding-bottom: 56.25%;
    height: 0;
    overflow: hidden;
    border-radius: 0.5rem;
    margin: 1rem 0;
}

.package-video iframe {
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
}

.package-meta {
    font-family: var(--main-font-light);
    font-size: 0.9rem;
    color: var(--bg3-color);
}

.booking-form {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    margin-top: 1rem;
}

.booking-form label {
    font-family: var(--main-font-semibold);
    font-size: 1rem;
    color: var(--black-color);
}

.booking-form input {
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    border: 1px solid var(--bg2-color);
    font-family: var(--main-font-regular);
    font-size: 1rem;
}

.book-btn {
    background: var(--black-color);
    color: var(--white-color);
    border: none;
    padding: 0.7rem 1.5rem;
    border-radius: 0.25rem;
    font-family: var(--main-font-semibold);
    cursor: pointer;
    font-size: 1rem;
    transition: background 0.3s, transform 0.2s;
}

.book-btn:hover {
    background: #777777ff;
    transform: scale(1.02);
}

@media(max-width: 768px) {
    .dashboard-container {
        padding: 1rem 2rem;
    }
    .sub-img {
        width: calc(50% - 0.5rem);
    }
}
</style>
</head>
<body>
<div class="dashboard-container">
    <h1 class="dashboard-title">Book Your Package</h1>

    <div class="package-card">
        <h2><?= htmlspecialchars($package['title']); ?></h2>

        <?php if (!empty($package['main_image'])): ?>
            <img src="../../uploads/<?= htmlspecialchars($package['main_image']); ?>" alt="<?= htmlspecialchars($package['title']); ?>" class="package-img">
        <?php endif; ?>

        <?php if (!empty($package['description'])): ?>
            <p class="package-description"><?= htmlspecialchars($package['description']); ?></p>
        <?php endif; ?>

        <p><i class="ri-map-pin-line"></i> <strong>Location:</strong> <?= htmlspecialchars($package['location']); ?></p>
        <p><i class="ri-money-rupee-circle-line"></i> <strong>Price:</strong> ₹ <?= htmlspecialchars($package['price']); ?> / person</p>
        <p><i class="ri-time-line"></i> <strong>Duration:</strong> <?= htmlspecialchars($package['duration']); ?></p>
        <p><i class="ri-briefcase-line"></i> <strong>Package Type:</strong> <?= htmlspecialchars($package['package_type']); ?></p>

        <?php if (!empty($package['sub_images'])):
            $subImages = explode(',', $package['sub_images']); ?>
            <div class="sub-images">
                <?php foreach ($subImages as $img): ?>
                    <img src="../../uploads/<?= trim($img); ?>" alt="Sub Image" class="sub-img">
                <?php endforeach; ?>
            </div>
        <?php endif; ?>

        <?php if (!empty($package['video_url'])): ?>
            <div class="package-video">
                <iframe
                    src="https://www.youtube.com/embed/dQw4w9WgXcQ"
                    frameborder="0"
                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
                    allowfullscreen
                    title="Random Video">
                </iframe>
            </div>
        <?php endif; ?>

        <p class="package-meta"><i class="ri-calendar-line"></i> <strong>Created:</strong> <?= $package['created_at']; ?></p>
        <?php if (!empty($package['updated_at'])): ?>
            <p class="package-meta"><i class="ri-edit-line"></i> <strong>Updated:</strong> <?= $package['updated_at']; ?></p>
        <?php endif; ?>

        <form method="POST" class="booking-form">
            <input type="hidden" name="package_id" value="<?= $package['package_id']; ?>">
            <label for="travel_date">Travel Date:</label>
            <input type="date" id="travel_date" name="travel_date" required>

            <label for="num_people">Number of People:</label>
            <input type="number" id="num_people" name="num_people" min="1" required>

            <button type="submit" name="book" class="book-btn">Confirm Booking</button>
        </form>
    </div>
</div>
</body>
</html>
