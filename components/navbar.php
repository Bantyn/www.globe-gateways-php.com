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
            session_start();
            // $_SESSION['signup']="signup";
            if (isset($_SESSION['signup']) && $_SESSION['signup']=="signup") {
                echo ' <li><a href="home.php"><img class="brand-logo" src="../assets/logo/gg--logo-black.png" alt=""></a></li>';
                echo '<li><a href="profile.php">Profile</a></li>';
                echo '<li><a name="logout" href="logout.php">Logout</a></li>';
                unset($_SESSION['signup']); 
            } else {
                echo ' <li><a href="home.php"><img class="brand-logo" src="../assets/logo/gg--logo-black.png" alt=""></a></li>';
                echo '<li><a href="page/login.php">Login</a></li>';
                echo '<li><a href="signup.php">Sign Up</a></li>';
            }
            ?>
           
        </ul>
    </div>
</body>
</html>