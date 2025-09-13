
<?php
include '../../database/config.php';

header('Content-Type: application/json');
// Search Using Chat GPT

// Get the search parameter from URL if exists
$search = isset($_GET['search']) ? $_GET['search'] : '';
$search = mysqli_real_escape_string($conn, $search);

// Prepare the query with search
if (!empty($search)) {
    $query = "SELECT * FROM users WHERE username LIKE '%$search%'";
} else {
    $query = "SELECT * FROM users";
}

$result = mysqli_query($conn, $query);

$users = [];
while ($row = mysqli_fetch_assoc($result)) {
    $users[] = $row;
}

echo json_encode($users);

// Close connection
mysqli_close($conn);
