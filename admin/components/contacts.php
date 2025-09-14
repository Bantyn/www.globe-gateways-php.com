 <div class="dashboard-container">
     <div class="dashboard-header">

         <?php
            echo "<h1>User Contacts</h1>";
            echo '<div>Wellcome ' . $_COOKIE['admin'] . '</div>';
            ?>

     </div>

     <div class="table-container">
         <table id="contactsTable">
             <thead>
                 <tr>
                     <th>Contact ID</th>
                     <th>Full Name</th>
                     <th>Email</th>
                     <th>Subject</th>
                     <th>Message</th>
                     <th>Created At</th>
                     <th>Actions</th>
                 </tr>
             </thead>
             <tbody id="contactsBody">
                <style>
                    .btn-edit-contact i,
.btn-delete-contact i{
    color: var(--white-color);
}

.btn-edit-contact{
    background-color: royalblue;
    border: none;
    border-radius: 0.3rem;
    padding: 0.5rem 0.8rem;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
    margin-bottom: 0.3rem;
}
.btn-edit-contact:hover{
    background-color: darkblue;
}
.btn-delete-contact{
    background-color: crimson;
    color: var(--white-color);
    border: none;
    border-radius: 0.3rem;
    padding: 0.5rem 0.8rem;
    cursor: pointer;
    font-size: 1rem;
    transition: background-color 0.3s;
}
.btn-delete-contact:hover{
    background-color: darkred;
}
                </style>
                 <script>
                     loader = document.getElementById("lineLoaderContainer") // Show loader
                     axios.get('../api/get_contacts.php')
                         .then(function(response) {
                             const contacts = response.data;
                             const contactsBody = document.getElementById('contactsBody');

                             contacts.forEach(contact => {
                                 const row = document.createElement('tr');
                                 row.innerHTML = `
                                        <td>${contact.id}</td>
                                        <td>${contact.full_name}</td>
                                        <td>${contact.email}</td>
                                        <td>${contact.subject}</td>
                                        <td>${contact.message}</td>
                                        <td>${contact.created_at}</td>
                                        <td>
                                            <button class="edit-button" onclick="editContact(${contact.id})"><i class="bi bi-pencil"></i>Edit</button>
                                            <button class="delete-button" onclick="deleteContact(${contact.id})"><i class="bi bi-trash"></i>Delete</button>
                                        </td>
                                    `;
                                 contactsBody.appendChild(row);
                                });
                             
                            })
                            .catch(error => {
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