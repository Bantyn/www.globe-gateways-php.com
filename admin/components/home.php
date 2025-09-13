<!-- This is for Chart.js -->
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="dashboard-container">
    <div class="dashboard-header">
        <?php
            echo "<h1>Admin Panel</h1>";
            echo '<div>Welcome ' . htmlspecialchars($_COOKIE['admin']) . '</div>';
        ?>
    </div>

    <div class="table-container" style="padding:5vmin">
        <h1>Dashboard Overview</h1>

        <div id="dashboardCards" class="dashboard-cards" style="display:flex; gap:20px; margin-bottom:30px;">
            <div class="card" style="flex:1; background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
                <h2>Total Users</h2>
                <p id="totalUsers" style="font-size:24px; font-weight:bold;"></p>
            </div>
            <div class="card" style="flex:1; background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
                <h2>Total Packages</h2>
                <p id="totalPackages" style="font-size:24px; font-weight:bold;">0</p>
            </div>
            <div class="card" style="flex:1; background:#f8f9fa; padding:20px; border-radius:8px; text-align:center;">
                <h2>Total Reviews</h2>
                <p id="totalReviews" style="font-size:24px; font-weight:bold;">0</p>
            </div>
        </div>

        <div style="display:flex; gap:3vmin; flex-wrap:wrap;">
            <div style="width:45%;">
                <h3>User Growth (Monthly)</h3>
                <canvas id="userChart"></canvas>
            </div>
            <div style="width:20%; display:block; margin:auto;">
                <h3>Packages Sold by Category</h3>
                <canvas id="packageChart"></canvas>
            </div>
        </div>
    </div>
</div>

<script>
    document.getElementById("lineLoaderContainer").style.display = "none";
    const totalUsers = <?php
        include("../../database/config.php");
        $userCountQuery = "SELECT COUNT(*) AS count FROM users";
        $userCountResult = mysqli_query($conn, $userCountQuery);
        $userCountRow = mysqli_fetch_assoc($userCountResult);
        echo $userCountRow['count'];
    ?>;
    const totalPackages = <?php
        $packageCountQuery = "SELECT COUNT(*) AS count FROM packages";
        $packageCountResult = mysqli_query($conn, $packageCountQuery);
        $packageCountRow = mysqli_fetch_assoc($packageCountResult);
        echo $packageCountRow['count'];
    ?>;
    const totalReviews = <?php
        $reviewCountQuery = "SELECT COUNT(*) AS count FROM reviews";
        $reviewCountResult = mysqli_query($conn, $reviewCountQuery);
        $reviewCountRow = mysqli_fetch_assoc($reviewCountResult);
        echo $reviewCountRow['count'];
    ?>;

    document.getElementById('totalUsers').textContent = totalUsers;
    document.getElementById('totalPackages').textContent = totalPackages;
    document.getElementById('totalReviews').textContent = totalReviews;

    // User Growth Chart (Line)
    const ctx1 = document.getElementById('userChart').getContext('2d');
    new Chart(ctx1, {
        type: 'line',
        data: {
            labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{
                label: 'Users',
                data: <?php
                    $userGrowthQuery = "SELECT COUNT(*) as count, MONTH(created_at) as month FROM users GROUP BY month";
                    $userGrowthResult = mysqli_query($conn, $userGrowthQuery);
                    $userGrowthData = [];

                    while ($row = mysqli_fetch_assoc($userGrowthResult)) {
                        $userGrowthData[$row['month']] = $row['count'];
                    }
                    
                    echo json_encode(array_values($userGrowthData));
                ?>,
                borderColor: '#007bff',
                backgroundColor: 'rgba(0, 123, 255, 0.2)',
                fill: true,
                tension: 0.3
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { display: true } }
        }
    });

    const ctx2 = document.getElementById('packageChart').getContext('2d');
    new Chart(ctx2, {
        type: 'pie',
        data: {
            labels: ['Other', 'Premium', 'Luxury', 'Standard'],
            datasets: [{
                data: <?php
                    $packageCategoryQuery = "SELECT COUNT(*) as count, package_type FROM packages GROUP BY package_type";
                    $packageCategoryResult = mysqli_query($conn, $packageCategoryQuery);
                    $packageCategoryData = [];
                    while ($row = mysqli_fetch_assoc($packageCategoryResult)) {
                        $packageCategoryData[$row['package_type']] = $row['count'];
                    }
                    echo json_encode(array_values($packageCategoryData));
                ?>,
                backgroundColor: ['#28a745', '#ffc107', '#17a2b8', '#dc3545']
            }]
        },
        options: {
            responsive: true,
            plugins: { legend: { position: 'bottom' } }
        }
        
    });
   
</script>
