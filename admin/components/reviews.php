 <div class="dashboard-container">
        <div class="dashboard-header">

            <?php
                // session_start();
                echo "<h1>User Reviews</h1>";
                echo '<div>Wellcome ' . $_COOKIE['admin'] . '</div>';
            ?>

        </div>

        <div class="table-container">
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>User ID</th>
                        <th>Full Name</th>
                        <th>Username</th>
                        <th>Email</th>
                        <th>Password</th>
                        <th>User Type</th>
                        <th>Created At</th>
                        <th>Updated At</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="usersBody"></tbody>
            </table>
        </div>
    </div>