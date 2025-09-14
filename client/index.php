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
        <?php include '../components/navbar.php'; ?>
    </header>
    <!-- Main Content -->
    <main>
        <?php if (isset($_SESSION['username'])): ?>
            <!-- After signup -->

            <div class="home-main">
                <div class="title-container">
                    <div class="globeGateways ">
                        <p class="text-animate">your one-stop solution for all your gateway needs.</p>
                        <h1 style="display: inline;" class="hvr ">Globe</h1>
                        <h1 style="display: inline;" class="hvr ">Gateways</h1>
                    </div>
                    <p class="text-animate">It is a one-stop travel platform offering easy access to explore and book exciting tour packages worldwide.</p>
                </div>
            </div>
            <div class="package-main">
                <div class="fheading ">
                    <h1 class="text-animate">exaplore</h1>
                    <h1 class="">Packages</h1>
                </div>

                <?php
                include '../database/config.php';

                $result = $conn->query("SELECT * FROM packages");

                if ($result->num_rows > 0): ?>
                    <div id="fimages">
                        <div id="fleft">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="fleftelm">
                                    <h1><?php echo $row['title']; ?>,</h1>
                                    <h3><?php echo $row['description']; ?></h3>
                                    <h3>At : <?php echo $row['location']; ?></h3>
                                    <h4>₹ <?php echo $row['price']; ?></h4>
                                    <a class="magnet" href="page/booking.php?id=<?php echo $row['package_id']; ?>"><button>View More</button></a>
                                </div>
                            <?php endwhile; ?>
                        </div>
                        <div id="fright">
                            <div class="images">
                                <?php
                                $result->data_seek(0);
                                while ($row = $result->fetch_assoc()): ?>
                                    <img src="../../www.globe-gateways-php.com/uploads/<?php echo $row['main_image']; ?>">
                                <?php endwhile; ?>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <p>No packages found.</p>
                <?php endif; ?>
            </div>
        <?php else: ?>
            <!-- Before signup -->
            <div class="home-main">
                <div class="title-container">
                    <div class="globeGateways magnet">
                        <p class="text-animate">your one-stop solution for all your gateway needs.</p>
                        <h1 style="display: inline;" class="magnet">Globe</h1>
                        <h1 style="display: inline;" class="magnet">Gateways</h1>
                    </div>
                </div>
            </div>
            <div class="package-main">
                <a href="page/signup.php"><button class="exploreBtn">Explore Packages</button></a>
            </div>
        <?php endif; ?>
    </main>
</body>
<!-- Three.js is needed for 3d Effects -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/three.js/r134/three.min.js"></script>

<!--  Gsap is needed for Basic Effects -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/gsap.min.js"></script>

<!-- Scroll Trigger is needed for Scroll Effects -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.2/ScrollTrigger.min.js"></script>


<!-- ControlKit is needed for Debug Panel -->
<script src="https://cdn.jsdelivr.net/gh/automat/controlkit.js@master/bin/controlKit.min.js"></script>
<script  type="text/javascript"  src="https://unpkg.com/sheryjs/dist/Shery.js"></script>
<script src="../assets//js/index.js"></script>
</html>