 <div class="dashboard-container">
     <div class="dashboard-header">

         <?php
            echo "<h1>User Payments</h1>";
            echo '<div>Wellcome ' . $_COOKIE['admin'] . '</div>';
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
                 <script>
                     axios.get("../api/get_payments.php").then(response => {
                         const payments = response.data;
                         const paymentsBody = document.getElementById("paymentsBody");
                         payments.forEach(payment => {
                             paymentsBody.innerHTML += `
                             <tr id="row-${payment.payment_id}">
                                    <td>${payment.payment_id}</td>
                                    <td>${payment.booking_id}</td>
                                    <td>${payment.payment_method}</td>
                                    <td>${payment.amount}</td>
                                    <td>${payment.payment_date}</td>
                                    <td>${payment.status}</td>
                                    <td>
                                        <button class="edit-button" onclick="updateStatus(${payment.payment_id}, 'Done')">
                                            <i class="bi bi-check"></i>Done
                                        </button>
                                        <button class="edit-button" onclick="updateStatus(${payment.payment_id}, 'Pending')">
                                            <i class="bi bi-arrow-clockwise"></i>Pending
                                        </button>
                                        <button class="delete-button" onclick="updateStatus(${payment.payment_id}, 'Cancel')">
                                            <i class="bi bi-x"></i>Cancel
                                        </button>
                                    </td>
                                </tr>`;
                             paymentsBody.appendChild(row);
                         });
                     }).catch(error => {
                         console.error("Error fetching packages:", error);
                         loader.innerHTML = `<p class="text-danger">❌ Failed to load packages.</p>`;
                     }).finally(() => {
                         document.getElementById("lineLoaderContainer").style.display = "none"; // Hide loader
                     });


                     function updateStatus(paymentId, status) {
                         axios.post("../api/update_payment_status.php", new URLSearchParams({
                                 payment_id: paymentId,
                                 status: status
                             }))
                             .then(response => {
                                 if (response.data.success) {
                                     alert("✅ " + response.data.message);
                                     // Update UI instantly without page reload
                                     document.querySelector(`#row-${paymentId} td:nth-child(6)`).innerText = status;
                                    

                                 } else {
                                     alert("❌ " + response.data.message);
                                 }
                             })
                             .catch(error => {
                                 alert("Error: " + error.message);
                             });
                     }
                 </script>

             </tbody>
         </table>
     </div>
 </div>