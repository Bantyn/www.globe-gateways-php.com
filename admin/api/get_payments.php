<?php
    include_once '../../database/config.php';

    $sql = "SELECT * FROM payments";
    $result = mysqli_query($conn, $sql);

    $payments = [];

    while ($row = mysqli_fetch_assoc($result)) {
        $payments[] = $row;
    }

    echo json_encode($payments);
?>