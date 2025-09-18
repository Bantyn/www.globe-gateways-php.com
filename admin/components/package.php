<div class="dashboard-container">
    <div class="dashboard-header">
        <?php
            echo "<h1>User Packages</h1>";
            echo '<div>Welcome ' . $_COOKIE['admin'] . '</div>';
        ?>
    </div>

    <div class="packagebuttoncontainer">
        <a href="../page/createPackage.php">
            <button class="btn btn-add-package"><i class="bi bi-plus"></i> Create Package</button>
        </a>
    </div>

    <!-- 🔍 Search Bar -->
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="🔍 Search packages by title, location, type...">
    </div>
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

    <div class="table-container">
        <table id="packageTable">
            <thead>
                <tr>
                    <th>Package ID</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Location</th>
                    <th>Price</th>
                    <th>Duration</th>
                    <th>Package Type</th>
                    <th>Main Image</th>
                    <th>Sub Images</th>
                    <th>Video URL</th>
                    <th>Created At</th>
                    <th>Updated At</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody id="packageBody"></tbody>
        </table>
    </div>
</div>

<style>
.search-container {
    margin: 1rem 0;
    text-align: right;
}
.search-container input {
    padding: 0.5rem 1rem;
    border-radius: 0.3rem;
    border: 1px solid #ccc;
    font-size: 1rem;
    width: 280px;
}
.sub-images img {
    width: 50px;
    height: 50px;
    object-fit: cover;
    margin: 2px;
    border-radius: 4px;
    border: 1px solid #ddd;
}
</style>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const packageBody = document.getElementById("packageBody");
    const searchInput = document.getElementById("searchInput");
    let allPackages = [];

    // Load packages from API
    function loadPackages() {
        packageBody.innerHTML = '<tr><td colspan="13">Loading...</td></tr>';
        axios.get("../api/get_package.php")
            .then(response => {
                allPackages = Array.isArray(response.data) ? response.data : [];
                renderPackages(allPackages);
            })
           .catch(error => {
                             console.error("Error fetching packages:", error);
                             loader.innerHTML = `<p class="text-danger">❌ Failed to load packages.</p>`;
                         }).finally(() => {
                             document.getElementById("lineLoaderContainer").style.display = "none"; // Hide loader
                         });
    }

    // Render packages
    function renderPackages(packages) {
        packageBody.innerHTML = '';
        packages.forEach(pkg => {
            const row = document.createElement("tr");

            // Handle sub images (comma separated string to multiple <img>)
            let subImagesHtml = "";
            if (pkg.sub_images) {
                const subImages = pkg.sub_images.split(",");
                subImagesHtml = subImages.map(img =>
                    `<img src="../../uploads/${img.trim()}" alt="sub" />`
                ).join("");
            }

            row.innerHTML = `
                <td>${pkg.package_id}</td>
                <td><b>${pkg.title}</b></td>
                <td>${pkg.description}</td>
                <td>${pkg.location}</td>
                <td class="price"><b><i class="bi bi-currency-rupee"></i>${pkg.price} /-</b></td>
                <td><b>${pkg.duration}</b></td>
                <td>${pkg.package_type}</td>
                <td><img src="../../uploads/${pkg.main_image}" alt="${pkg.title}" width="100" /></td>
                <td class="sub-images">${subImagesHtml}</td>
                <td><a href="${pkg.video_url}" target="_blank">Watch</a></td>
                <td>${pkg.created_at}</td>
                <td>${pkg.updated_at}</td>
                <td>
                    <a href="../page/editPackage.php?id=${pkg.package_id}">
                        <button class="edit-button"><i class="bi bi-pencil"></i>Edit</button>
                    </a>
                    <a href="../api/deletePackage.php?id=${pkg.package_id}">
                        <button class="delete-button"><i class="bi bi-trash"></i>Delete</button>
                    </a>
                </td>
            `;
            packageBody.appendChild(row);
        });
    }

    // Live search
    searchInput.addEventListener("input", () => {
        const term = searchInput.value.toLowerCase();
        const filtered = allPackages.filter(pkg =>
            pkg.title.toLowerCase().includes(term) ||
            pkg.location.toLowerCase().includes(term) ||
            pkg.package_type.toLowerCase().includes(term)
        );
        renderPackages(filtered);
    });

    // Initial load
    loadPackages();
});
</script>
