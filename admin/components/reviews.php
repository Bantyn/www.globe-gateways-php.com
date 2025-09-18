<div class="dashboard-container">
    <div class="dashboard-header">
        <?php
        echo "<h1>User's Reviews</h1>";
        echo '<div>Welcome ' . $_COOKIE['admin'] . '</div>';
        ?>
    </div>

    <!-- 🔍 Search Bar -->
    <div class="search-filter-container">
        <input type="text" id="searchInput" placeholder="Search reviews..." />
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
                </tr>
            </thead>
            <tbody id="reviewsBody"></tbody>
        </table>
    </div>
<style>
    .search-filter-container {
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 0.5rem;
        margin-bottom: 1rem;
    }

    #searchInput {
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
    <style>
        .search-filter-container {
            margin: 1rem 0;
            display: flex;
            justify-content: flex-end;
        }

        #searchInput {
            padding: 0.5rem;
            font-size: 1rem;
            width: 250px;
            border-radius: 0.3rem;
            border: 1px solid #ccc;
        }

        .btn-delete-reviews {
            background-color: crimson;
            border: none;
            color: white;
            border-radius: 0.3rem;
            padding: 0.5rem 0.8rem;
            cursor: pointer;
            font-size: 1rem;
            transition: background-color 0.3s;
        }

        .btn-delete-reviews:hover {
            background-color: darkred;
        }

        .btn-delete-reviews i {
            color: white;
        }
    </style>
    

    <script>
        const reviewsBody = document.getElementById("reviewsBody");
        const searchInput = document.getElementById("searchInput");
        let reviewsData = [];

        // Load reviews
        axios.get("../api/get_reviews.php")
            .then(response => {
                reviewsData = response.data;
                renderReviews(reviewsData);
            })
            .catch(error => {
                             console.error("Error fetching packages:", error);
                             loader.innerHTML = `<p class="text-danger">❌ Failed to load packages.</p>`;
                         }).finally(() => {
                             document.getElementById("lineLoaderContainer").style.display = "none"; // Hide loader
                         });

        // Render reviews
        function renderReviews(reviews) {
            reviewsBody.innerHTML = "";
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
                        <button class="btn-delete-reviews" data-id="${review.review_id}">
                            <i class="bi bi-trash"></i> Delete
                        </button>
                    </td>
                `;
                reviewsBody.appendChild(row);

                // Delete handler
                row.querySelector(".btn-delete-reviews").addEventListener("click", function () {
                    const reviewId = this.getAttribute("data-id");
                    if (confirm("Are you sure you want to delete this review?")) {
                        axios.post("../api/delete_review.php", { review_id: reviewId })
                            .then(res => {
                                if (res.data.success) {
                                    row.remove();
                                    alert("✅ Review deleted successfully!");
                                } else {
                                    alert("❌ Failed to delete review.");
                                }
                            })
                            .catch(err => {
                                console.error(err);
                                alert("⚠️ Error deleting review.");
                            });
                    }
                });
            });
        }

        // 🔍 Search filter
        searchInput.addEventListener("input", function () {
            const searchTerm = this.value.toLowerCase();
            const filtered = reviewsData.filter(review =>
                review.review_id.toString().includes(searchTerm) ||
                review.user_id.toString().includes(searchTerm) ||
                review.package_id.toString().includes(searchTerm) ||
                review.rating.toString().includes(searchTerm) ||
                review.comment.toLowerCase().includes(searchTerm)
            );
            renderReviews(filtered);
        });
    </script>
</div>
