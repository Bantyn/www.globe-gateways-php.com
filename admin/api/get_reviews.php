<?php
include '../../database/config.php';

header('Content-Type: application/json');

$result = mysqli_query($conn, "SELECT * FROM reviews");
$reviews = [];

while ($row = mysqli_fetch_assoc($result)) {
    $reviews[] = $row;
}

echo json_encode($reviews);
mysqli_close($conn);