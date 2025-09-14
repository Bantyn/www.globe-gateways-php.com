<!-- Dashboard Table -->
<div class="dashboard-container">
    <div class="dashboard-header">
        <?php
        echo "<h1>User Management</h1>";
        echo '<div>Welcome ' . $_COOKIE['admin'] . '</div>';
        ?>
    </div>

    <div class="table-container">
        <table id="usersTable">
            <thead>
                <tr>
                    <td colspan="9">
                        <div class="search-container">
                            
                            <input
                                type="text"
                                id="searchInput"
                                placeholder="Search By Username">
                            <button type="button" id="searchBtn"><i class="bi bi-search"></i></button>
                        </div>
                    </td>
                </tr>
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

<?php
// Delete user
include "../../database/config.php";
if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];
    $delete = "DELETE FROM users WHERE user_id = '$user_id'";
    if (mysqli_query($conn, $delete)) {
        echo "<script>alert('User deleted successfully.'); window.location.href = '../page/dashboard.php?user=user';</script>";
        exit();
    } else {
        echo "Error deleting user: " . mysqli_error($conn);
    }
}
?>

<!-- Styles -->
<style>
    .search-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    .search-container input {
        flex: 1;
        padding: 0.5rem;
        border: 1px solid var(--bg2-color);
        border-radius: 0.25rem;
        font-family: var(--popins);
    }

    .search-container button {
        background: var(--bg2-color);
        color: var(--white-color);
        border: none;
        padding: 0.5rem 1rem;
        border-radius: 0.25rem;
        font-family: var(--sub-heading-font);
        cursor: pointer;
        font-size: 1.2rem;
        transition: background 0.3s;
    }

    .search-container button:hover {
        background: #6b6e5e;
    }

    @media(max-width:768px) {
        .search-container {
            flex-direction: column;
            align-items: stretch;
        }

        .search-container button {
            width: 100%;
        }
    }
</style>


<!-- JavaScript -->
<script>
    const searchInput = document.getElementById('searchInput');
    const searchBtn = document.getElementById('searchBtn');
    const tbody = document.getElementById('usersBody');

    // Function to load users from API
    function loadUsers(search = '') {
        tbody.innerHTML = '<tr><td colspan="9">Loading...</td></tr>';
        
        axios.get(`../api/get_users.php?search=${encodeURIComponent(search)}`)
            .then(response => {
                const users = response.data;
                tbody.innerHTML = '';
                if (users.length > 0) {
                    users.forEach(user => {
                        tbody.innerHTML += `
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
                                <a href="../page/edit_user.php?user_id=${user.user_id}">
                                    <button class="edit-button"><i class="bi bi-pencil"></i>Edit</button>
                                </a>
                                <a href="../page/dashboard.php?user=user&user_id=${user.user_id}">
                                    <button class="delete-button"><i class="bi bi-trash"></i>Delete</button>
                                </a>
                            </td>
                        </tr>`;
                    });
                } else {
                    tbody.innerHTML = '<tr><td colspan="9">No users found.</td></tr>';
                }
            })
            .catch(error => {
                console.error("Error fetching packages:", error);
                loader.innerHTML = `<p class="text-danger">❌ Failed to load packages.</p>`;
                tbody.innerHTML = '<tr><td colspan="9">Error loading users.</td></tr>';
            }).finally(() => {
                document.getElementById("lineLoaderContainer").style.display = "none"; // Hide loader
            });
    }

    loadUsers();

    searchBtn.addEventListener('click', () => {
        loadUsers(searchInput.value);
    });

    searchInput.addEventListener('keypress', e => {
        if (e.key === 'Enter') {
            e.preventDefault();
            loadUsers(searchInput.value);
        }
    });
</script>