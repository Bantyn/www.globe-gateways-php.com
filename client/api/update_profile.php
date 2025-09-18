<?php
session_start();
include '../../database/config.php';

$userId = $_SESSION['username'];
$email = $_POST['email'];
$time = date("Y-m-d H:i:s");

// Handle profile image
if (!empty($_FILES['profileImage']['name'])) {
    $targetDir = "../../uploads/user/";
    // Remove invalid characters for filename
    $profileImg = date("Ymd_His") . "_" . basename($_FILES["profileImage"]["name"]);
    $targetFile = $targetDir . $profileImg;

    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
        // Update profile image
        $sql = "UPDATE users SET profile_img='$profileImg', updated_at='$time' WHERE username='$userId'";
        if (!$conn->query($sql)) {
            echo "Error updating profile image: " . $conn->error;
            exit;
        }
    } else {
        echo "Failed to upload image.";
        exit;
    }
}

// Update email
$sql = "UPDATE users SET email='$email', updated_at='$time' WHERE username='$userId'";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Profile Updated Successfully!'); window.location='../../client/index.php?profile=profile';</script>";
} else {
    echo "Error updating email: " . $conn->error;
}
?>
