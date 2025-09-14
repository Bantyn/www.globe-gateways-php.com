<?php
session_start();
include '../../database/config.php';
$userId = $_SESSION['username'];
$email = $_POST['email'];
$time = date("Y-m-d H:i:s");
$profileImg = "";
if (!empty($_FILES['profileImage']['name'])) {
    $targetDir = "../../uploads/user/";
    $profileImg = date("Y-m-d H:i:s") . "_" . basename($_FILES["profileImage"]["name"]);
    $targetFile = $targetDir . $profileImg;
    if (move_uploaded_file($_FILES["profileImage"]["tmp_name"], $targetFile)) {
        $sql = "UPDATE users SET profile_img='$profileImg', updated_at='$time' WHERE username='$userId'";
        $conn->query($sql);
    }
}
$sql = "UPDATE users SET email='$email', updated_at='$time' WHERE username='$userId'";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Profile Updated Successfully!'); window.location='../../client/index.php?profile=profile';</script>";
} else {
    echo "Error: " . $conn->error;
}
?>
