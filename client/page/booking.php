
<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: login.php");
    exit();
}
include '../../database/config.php';
include '../../components/navbar.php';
$username = $_SESSION['username'];
$query = "SELECT * FROM users WHERE username = '$username'";
$result = mysqli_query($conn, $query);
$user = mysqli_fetch_assoc($result);

$user_id = $user['user_id'];

if (isset($_POST['book'])) {
    $package_id = $_POST['package_id'];
    $travel_date = $_POST['travel_date'];
    $num_people = $_POST['num_people'];

    $price_query = "SELECT price FROM packages WHERE package_id = '$package_id'";
    $price_result = mysqli_query($conn, $price_query);
    $package_data = mysqli_fetch_assoc($price_result);
    $price = $package_data['price'];

    $insert_query = "INSERT INTO bookings (user_id, package_id, booking_date, number_of_people, total_price,status) 
                     VALUES ('$user_id', '$package_id', '$travel_date', '$num_people', '$price','pending')";

    if (mysqli_query($conn, $insert_query)) {
        echo "<script>alert('Booking successful!');</script>";
    } else {
        echo "<script>alert('Booking failed. Please try again.');</script>";
    }
}
$packages_query = "SELECT * FROM packages where package_id = ".$_GET['id'];
$packages_result = mysqli_query($conn, $packages_query);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book a Package - Globe Gateways</title>
    <link rel="stylesheet" href="../../assets/css/main.style.css">
    <!-- <link rel="stylesheet" href="../../assets/css/dashboard.style.css"> -->
</head>
<body>
    <div class="dashboard-container">
    <h1 class="dashboard-title">Book a Travel Package</h1>

    <?php while ($package = mysqli_fetch_assoc($packages_result)): ?>
        <div class="package-details">
            <h2><?= htmlspecialchars($package['title']); ?></h2>
            <p><strong>Description:</strong> <?= htmlspecialchars($package['description']); ?></p>
            <p><strong>Price:</strong> ₹<?= htmlspecialchars($package['price']); ?></p>

            <form method="POST" class="booking-form">
                <input type="hidden" name="package_id" value="<?= $package['package_id']; ?>">

                <label for="travel_date_<?= $package['package_id']; ?>">Travel Date:</label>
                <input type="date" id="travel_date_<?= $package['package_id']; ?>" name="travel_date" required>

                <label for="num_people_<?= $package['package_id']; ?>">Number of People:</label>
                <input type="number" id="num_people_<?= $package['package_id']; ?>" name="num_people" min="1" required>

                <button type="submit" name="book">Book Now</button>
            </form>
        </div>
    <?php endwhile; ?>
</div>
</body>
<style>
   .dashboard-container {
    padding: 50px;
    max-width: 700px;
    margin: auto;
    display: flex;
    flex-direction: column;
    align-items: center;
    justify-content: center;
    min-height: 100vh;
}

.package-details {
    margin-bottom: 40px;
}

.package-details h2 {
    font-size: 2em;
    margin-bottom: 10px;
    color: #333;
}

.package-details p {
    font-size: 1.1em;
    margin-bottom: 8px;
}

.booking-form label {
    display: block;
    margin-top: 10px;
    font-weight: bold;
}

.booking-form input {
    width: 100%;
    padding: 8px;
    margin: 5px 0 15px 0;
    border: 1px solid #ccc;
    border-radius: 4px;
}

.booking-form button {
    background-color: #27ae60;
    color: white;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
}

.booking-form button:hover {
    background-color: #219150;
}


    </style>
</html>