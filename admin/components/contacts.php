<div class="dashboard-container">
    <div class="dashboard-header">
        <?php
            echo "<h1>User Contacts</h1>";
            echo '<div>Welcome ' . $_COOKIE['admin'] . '</div>';
        ?>
    </div>

    <!-- 🔍 Search Bar -->
    <div class="search-container">
        <input type="text" id="searchInput" placeholder="Search contacts...">
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
                </tr>
            </thead>
            <tbody id="contactsBody"></tbody>
        </table>
    </div>
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

<script>
document.addEventListener("DOMContentLoaded", () => {
    const contactsBody = document.getElementById("contactsBody");
    const searchInput = document.getElementById("searchInput");
    let allContacts = [];

    function loadContacts() {
        contactsBody.innerHTML = "";
        axios.get("../api/get_contacts.php")
            .then(res => {
                allContacts = Array.isArray(res.data) ? res.data : [];
                renderContacts(allContacts);
            })
             .catch(error => {
                             console.error("Error fetching packages:", error);
                             loader.innerHTML = `<p class="text-danger">❌ Failed to load packages.</p>`;
                         }).finally(() => {
                             document.getElementById("lineLoaderContainer").style.display = "none"; // Hide loader
                         });
    }

    function renderContacts(contacts) {
        contactsBody.innerHTML = "";
        contacts.forEach(contact => {
            const row = document.createElement("tr");
            row.id = `contact-${contact.contact_id}`;
            row.innerHTML = `
                <td>${contact.contact_id}</td>
                <td>${contact.full_name}</td>
                <td>${contact.email}</td>
                <td>${contact.subject}</td>
                <td>${contact.message}</td>
                <td>${contact.created_at}</td>
            `;
            contactsBody.appendChild(row);
        });
    }

    // 🔍 Search filter
    searchInput.addEventListener("input", () => {
        const term = searchInput.value.toLowerCase();
        const filtered = allContacts.filter(c =>
            Object.values(c).some(val =>
                String(val).toLowerCase().includes(term)
            )
        );
        renderContacts(filtered);
    });

    

    window.deleteContact = (id) => {
    if (!confirm("Are you sure you want to delete this contact?")) return;

     axios.post("../api/delete_contact.php", new URLSearchParams({ contact_id: id }))
        .then(res => {
            if (res.data.success) {
                alert("✅ Contact permanently deleted");
            } else {
                alert("❌ " + res.data.message);
            }
        })
        .catch(err => alert("Error: " + err.message))
        .finally(() => {
            const undoBox = document.getElementById("undoBox");
            if (undoBox) undoBox.remove();
            lastDeleted = null;
        });
};

    // Initial load
    loadContacts();
});
</script>
