<?php
    include '../../database/config.php';
  
    $sql = "SELECT * FROM bookings";
    $result = mysqli_query($conn, $sql);
  
    $bookings = array();
  
    while ($row = mysqli_fetch_assoc($result)) {
  
        $bookings[] = $row;
  
    }
  
    echo json_encode($bookings);
?>