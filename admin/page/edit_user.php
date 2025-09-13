<?php
    include "../../database/config.php";
    $select = "SELECT * FROM users WHERE user_id = {$_GET['user_id']}";
    $result = mysqli_query($conn, $select);
    $user = mysqli_fetch_assoc($result);
?>

<?php
    if(isset($_POST['submit'])) {
        $user_id = $_POST['user_id'];
        $full_name = $_POST['full_name'];
        $username = $_POST['username'];
        $email = $_POST['email'];
        $password = $_POST['password'];
        $user_type = $_POST['user_type'];
        $update_date = date('Y-m-d H:i:s');
        $update = "UPDATE users SET full_name='$full_name', username='$username', email='$email', password='$password', user_type='$user_type', updated_at='$update_date' WHERE user_id='$user_id'";
        if(mysqli_query($conn, $update)) {
            echo "User updated successfully.";
            header("Location: ../page/dashboard.php?user=user");
            exit();
        } else {
            echo "Error updating user: " . mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit User</title>
    <link rel="stylesheet" href="../assets/css/dashboard.style.css">
</head>
<body>
        <style>
    body {
        font-family: Arial, Helvetica, sans-serif;
        background: #f4f6f9;
        margin: 0;
        padding: 0;
        display: flex;
        justify-content: center;
        align-items: center;
        min-height: 100vh;
    }

    form {
        background: #fff;
        padding: 2rem;
        border-radius: 12px;
        box-shadow: 0px 4px 15px rgba(0, 0, 0, 0.1);
        width: 100%;
        max-width: 450px;
    }

    form h2 {
        margin-bottom: 1.5rem;
        text-align: center;
        font-size: 1.5rem;
        color: #333;
    }

    label {
        display: block;
        margin-bottom: 0.5rem;
        font-weight: bold;
        color: #444;
    }

    input, select {
        width: 100%;
        padding: 0.7rem;
        margin-bottom: 1.2rem;
        border: 1px solid #ddd;
        border-radius: 8px;
        font-size: 1rem;
        transition: all 0.3s ease-in-out;
    }

    input:focus, select:focus {
        border-color: #007bff;
        outline: none;
        box-shadow: 0px 0px 6px rgba(0, 123, 255, 0.4);
    }

    button {
        width: 100%;
        padding: 0.8rem;
        background: #007bff;
        color: #fff;
        font-size: 1rem;
        font-weight: bold;
        border: none;
        border-radius: 8px;
        cursor: pointer;
        transition: background 0.3s ease;
    }

    button:hover {
        background: #0056b3;
    }

    /* Responsive */
    @media (max-width: 500px) {
        form {
            padding: 1.5rem;
        }
    }
</style>
    <form method="POST" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?php echo $user['user_id']; ?>">
        <label for="full_name">Full Name:</label>
        <input type="text" id="full_name" name="full_name" value="<?php echo $user['full_name']; ?>" required>
        <label for="username">Username:</label>
        <input type="text" id="username" name="username" value="<?php echo $user['username']; ?>" required>
        <label for="email">Email:</label>
        <input type="email" id="email" name="email" value="<?php echo $user['email']; ?>" required>
        <label for="password">Password:</label>
        <input type="password" id="password" name="password" value="<?php echo $user['password']; ?>" required>
        <label for="user_type">User Type:</label>
        <select id="user_type" name="user_type" required>
            <option value="admin" <?php echo $user['user_type'] == 'admin' ? 'selected' : ''; ?>>Admin</option>
            <option value="user" <?php echo $user['user_type'] == 'user' ? 'selected' : ''; ?>>User</option>
        </select>
        <button name="submit" type="submit">Update User</button>
    </form>
</body>
</html>