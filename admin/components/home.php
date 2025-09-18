<?php
include("../../database/config.php");

$userCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];
$packageCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM packages"))['count'];
$reviewCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM reviews"))['count'];
$contactCount = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM contacts"))['count'];

$newUsers = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users WHERE MONTH(created_at)=MONTH(CURDATE())"))['count'];
$newPackages = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM packages WHERE MONTH(created_at)=MONTH(CURDATE())"))['count'];
$pendingReviews = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM reviews"))['count'];
$unreadContacts = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM contacts"))['count'];
$totalPayments = mysqli_fetch_assoc(mysqli_query($conn, "SELECT IFNULL(SUM(amount),0) AS total FROM payments"))['total'];
$userGrowthData = array_fill(1, 12, 0);
$userGrowthResult = mysqli_query($conn, "SELECT COUNT(*) as count, MONTH(created_at) as month FROM users GROUP BY month");
while ($row = mysqli_fetch_assoc($userGrowthResult)) {
    $userGrowthData[(int)$row['month']] = (int)$row['count'];
}
$paymentData = array_fill(1, 12, 0);
$paymentResult = mysqli_query($conn, "SELECT IFNULL(SUM(amount),0) as total, MONTH(payment_date) as month FROM payments GROUP BY month");
while ($row = mysqli_fetch_assoc($paymentResult)) {
    $paymentData[(int)$row['month']] = (float)$row['total'];
}
// Package categories
$packageCategoryData = ['Standard'=>0,'Premium'=>0,'Luxury'=>0,'Other'=>0];
$packageCategoryResult = mysqli_query($conn, "SELECT COUNT(*) as count, package_type FROM packages GROUP BY package_type");
while ($row = mysqli_fetch_assoc($packageCategoryResult)) {
    $type = $row['package_type'];
    if (!isset($packageCategoryData[$type])) $type = 'Other';
    $packageCategoryData[$type] = (int)$row['count'];
}
?>

<div class="dashboard-container">
    <div class="dashboard-header">
        <?php
        echo "<h1>Admin Panel</h1>";
        echo '<div>Welcome ' . htmlspecialchars($_COOKIE['admin']) . '</div>';
        ?>
    </div>

    <div class="table-container" style="padding:5vmin">
        <h1>Dashboard Overview</h1>

        <!-- Overview Cards -->
        <div id="dashboardCards" class="dashboard-cards" style="display:flex; gap:20px; margin-bottom:30px; flex-wrap:wrap;">
            <div class="card" style="flex:1; background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
                <h2>Total Users</h2>
                <p style="font-size:24px; font-weight:bold;"><?php echo $userCount; ?></p>
                <small>New this month: <?php echo $newUsers; ?></small>
            </div>
            <div class="card" style="flex:1; background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
                <h2>Total Packages</h2>
                <p style="font-size:24px; font-weight:bold;"><?php echo $packageCount; ?></p>
                <small>New this month: <?php echo $newPackages; ?></small>
            </div>
            <div class="card" style="flex:1; background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
                <h2>Total Reviews</h2>
                <p style="font-size:24px; font-weight:bold;"><?php echo $reviewCount; ?></p>
                <small>Pending: <?php echo $pendingReviews; ?></small>
            </div>
            <div class="card" style="flex:1; background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
                <h2>Total Contacts</h2>
                <p style="font-size:24px; font-weight:bold;"><?php echo $contactCount; ?></p>
                <small>Unread: <?php echo $unreadContacts; ?></small>
            </div>
            <div class="card" style="flex:1; background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
                <h2>Total Payments</h2>
                <p style="font-size:24px; font-weight:bold;">₹<?php echo number_format($totalPayments,2); ?></p>
            </div>
        </div>

        <!-- Charts -->
        <div style="display:flex; gap:3vmin; flex-wrap:wrap;">
            <div style="width:45%;">
                <h3>User Growth (Monthly)</h3>
                <canvas id="userChart"></canvas>
            </div>
            <div style="width:45%;">
                <h3>Payments Over Time (Monthly)</h3>
                <canvas id="paymentChart"></canvas>
            </div>
            <div style="width:45%; margin-top:20px;">
                <h3>Packages Sold by Category</h3>
                <canvas id="packageBarChart"></canvas>
            </div>
        </div>
    </div>
</div>

<!-- Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // User Growth
    new Chart(document.getElementById('userChart').getContext('2d'), {
        type:'line',
        data:{
            labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets:[{
                label:'Users',
                data: <?php echo json_encode(array_values($userGrowthData)); ?>,
                borderColor:'#007bff',
                backgroundColor:'rgba(0,123,255,0.2)',
                fill:true,
                tension:0.3
            }]
        },
        options:{responsive:true,plugins:{legend:{display:true}}}
    });

    // Payments Over Time
    new Chart(document.getElementById('paymentChart').getContext('2d'), {
        type:'line',
        data:{
            labels:['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets:[{
                label:'Payments (₹)',
                data: <?php echo json_encode(array_values($paymentData)); ?>,
                borderColor:'#28a745',
                backgroundColor:'rgba(40,167,69,0.2)',
                fill:true,
                tension:0.3
            }]
        },
        options:{responsive:true,plugins:{legend:{display:true}}}
    });

    // Packages Sold Bar Chart
    new Chart(document.getElementById('packageBarChart').getContext('2d'), {
        type:'bar',
        data:{
            labels: <?php echo json_encode(array_keys($packageCategoryData)); ?>,
            datasets:[{
                label:'Packages Sold',
                data: <?php echo json_encode(array_values($packageCategoryData)); ?>,
                backgroundColor:['#dc3545','#ffc107','#17a2b8','#28a745']
            }]
        },
        options:{
            responsive:true,
            plugins:{legend:{display:false}},
            scales:{
                y:{beginAtZero:true,title:{display:true,text:'Number of Packages'}},
                x:{title:{display:true,text:'Package Type'}}
            }
        }
    });
</script>
