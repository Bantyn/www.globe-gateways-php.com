<?php

// Logout handling
if (isset($_GET['logout'])) {
    setcookie("username", "", time() - 3600, "/");
    setcookie("admin", "", time() - 3600, "/");
    session_destroy();
    header("Location: index.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GG | Globe Gateways | Login</title>
    <link rel="stylesheet" href="../assets/css/main.style.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.9.1/gsap.min.js"></script>
</head>

<body>
    <div class="navbar-container">
        <!-- Left side menu -->
        <ul class="nav-menu">
            <li><a href="home.php"><img class="brand-logo" src="../assets/logo/gg--logo-black.png" alt=""></a></li>
            <?php if (isset($_SESSION['username'])): ?>
                <!-- User is logged in -->
                <div class="left">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="packages.php">Packages</a></li>
                    <li><a href="about.php">About Us</a></li>
                    <li><a href="contact.php">Contact</a></li>
                    <li><a href="profile.php">Profile</a></li>
                </div>
                <div class="right">
                    <li><a href="?logout=true"><button>Logout</button></a></li>
                    <li><span>Welcome <?= htmlspecialchars($_SESSION['username']); ?></span></li>
                </div>
            <?php else: ?>
                <!-- User is NOT logged in -->
                <li><a href="page/login.php">Login</a></li>
                <li><a href="page/signup.php">Sign Up</a></li>
            <?php endif; ?>
        </ul>
    </div>
</body>

</html>