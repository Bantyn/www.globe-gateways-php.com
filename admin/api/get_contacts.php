<?php

include("../../database/config.php");

$sql = "SELECT * FROM contacts";
$result = mysqli_query($conn, $sql);

$contacts = array();

while ($row = mysqli_fetch_assoc($result)) {
    $contacts[] = $row;
}

header('Content-Type: application/json');
echo json_encode($contacts);
?>