 <div class="dashboard-container">
        <div class="dashboard-header">

            <?php
                echo "<h1>User Bookings</h1>";
                echo '<div>Wellcome ' . $_COOKIE['admin'] . '</div>';
            ?>

        </div>

        <div class="table-container">
            <table id="usersTable">
                <thead>
                    <tr>
                        <th>booking id</th>
                        <th>user id</th>
                        <th>package id</th>
                        <th>booking date</th>
                        <th>number of people</th>
                        <th>total price</th>
                        <th>status</th>
                        <!-- It is required to show the booking action buttons container -->
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody id="bookingsBody">
                    <script>
                        axios.get("../api/get_bookings.php").then(response=>{
                            const bookings = response.data;
                            const bookingsBody = document.getElementById("bookingsBody");
                            bookings.forEach(booking => {
                                const row = document.createElement("tr");
                                row.innerHTML = `
                                    <td>${booking.booking_id}</td>
                                    <td>${booking.user_id}</td>
                                    <td>${booking.package_id}</td>
                                    <td>${booking.booking_date}</td>
                                    <td>${booking.number_of_people}</td>
                                    <td>${booking.total_price}</td>
                                    <td>${booking.status}</td>
                                    <td>
                                        <button class="edit-button" data-id="${booking.booking_id}">Edit</button>
                                        <button class="delete-button" data-id="${booking.booking_id}">Delete</button>
                                    </td>
                                `;
                                bookingsBody.appendChild(row);
                            });
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