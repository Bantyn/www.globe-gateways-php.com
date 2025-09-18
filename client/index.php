<?php
session_start();
?>
<?php
include '../database/config.php';


$packages = [];
$result = $conn->query("SELECT * FROM packages");
if ($result && $result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $packages[] = $row;
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Globe Gateways | Home</title>
    <link rel="stylesheet" href="../assets/css/main.style.css">
    <link
        href="https://cdn.jsdelivr.net/npm/remixicon@4.5.0/fonts/remixicon.css"
        rel="stylesheet" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sheryjs/dist/Shery.css" />

</head>

<body>
    <!-- Header -->
    <header>
        <?php include '../components/navbar.php'; ?>
    </header>
    <!-- Main Content -->
    <main>
        <?php if (isset($_SESSION['username'])): ?>
            <!-- After signup -->
            <?php
            if (isset($_GET['home'])) {
                include '../components/home.php';
            } elseif (isset($_GET['about'])) {
                include '../components/about.php';
            } elseif (isset($_GET['contact'])) {
                include '../components/contact.php';
            } elseif (isset($_GET['mybooking'])) {
                include '../components/my_bookings.php';
            } elseif (isset($_GET['booking'])) {
                include '../components/booking.php';
            } elseif (isset($_GET['profile'])) {
                include '../components/profile.php';
            } else {
                include '../components/home.php'; // Default to home if no parameter is set
            }
            ?>

        <?php else: ?>
            <!-- Before signup -->
            <!-- 🔹 First Container -->
            <div class="home-main section" style="background: url('./assets/images/bg1.jpg') center/cover no-repeat;">
                <div class="overlay"></div>
                <div class="title-container">
                    <div class="globeGateways magnet">
                        <p class="text-animate">your one-stop solution for all your gateway needs.</p>
                        <h1 class="magnet" style="display:inline;">Globe</h1>
                        <h1 class="magnet" style="display:inline;">Gateways</h1>
                        <p class="tagline">Trusted by thousands of happy travelers 🌍</p>
                    </div>
                </div>
            </div>
            <div class="package-main">
                <a href="page/signup.php"><button class="exploreBtn hvr">Explore Packages</button></a>
            </div>
             <!-- Packages Section -->
            <div class="packages-section">
                <h2>Our Popular Packages</h2>
                <div class="packages-container">
                    <?php foreach ($packages as $package): ?>
                        <div class="package-card">
                            <img src="../../www.globe-gateways-php.com/uploads/<?php echo $package['main_image']; ?>" alt="<?php echo $package['title']; ?>">
                            <h3><?php echo $package['title']; ?></h3>
                            <p>Starting at <?php echo $package['price']; ?></p>
                            <p>Duration <?php echo $package['duration']; ?></p>
                            <?php if (isset($_SESSION['username'])): ?>
                                <a href="page/booking.php?package=<?php echo urlencode($package['title']); ?>" class="btn">Book Now</a>
                            <?php else: ?>
                                <a href="page/signup.php"><button class="exploreBtn magnet">Login To view</button></a>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
                <style>
                    .packages-section {
                        padding: 2rem;
                        text-align: center;
                    }

                    .packages-container {
                        display: flex;
                        gap: 1.5rem;
                        flex-wrap: wrap;
                        justify-content: center;
                    }

                    .package-card {
                        background: #fff;
                        border-radius: 10px;
                        box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
                        width: 250px;
                        padding: 1rem;
                        transition: transform 0.3s;
                    }

                    .package-card:hover {
                        transform: translateY(-5px);
                    }

                    .package-card img {
                        width: 100%;
                        border-radius: 10px;
                    }

                    .package-card .btn {
                        margin-top: 0.5rem;
                        padding: 0.5rem 1rem;
                        border: none;
                        background: #0077ff;
                        color: white;
                        cursor: pointer;
                        border-radius: 5px;
                        text-decoration: none;
                    }

                    .package-card .btn.disabled {
                        background: gray;
                        cursor: not-allowed;
                    }
                </style>
            </div>


            <!-- 🔹 Third Container -->
            <div class="home-main section" style="background: url('./assets/images/bg3.jpg') center/cover no-repeat;">
                <div class="overlay"></div>
                <div class="title-container">
                    <div class="globeGateways magnet">
                        <p class="text-animate">exclusive deals for your dream destination.</p>
                        <h1 class="magnet" style="display:inline;">Holiday</h1>
                        <h1 class="magnet" style="display:inline;">Specials</h1>
                        <p class="tagline">Get 50% OFF on early bookings 🎉</p>
                    </div>
                </div>
            </div>
            <div class="package-main">
                <a href="page/signup.php"><button class="exploreBtn hvr">Check Offers</button></a>
            </div>
            <div class="subfooter">
                <?php include '../components/subfooter.php'; ?>
            </div>
        <?php endif; ?>
    </main>
    <footer>
        <?php include '../components/footer.php'; ?>
    </footer>
</body>
<!-- Three.js is needed for 3d Effects -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>

<!--  Gsap is needed for Basic Effects -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<!-- Scroll Trigger is needed for Scroll Effects -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>


<!-- ControlKit is needed for Debug Panel -->
<script src="https://cdn.jsdelivr.net/gh/automat/controlkit.js@master/bin/controlKit.min.js"></script>
<script type="text/javascript" src="https://unpkg.com/sheryjs/dist/Shery.js"></script>
<script src="../assets//js/index.js"></script>

</html>