<style>
/* Booking status buttons */
.pending-btn,
.confirm-btn,
.cancel-btn {
    color: var(--white-color);
    border: none;
    padding: 0.5rem 1rem;
    border-radius: 0.25rem;
    font-family: var(--main-font-semibold);
    font-size: 0.9rem;
    cursor: pointer;
    transition: background 0.3s, transform 0.2s;
    margin-right: 0.3rem;
}

/* Pending: Orange */
.pending-btn { background-color: #f0ad4e; }
.pending-btn:hover { background-color: #ec971f; transform: scale(1.05); }

/* Confirmed: Green */
.confirm-btn { background-color: #5cb85c; }
.confirm-btn:hover { background-color: #4cae4c; transform: scale(1.05); }

/* Cancelled: Red */
.cancel-btn { background-color: #d9534f; }
.cancel-btn:hover { background-color: #c9302c; transform: scale(1.05); }

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

<div class="dashboard-container">
    <div class="dashboard-header">
        <?php
            echo "<h1>User Bookings</h1>";
            echo '<div>Welcome ' . $_COOKIE['admin'] . '</div>';
        ?>
    </div>

    <!-- 🔍 Search Bar -->
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search bookings...">
    </div>

    <div class="table-container">
        <table id="usersTable">
            <thead>
                <tr>
                    <th>Booking ID</th>
                    <th>User ID</th>
                    <th>Full Name</th>
                    <th>Email</th>
                    <th>Package ID</th>
                    <th>Booking Date</th>
                    <th>No. of People</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Created At</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="bookingsBody"></tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const bookingsBody = document.getElementById("bookingsBody");
    const searchInput = document.getElementById("searchInput");
    let allBookings = [];

    function loadBookings() {
        bookingsBody.innerHTML = '<tr><td colspan="12">Loading...</td></tr>';
        axios.get("../api/get_bookings.php")
            .then(response => {
                allBookings = Array.isArray(response.data) ? response.data : [];
                renderBookings(allBookings);
            })
           .catch(error => {
                             console.error("Error fetching packages:", error);
                             loader.innerHTML = `<p class="text-danger">❌ Failed to load packages.</p>`;
                         }).finally(() => {
                             document.getElementById("lineLoaderContainer").style.display = "none"; // Hide loader
                         });
    }

    function renderBookings(bookings) {
        bookingsBody.innerHTML = '';
        if (bookings.length === 0) {
            bookingsBody.innerHTML = `<tr><td colspan="12">No bookings found</td></tr>`;
            return;
        }

        bookings.forEach(booking => {
            const row = document.createElement("tr");
            row.id = `booking-${booking.booking_id}`;
            row.innerHTML = `
                <td>${booking.booking_id}</td>
                <td>${booking.user_id}</td>
                <td>${booking.user_name || "-"}</td>
                <td>${booking.user_email || "-"}</td>
                <td>${booking.package_id}</td>
                <td>${booking.booking_date}</td>
                <td>${booking.number_of_people}</td>
                <td>₹ ${booking.total_price}</td>
                <td>${booking.status}</td>
                <td>${booking.created_at || "-"}</td>
                <td>
                    <button class="pending-btn" data-id="${booking.booking_id}">Pending</button>
                    <button class="confirm-btn" data-id="${booking.booking_id}">Confirmed</button>
                    <button class="cancel-btn" data-id="${booking.booking_id}">Cancelled</button>
                </td>
            `;
            bookingsBody.appendChild(row);
        });

        document.querySelectorAll(".pending-btn").forEach(btn =>
            btn.addEventListener("click", () => updateStatus(btn.dataset.id, "Pending"))
        );
        document.querySelectorAll(".confirm-btn").forEach(btn =>
            btn.addEventListener("click", () => updateStatus(btn.dataset.id, "Confirmed"))
        );
        document.querySelectorAll(".cancel-btn").forEach(btn =>
            btn.addEventListener("click", () => updateStatus(btn.dataset.id, "Cancelled"))
        );
    }

    function updateStatus(bookingId, status) {
        axios.post("../api/update_booking_status.php", new URLSearchParams({
            booking_id: bookingId,
            status: status
        }))
        .then(res => {
            if (res.data.success) {
                const statusCell = document.querySelector(`#booking-${bookingId} td:nth-child(9)`);
                if (statusCell) statusCell.innerText = status;
                alert(`✅ Booking ${bookingId} updated to ${status}`);
            } else {
                alert(`❌ ${res.data.message}`);
            }
        })
        .catch(err => {
            alert("Error: " + err.message);
        });
    }

    // 🔍 Search
    searchInput.addEventListener("input", () => {
        const term = searchInput.value.toLowerCase();
        const filtered = allBookings.filter(b =>
            Object.values(b).some(val =>
                String(val).toLowerCase().includes(term)
            )
        );
        renderBookings(filtered);
    });

    loadBookings();
});
</script>
