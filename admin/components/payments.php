<div class="dashboard-container">
    <div class="dashboard-header">
        <?php
            echo "<h1>User Payments</h1>";
            echo '<div>Welcome ' . $_COOKIE['admin'] . '</div>';
        ?>
    </div>

    <!-- 🔍 Search Bar -->
    <div class="search-filter-container">
        <input type="text" id="searchInput" placeholder="Search payments..." />
    </div>

    <div class="table-container">
        <table id="paymentsTable">
            <thead>
                <tr>
                    <th>Payment ID</th>
                    <th>Booking ID</th>
                    <th>Payment Method</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody id="paymentsBody">
            </tbody>
        </table>
    </div>
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
<script>
document.addEventListener("DOMContentLoaded", () => {
    const paymentsBody = document.getElementById("paymentsBody");
    const searchInput = document.getElementById("searchInput");
    let paymentsData = [];

    function renderPayments(payments) {
        paymentsBody.innerHTML = '';
        payments.forEach(payment => {
            const row = document.createElement("tr");
            row.id = `row-${payment.payment_id}`;
            row.innerHTML = `
                <td>${payment.payment_id}</td>
                <td>${payment.booking_id}</td>
                <td>${payment.payment_method}</td>
                <td>${payment.amount}</td>
                <td>${payment.payment_date}</td>
                <td>${payment.status}</td>
                <td>
                    <button class="edit-button" onclick="updateStatus(${payment.payment_id}, 'Done')">
                        <i class="bi bi-check"></i> Done
                    </button>
                    <button class="edit-button" onclick="updateStatus(${payment.payment_id}, 'Pending')">
                        <i class="bi bi-arrow-clockwise"></i> Pending
                    </button>
                    <button class="delete-button" onclick="updateStatus(${payment.payment_id}, 'Cancel')">
                        <i class="bi bi-x"></i> Cancel
                    </button>
                </td>
            `;
            paymentsBody.appendChild(row);
        });
    }

    function loadPayments() {
        axios.get("../api/get_payments.php")
            .then(response => {
                paymentsData = response.data;
                renderPayments(paymentsData);
            })
             .catch(error => {
                            console.error("Error fetching packages:", error);
                            loader.innerHTML = `<p class="text-danger">❌ Failed to load packages.</p>`;
                     }).finally(() => {
                         document.getElementById("lineLoaderContainer").style.display = "none"; // Hide loader
                     });
    }

    window.updateStatus = function(paymentId, status) {
        axios.post("../api/update_payment_status.php", new URLSearchParams({
            payment_id: paymentId,
            status: status
        }))
        .then(response => {
            if (response.data.success) {
                alert("✅ " + response.data.message);
                const statusCell = document.querySelector(`#row-${paymentId} td:nth-child(6)`);
                if (statusCell) statusCell.innerText = status;
            } else {
                alert("❌ " + response.data.message);
            }
        })
        .catch(error => {
            alert("Error: " + error.message);
        });
    }

    // 🔍 Search functionality
    searchInput.addEventListener("input", () => {
        const searchTerm = searchInput.value.toLowerCase();
        const filtered = paymentsData.filter(payment =>
            payment.payment_id.toString().includes(searchTerm) ||
            payment.booking_id.toString().includes(searchTerm) ||
            payment.payment_method.toLowerCase().includes(searchTerm) ||
            payment.amount.toString().includes(searchTerm) ||
            payment.status.toLowerCase().includes(searchTerm)
        );
        renderPayments(filtered);
    });

    loadPayments();
});
</script>
