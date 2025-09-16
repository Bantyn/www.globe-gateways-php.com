<div class="dashboard-container">
    <div class="dashboard-header">
        <?php
            echo "<h1>User Payments</h1>";
            echo '<div>Welcome ' . $_COOKIE['admin'] . '</div>';
        ?>
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

<script>
document.addEventListener("DOMContentLoaded", () => {
    const paymentsBody = document.getElementById("paymentsBody");

    function loadPayments() {
        paymentsBody.innerHTML = ''; 

        axios.get("../api/get_payments.php")
            .then(response => {
                const payments = response.data;
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
    loadPayments();
});
</script>
