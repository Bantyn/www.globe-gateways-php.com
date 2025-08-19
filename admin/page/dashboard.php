<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Dashboard</title>
    <!-- Axios -->
    <script src="https://cdn.jsdelivr.net/npm/axios/dist/axios.min.js"></script>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="../../assets/css/dashboard.style.css">
    <link rel="stylesheet" href="../../assets/css/admin.style.css">
</head>
<body>

    <!-- Navbar -->
    <?php include("../../admin/components/navbar.php"); ?>
    <!-- Title -->
    <div class="title-container">
        <span>U</span><span>s</span><span>e</span><span>r</span><span>s</span> 
        <span>D</span><span>a</span><span>s</span><span>h</span><span>b</span><span>o</span><span>a</span><span>r</span><span>d</span>
    </div>
    <?php
    if(isset($_REQUEST["user"]) && $_REQUEST["user"] == 'user') {
        include("../components/users.php");
        $title = "Users";
    } elseif(isset($_REQUEST["package"]) && $_REQUEST["package"] == 'package') {
        include("../components/package.php");
        $title = "Packages Management";
        // Package dashboard content
    } elseif(isset($_REQUEST["report"]) && $_REQUEST["report"] == 'report') {
        include("../components/report.php");
        $title = "User Reports";
        // Report dashboard content
    } elseif(isset($_REQUEST["reviews"]) && $_REQUEST["reviews"] == 'reviews') {
        include("../components/reviews.php");
        $title = "User Reviews";
        // Reviews dashboard content
    }
    elseif(isset($_REQUEST["payments"]) && $_REQUEST["payments"] == 'payments') {
        include("../components/payments.php");
        $title = "User Payments";
        // Payments dashboard content
    }
    elseif(isset($_REQUEST["bookings"]) && $_REQUEST["bookings"] == 'bookings') {
        include("../components/bookings.php");
        $title = "User Bookings";
        // Bookings dashboard content
    }
    elseif(isset($_REQUEST["contacts"]) && $_REQUEST["contacts"] == 'contacts') {
        include("../components/contacts.php");
        $title = "User Contacts";
        // Contacts dashboard content
    }
    elseif(isset($_REQUEST["home"]) && $_REQUEST["home"] == 'home') {
        include("../components/home.php");
        $title = "Adminpanle";
        // Home dashboard content
    }
    
    ?>
</body>
</html>
