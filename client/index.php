<?php
session_start();
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
        <?php include '../components/navbar.php';?>
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
            }elseif (isset($_GET['booking'])) {
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

            <!-- 🔹 Second Container -->
            <div class="home-main section" style="background: url('./assets/images/bg2.jpg') center/cover no-repeat;">
                <div class="overlay"></div>
                <div class="title-container">
                    <div class="globeGateways magnet">
                        <p class="text-animate">discover amazing international tours.</p>
                        <h1 class="magnet" style="display:inline;">Travel</h1>
                        <h1 class="magnet" style="display:inline;">World</h1>
                        <p class="tagline">From Europe to Asia, explore breathtaking locations ✈️</p>
                    </div>
                </div>
            </div>
            <div class="package-main">
                <a href="page/signup.php"><button class="exploreBtn hvr">View Tours</button></a>
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
                <?php include '../components/subfooter.php';?>
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