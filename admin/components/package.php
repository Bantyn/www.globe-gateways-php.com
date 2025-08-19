 <div class="dashboard-container">
     <div class="dashboard-header">
         <?php
         session_start();
            echo "<h1>User Packages</h1>";
            echo '<div>Wellcome ' . $_SESSION['username'] . '</div>';
            ?>

     </div>
     <div class="packagebuttoncontainer">
         <a href="../page/createPackage.php"><button class="btn btn-add-package"><i class="bi bi-plus"></i> Create Package</button></a>
     </div>
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
            

             <tbody id="packageBody">
                 <script>
                     axios.get("../api/get_package.php").then(response => {
                         const packages = response.data;
                         const packageBody = document.getElementById("packageBody");
                         packages.forEach(pkg => {
                             const row = document.createElement("tr");
                             row.innerHTML = `
                             <td>${pkg.package_id}</td>
                             <td><b>${pkg.title}</b></td>
                             <td>${pkg.description}</td>
                             <td>${pkg.location}</td>
                             <td class="price"><b><i class="bi bi-currency-rupee"></i>${pkg.price} /-</b></td>
                             <td><b>${pkg.duration}</b></td>
                             <td>${pkg.package_type}</td>
                             <td><img src="../../uploads/${pkg.main_image}" alt="${pkg.title}" width="100%" /></td>
                             <td>${pkg.sub_images}</td>
                             <td><a href="${pkg.video_url}">Watch</a></td>
                             <td>${pkg.created_at}</td>
                             <td>${pkg.updated_at}</td>
                             <td>
                             <a href="../page/editPackage.php?id=${pkg.package_id}"><button class="btn btn-edit-package"><i class="bi bi-pencil"></i></button></a>
                             <a href="../page/deletePackage.php?id=${pkg.package_id}"><button class="btn btn-delete-package"><i class="bi bi-trash"></i></button></a>
                             </td>
                             `;
                             packageBody.appendChild(row);
                            });
                            // document.getElementById("lineLoaderContainer").style.display = "block"; // Show loader
                            loader = document.getElementById("lineLoaderContainer") // Show loader
                        }).catch(error => {
                            console.error("Error fetching packages:", error);
                            loader.innerHTML = `<p class="text-danger">❌ Failed to load packages.</p>`;
                     }).finally(() => {
                         document.getElementById("lineLoaderContainer").style.display = "none"; // Hide loader
                     });
                 </script>

             </tbody>
         </table>
     </div>
 </div>