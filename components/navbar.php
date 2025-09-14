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
            <!-- <li><a href="home.php"><img class="brand-logo" src="../assets/logo/gg--logo-black.png" alt=""></a></li> -->
            <?php if (isset($_SESSION['username'])): ?>
                <!-- User is logged in -->
                <div class="left magnet">
                    <style>
                        .left {
                            display: flex;
                            align-items: center;
                            gap: 1rem;
                            background: #ffffffff;
                            padding: 0.8rem 1.4rem;
                            border: 1px solid gray;
                            border-radius: 50px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            user-select: none;
                        }
                    </style>
                    <li><a href="index.php?home=home"><i style="font-size: 1.3rem;margin-right: 0.5rem;" class="ri-home-line"></i></a></li>
                    <li><a href="index.php?about=about"><i style="font-size: 1.3rem;margin-right: 0.5rem;" class="ri-information-line"></i></a></li>
                    <li><a href="index.php?contact=contact"><i style="font-size: 1.3rem;margin-right: 0.5rem;" class="ri-message-3-line"></i></a></li>
                    <li><a href="index.php?profile=profile"><i style="font-size: 1.3rem;margin-right: 0.5rem;" class="ri-user-line"></i></a></li>
                </div>
                <div class="right magnet">
                    <li><a href="?logout=true"><button>Logout</button></a></li>
                    <li><span><i style="font-size: 1.3rem;margin-right: 0.5rem;" class="ri-account-circle-line"></i><?= htmlspecialchars($_SESSION['username']); ?></span></li>
                </div>
            <?php else: ?>
                <!-- User is NOT logged in -->
                <div></div>
                <div class="left magnet">
                    <style>
                        .left {
                            display: flex;
                            position: absolute;
                            left: 50%;
                            transform: translateX(-50%);
                            align-items: center;
                            background: #ffffffff;
                            padding: 0.8rem 0;
                            border: 1px solid gray;
                            border-radius: 50px;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
                            user-select: none;
                        }

                        .left a{
                            padding: 0.8rem 1.4rem;
                            transition: 0.3s;

                        }
                        .left a:hover {
                            background: var(--black-color);
                            transition: 0.3s;
                            border-radius: 50px;
                            padding: 0.8rem 1.4rem;
                            box-shadow: 0 0 10px rgba(0, 0, 0, 0.2);
                            color: var(--white-color);

                        }
                    </style>
                    <li><a href="page/login.php">Login</a></li>
                    <li><a href="page/signup.php">Sign Up</a></li>
                </div>
            <?php endif; ?>
        </ul>
    </div>
</body>

</html>