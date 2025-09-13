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
                    <div class="globeGateways">
                        <p>your one-stop solution for all your gateway needs.</p>
                        <h1 style="display: inline;">Globe</h1>
                        <h1 style="display: inline;">Gateways</h1>
                    </div>
                </div>
            </div>
            <div class="package-main">


                <?php
                include '../database/config.php'; 

                $result = $conn->query("SELECT * FROM packages");

                if ($result->num_rows > 0): ?>
                    <div id="fimages">
                        <div id="fleft">
                            <?php while ($row = $result->fetch_assoc()): ?>
                                <div class="fleftelm">
                                    <h3><?php echo $row['title']; ?></h3>
                                    <h1><?php echo $row['description']; ?></h1>
                                    <h4><?php echo $row['price']; ?></h4>
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
                    <div class="globeGateways">
                        <p>your one-stop solution for all your gateway needs.</p>
                        <h1 style="display: inline;">Globe</h1>
                        <h1 style="display: inline;">Gateways</h1>
                    </div>
                </div>
            </div>
            <div class="package-main">
                <a href="page/signup.php"><button class="exploreBtn">Explore Packages</button></a>
            </div>

        <?php endif; ?>
    </main>
</body>

</html>