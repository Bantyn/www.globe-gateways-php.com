<?php
include '../../database/config.php';
if(isset($_POST['submit'])){
       $name = $_POST['fullname'];
       $username = $_POST['username'];
       $email = $_POST['email'];
       $password = $_POST['password'];
       $confirm_password = $_POST['confirm_password'];

       if(empty($name) || empty($username) || empty($email) || empty($password) || empty($confirm_password)){

           echo "<script>alert('Please fill in all required fields');</script>";
       } elseif ($password !== $confirm_password) {
           echo "<script>alert('Passwords do not match');</script>";
       
       } else {
           $query = "INSERT INTO users (full_name, username, email, password) VALUES ('$name', '$username', '$email', '$password')";
           $result = mysqli_query($conn, $query);
              if($result){
               echo "<script>alert('Registration successful!')</script>";
               header("Location: login.php");
               exit();
              } else {
                      $error = mysqli_error($conn);
                     echo "<script>alert($error)</script>";
              }
       }
       header("Location: login.php");
       exit();       
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Sign Up - Globe Gateways</title>
<link rel="stylesheet" href="../../assets/css/login.style.css">
</head>
<body>

<div class="login-container">
    <!-- Logo -->
    <h1 class="brand-logo">Globe Gateways</h1>

    <h1 class="login-title">Sign Up</h1>

    <!-- Error Message -->
    <div class="error-message">Please fill in all required fields</div>

    <form method="POST" class="login-form">

        <!-- Full Name -->
        <label for="fullname" class="form-label">Full Name</label>
        <input type="text" id="fullname" name="fullname" 
               class="form-input fullname-input" 
               placeholder="Enter your full name" required>

        <!-- Username -->
        <label for="username" class="form-label">Username</label>
        <input type="text" id="username" name="username" 
               class="form-input username-input" 
               placeholder="Choose a username" required>
        
        <!-- Email -->
        <label for="email" class="form-label">Email</label>
        <input type="email" id="email" name="email" 
               class="form-input email-input" 
               placeholder="Enter your email" required>
        
        <!-- Password -->
        <label for="password" class="form-label">Password</label>
        <input type="password" id="password" name="password" 
               class="form-input password-input" 
               placeholder="Enter your password" required>

        <!-- Confirm Password -->
        <label for="confirm-password" class="form-label">Confirm Password</label>
        <input type="password" id="confirm-password" name="confirm_password" 
               class="form-input confirm-password-input" 
               placeholder="Re-enter your password" required>

        <!-- Submit -->
        <input name="submit" type="submit" value="Sign Up" class="btn btn-submit">
    </form>

    <p>Already have an account? <a href="login.php">Login</a></p>
</div>

</body>
</html>
