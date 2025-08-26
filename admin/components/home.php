 <div class="dashboard-container">
        <div class="dashboard-header">

            <?php
                // session_start();
                echo "<h1>Admin Panel</h1>";
                echo '<div>Wellcome ' . $_COOKIE['admin'] . '</div>';
            ?>
        </div>
        <div class="table-container">
           <h1>Dashboard Overview</h1>
           <div id="dashboardCards" class="dashboard-cards">
               <div class="card">
                   <h2>Total Users</h2>
                   <p id="totalUsers">0</p>
               </div>
               <div class="card">
                   <h2>Total Packages</h2>
                   <p id="totalPackages">0</p>
               </div>
               <div class="card">
                   <h2>Total Reviews</h2>
                   <p id="totalReviews">0</p>
               </div>
           </div>
        </div>
    </div>