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
.pending-btn {
    background-color: #f0ad4e;
}
.pending-btn:hover {
    background-color: #ec971f;
    transform: scale(1.05);
}

/* Confirmed: Green */
.confirm-btn {
    background-color: #5cb85c;
}
.confirm-btn:hover {
    background-color: #4cae4c;
    transform: scale(1.05);
}

/* Cancelled: Red */
.cancel-btn {
    background-color: #d9534f;
}
.cancel-btn:hover {
    background-color: #c9302c;
    transform: scale(1.05);
}

.pending-btn i,
.confirm-btn i,
.cancel-btn i {
    margin-right: 0.4rem;
}

</style>

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
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="bookingsBody">
            </tbody>
        </table>
    </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
    const bookingsBody = document.getElementById("bookingsBody");
    if (!bookingsBody) return;

    function loadBookings() {
        bookingsBody.innerHTML = '';
        axios.get("../api/get_bookings.php")
            .then(response => {
                const bookings = response.data;
                bookings.forEach(booking => {
                    const row = document.createElement("tr");
                    row.id = `booking-${booking.booking_id}`;
                    row.innerHTML = `
                        <td>${booking.booking_id}</td>
                        <td>${booking.user_id}</td>
                        <td>${booking.package_id}</td>
                        <td>${booking.booking_date}</td>
                        <td>${booking.number_of_people}</td>
                        <td>${booking.total_price}</td>
                        <td>${booking.status}</td>
                        <td>
                            <button class="pending-btn" data-id="${booking.booking_id}">Pending</button>
                            <button class="confirm-btn" data-id="${booking.booking_id}">Confirmed</button>
                            <button class="cancel-btn" data-id="${booking.booking_id}">Cancelled</button>
                        </td>
                    `;
                    bookingsBody.appendChild(row);
                });

                document.querySelectorAll(".pending-btn").forEach(btn => {
                    btn.addEventListener("click", () => updateStatus(btn.dataset.id, "Pending"));
                });
                document.querySelectorAll(".confirm-btn").forEach(btn => {
                    btn.addEventListener("click", () => updateStatus(btn.dataset.id, "Confirmed"));
                });
                document.querySelectorAll(".cancel-btn").forEach(btn => {
                    btn.addEventListener("click", () => updateStatus(btn.dataset.id, "Cancelled"));
                });
            })
            .catch(error => {
                console.error("Error fetching bookings:", error);
                bookingsBody.innerHTML = `<tr><td colspan="8" class="text-danger">❌ Failed to load bookings.</td></tr>`;
            });
    }

    function updateStatus(bookingId, status) {
        axios.post("../api/update_booking_status.php", new URLSearchParams({
            booking_id: bookingId,
            status: status
        }))
        .then(res => {
            if (res.data.success) {
                const statusCell = document.querySelector(`#booking-${bookingId} td:nth-child(7)`);
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

    // Initial load
    loadBookings();
});
</script>
