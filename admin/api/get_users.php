<?php
include '../../database/config.php';

header('Content-Type: application/json');

$result = mysqli_query($conn, "SELECT * FROM users");
$users = [];

while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode($users);
mysqli_close($conn);