<?php
include '../../database/config.php';

header('Content-Type: application/json');

$result = mysqli_query($conn, "SELECT * FROM packages");
$packages = [];

while ($row = mysqli_fetch_assoc($result)) {
    $packages[] = $row;
}

echo json_encode($packages);
mysqli_close($conn);