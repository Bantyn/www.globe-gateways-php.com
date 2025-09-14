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
$user_id = $user['user_id'];

if (isset($_POST['book'])) {
    $package_id = $_POST['package_id'];
    $travel_date = $_POST['travel_date'];
    $num_people = $_POST['num_people'];

    // Get package price
    $price_query = "SELECT price FROM packages WHERE package_id = '$package_id'";
    $price_result = mysqli_query($conn, $price_query);
    $package_data = mysqli_fetch_assoc($price_result);

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
}

// Fetch package details
$packages_query = "SELECT * FROM packages WHERE package_id = " . $_GET['id'];
$packages_result = mysqli_query($conn, $packages_query);
?>

<body>
    <div class="dashboard-container">
        <h1 class="dashboard-title">Book Your Package</h1>

        <?php while ($package = mysqli_fetch_assoc($packages_result)): ?>
            <div class="package-card">
                <div class="package-card">
                    <!-- Title -->
                    <h2><?= htmlspecialchars($package['title']); ?></h2>

                    <!-- Main Image -->
                    <?php if (!empty($package['main_image'])): ?>
                        <img src="../../uploads/<?= htmlspecialchars($package['main_image']); ?>" alt="<?= htmlspecialchars($package['title']); ?>" class="package-img">
                    <?php endif; ?>

                    <!-- Description -->
                    <?php if (!empty($package['description'])): ?>
                        <p class="package-description"><?= htmlspecialchars($package['description']); ?></p>
                    <?php endif; ?>

                    <!-- Location -->
                    <p><i class="ri-map-pin-line"></i> <strong>Location:</strong> <?= htmlspecialchars($package['location']); ?></p>

                    <!-- Price -->
                    <p><i class="ri-money-rupee-circle-line"></i> <strong>Price:</strong> ₹ <?= htmlspecialchars($package['price']); ?> / person</p>

                    <!-- Duration -->
                    <p><i class="ri-time-line"></i> <strong>Duration:</strong> <?= htmlspecialchars($package['duration']); ?></p>

                    <!-- Package Type -->
                    <p><i class="ri-briefcase-line"></i> <strong>Package Type:</strong> <?= htmlspecialchars($package['package_type']); ?></p>

                    <!-- Sub Images -->
                    <?php if (!empty($package['sub_images'])):
                        $subImages = explode(',', $package['sub_images']); ?>
                        <div class="sub-images">
                            <?php foreach ($subImages as $img): ?>
                                <img src="../../uploads/<?= trim($img); ?>" alt="Sub Image" class="sub-img">
                            <?php endforeach; ?>
                        </div>
                    <?php endif; ?>

                    <!-- Video -->
                    <?php if (!empty($package['video_url'])): ?>
                        <div class="package-video">
                            <iframe src="<?= htmlspecialchars($package['video_url']); ?>" frameborder="0" allowfullscreen></iframe>
                        </div>
                    <?php endif; ?>

                    <!-- Created & Updated Dates -->
                    <p class="package-meta"><i class="ri-calendar-line"></i> <strong>Created:</strong> <?= $package['created_at']; ?></p>
                    <?php if (!empty($package['updated_at'])): ?>
                        <p class="package-meta"><i class="ri-edit-line"></i> <strong>Updated:</strong> <?= $package['updated_at']; ?></p>
                    <?php endif; ?>
                </div>
                <form method="POST" class="booking-form">
                    <input type="hidden" name="package_id" value="<?= $package['package_id']; ?>">

                    <label for="travel_date">Travel Date:</label>
                    <input type="date" id="travel_date" name="travel_date" required>

                    <label for="num_people">Number of People:</label>
                    <input type="number" id="num_people" name="num_people" min="1" required>

                    <button type="submit" name="book" class="book-btn">Confirm Booking</button>
                </form>
            </div>
        <?php endwhile; ?>
    </div>
</body>
