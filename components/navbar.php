<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>GG | Globe Gateways | Login</title>
    <link rel="stylesheet" href="../assets/css/main.style.css">
</head>
<body>
    <div class="navbar-container">
        <ul class="nav-left">
            <?php

            if (isset($_SESSION['username']) && $_COOKIE['username'] == "signup") {
                echo ' <li><a href="home.php"><img class="brand-logo" src="../assets/logo/gg--logo-black.png" alt=""></a></li>';
                echo '<li><a href="page/login.php">Login</a></li>';
                echo '<li><a href="page/signup.php">Sign Up</a></li>';
            } else {
                if(isset($_REQUEST['logout'])) {
                    setcookie("username", "", time() - 10, "/");
                    header("Location: page/login.php");
                    exit();
                }
                echo ' <li><a href="home.php"><img class="brand-logo" src="../assets/logo/gg--logo-black.png" alt=""></a></li>';
                echo '<li><a href="profile.php">Profile</a></li>';
                echo '<li><a name="logout" href="?logout=true">Logout</a></li>';
                echo '<li><a href="profile.php">Wellcome ' . $_COOKIE['username'] . '</a></li>';
            }
            ?>
           
        </ul>
        
    </div>
</body>
</html>