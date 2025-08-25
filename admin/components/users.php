
    <!-- Dashboard Table -->
    <div class="dashboard-container">
        <div class="dashboard-header">

            <?php
                // session_start();
                echo "<h1> User Managment</h1>";
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

    <!-- Axios fetch -->
    <script>
        axios.get('../api/get_users.php')
            .then(response => {
                const users = response.data;
                const tbody = document.getElementById("usersBody");
                users.forEach(user => {
                    const row = `
                        <tr>
                            <td>${user.user_id}</td>
                            <td>${user.full_name}</td>
                            <td>${user.username}</td>
                            <td>${user.email}</td>
                            <td>${user.password}</td>
                            <td>${user.user_type}</td>
                            <td>${user.created_at}</td>
                            <td>${user.updated_at}</td>
                            <td>
                                <button class="edit-button" onclick="editUser(${user.user_id})"><i class="bi bi-pencil"></i>Edit</button>
                                <button class="delete-button" onclick="deleteUser(${user.user_id})"><i class="bi bi-trash"></i>Delete</button>
                            </td>
                        </tr>
                    `;
                    tbody.innerHTML += row;
                });
            })
            .catch(err => console.error(err))
            .finally(() => {
                         document.getElementById("lineLoaderContainer").style.display = "none"; // Hide loader
                     });
    </script>


