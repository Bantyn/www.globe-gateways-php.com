<?php
include '../../database/config.php';
session_start();
if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all required fields');</script>";
    } else {
        $userquery = "SELECT * FROM users WHERE (username='$username' OR email='$username') AND password='$password'";
        $adminquery = "SELECT * FROM admin WHERE (username='$username' OR email='$username') AND password='$password'";
        $userresult = mysqli_query($conn, $userquery);
        $adminresult = mysqli_query($conn, $adminquery);
        // $row = mysqli_fetch_assoc($userresult);

        
        
        if (mysqli_num_rows($userresult) > 0) {
            $_SESSION['username'] = $username;
                header("Location: ../index.php");
            exit();
        } elseif(mysqli_num_rows($adminresult) > 0){
            $_SESSION['admin'] = $username;
            header("Location: ../../admin/page/dashboard.php?home=home&adminname=" . urlencode($username));
            exit();
        }
        else {
            unset($_SESSION['admin']);
            unset($_SESSION['username']);
            echo "<script>alert('Invalid username or password');</script>";
        }
    }
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Login - Globe Gateways</title>
<link rel="stylesheet" href="../../assets/css/login.style.css">
</head>
<body>

<div class="login-container">
    <!-- Logo -->
    <h1 class="brand-logo">Globe Gateways</h1>

    <h1 class="login-title">Login</h1>
   <form action="login.php" method="post" class="login-form">
    
    <label for="username" class="form-label">Username or Email</label>
    <input type="text" id="username" name="username" 
           class="form-input username-input" 
           placeholder="Enter your username or email" required>
    
    <label for="password" class="form-label">Password</label>
    <input type="password" id="password" name="password" 
           class="form-input password-input" 
           placeholder="Enter your password" required>

    <div class="checkbox-group">
        <a href="forgot-password.php" class="forgot-link">Forgot Password?</a>
    </div>
    
    <input name="submit" type="submit" value="Login" class="btn btn-submit">
</form>
    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</div>

</body>
</html>
