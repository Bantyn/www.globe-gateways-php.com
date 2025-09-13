
     <div class="dashboard-container">
        <div class="dashboard-header">

            <?php
                echo "<h1>User's Reviews</h1>";
                echo '<div>Wellcome ' . $_COOKIE['admin'] . '</div>';
            ?>

        </div>

        <div class="table-container">
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>Review ID</th>
                        <th>User ID</th>
                        <th>Package ID</th>
                        <th>Rating</th>
                        <th>Comment</th>
                        <th>Created At</th>
                        <th>Actions</th>
                        <style>
                            
.btn-edit-reviews{
    background-color: royalblue;
    border: none;
    border-radius: 0.3rem;
    padding: 0.5rem 0.8rem;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
}
.btn-edit-reviews:hover{
    background-color: darkblue;
}
.btn-edit-reviews i{
    color: white;
}
.btn-delete-reviews i{
    color: white;
}
.btn-delete-reviews{
    background-color: crimson;
    border: none;
    color:white;
    border-radius: 0.3rem;
    padding: 0.5rem 0.8rem;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
}
.btn-delete-reviews:hover{
    background-color: darkred;
}
                        </style>
                    </tr>
                </thead>
                <tbody id="reviewsBody">
                    <script>
                        axios.get("../api/get_reviews.php").then(response => {
                            const reviews = response.data;
                            reviews.forEach(review => {

                            const row = document.createElement("tr");
                            row.innerHTML = `
                                <td>${review.review_id}</td>
                                <td>${review.user_id}</td>
                                <td>${review.package_id}</td>
                                <td>${review.rating}</td>
                                <td>${review.comment}</td>
                                <td>${review.created_at}</td>
                                <td>
                                    <button class="edit-button" data-id="${review.review_id}"><i class="bi bi-pencil"></i>Edit</button>
                                    <button class="delete-button" data-id="${review.review_id}"><i class="bi bi-trash"></i>Delete   </button>
                                </td>
                            `;
                            document.getElementById("reviewsBody").appendChild(row);
                        });
                    }).catch(error => {
                            console.error("Error fetching reviews:", error);
                            loader.innerHTML = `<p class="text-danger">❌ Failed to load reviews.</p>`;
                     }).finally(() => {
                         document.getElementById("lineLoaderContainer").style.display = "none"; // Hide loader
                     });

                </script>
            </tbody>

            </table>
        </div>
    </div>