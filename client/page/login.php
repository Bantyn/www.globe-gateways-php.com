<?php
include '../../database/config.php';

if (isset($_POST['submit'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        echo "<script>alert('Please fill in all required fields');</script>";
    } else {
        $query = "SELECT * FROM users WHERE (username='$username' OR email='$username') AND password='$password'";
        $result = mysqli_query($conn, $query);

        if (mysqli_num_rows($result) > 0) {
            header("Location: ../index.php");
            exit();
        } else {
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

    <!-- Error Message -->
    <div class="error-message">Invalid username or password</div>

   <form action="login.php" method="post" class="login-form">
    
    <!-- Username -->
    <label for="username" class="form-label">Username or Email</label>
    <input type="text" id="username" name="username" 
           class="form-input username-input" 
           placeholder="Enter your username or email" required>
    
    <!-- Password -->
    <label for="password" class="form-label">Password</label>
    <input type="password" id="password" name="password" 
           class="form-input password-input" 
           placeholder="Enter your password" required>

    <!-- Checkbox + Forgot Password -->
    <div class="checkbox-group">
        <a href="forgot-password.php" class="forgot-link">Forgot Password?</a>
    </div>
    
    <!-- Submit -->
    <input name="submit" type="submit" value="Login" class="btn btn-submit">
</form>



    <p>Don't have an account? <a href="signup.php">Sign up</a></p>
</div>

</body>
</html>
