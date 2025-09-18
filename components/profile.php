<?php
include '../database/config.php';

// Fetch user data
$userId = $_SESSION['username'];
$query = "SELECT user_id, username, password, email, profile_img FROM users WHERE username='$userId'";
$result = $conn->query($query);
$user = $result->fetch_assoc();
$user_id = $user['user_id'];

// Fetch booking history
$bookings = $conn->query("SELECT  b.payment_status,b.booking_id,p.title, b.booking_date, b.number_of_people, b.total_price, b.status 
                          FROM bookings b 
                          JOIN packages p ON b.package_id = p.package_id 
                          WHERE b.user_id='$user_id' 
                          ORDER BY b.booking_date DESC");

// Fetch reviews
$reviews = $conn->query("SELECT  p.title, r.rating, r.comment, r.created_at 
                         FROM reviews r 
                         JOIN packages p ON r.package_id = p.package_id 
                         WHERE r.user_id='$user_id' 
                         ORDER BY r.created_at DESC");
?>

<!-- Profile Section -->
<div class="profile-container">
  <div class="profile-card">
    <form action="api/update_profile.php" method="POST" enctype="multipart/form-data">
      <div style="display:flex;flex-direction:column;align-items:center;" class="profile-pic">
        <h1>Profile</h1>
        <img id="profilePreview"
             src="<?php echo $user['profile_img'] ? '../uploads/user/' . $user['profile_img'] : '../uploads/user/default.png'; ?>"
             alt="Profile" style="width:150px; height:150px; object-fit:cover; border-radius:50%;">
        <label for="profileImage" class="upload-btn" style="width:80%; margin-top:10px; cursor:pointer;">Upload</label>
        <input type="file" id="profileImage" name="profileImage" accept="image/*" onchange="previewImage(event)" style="display:none;">
      </div>

      <div class="profile-fields">
        <label>Username:</label>
        <input type="text" value="<?php echo $user['username']; ?>" disabled>

        <label>Password:</label>
        <input type="password" value="<?php echo $user['password']; ?>" disabled>

        <label>Email:</label>
        <input type="email" name="email" value="<?php echo $user['email']; ?>">

        <button type="submit" class="save-btn">Save Changes</button>
      </div>
    </form>
  </div>
</div>

<!-- JS at the bottom -->
<script>
function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
        document.getElementById("profilePreview").src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
}
</script>


<!-- Booking History Section -->
<div class="history-container">
  <?php
  include '../database/config.php';

  // Fetch user data
  $userId = $_SESSION['username'];
  $query = "SELECT user_id, username, password, email, profile_img FROM users WHERE username='$userId'";
  $result = $conn->query($query);
  $user = $result->fetch_assoc();
  $user_id = $user['user_id'];

  // Fetch booking history
$bookings = $conn->query("
    SELECT b.booking_id, b.package_id, p.title, b.booking_date, b.number_of_people, b.total_price, b.status, b.payment_status
    FROM bookings b
    JOIN packages p ON b.package_id = p.package_id
    WHERE b.user_id='$user_id'
    ORDER BY b.booking_date DESC
");
  // Fetch existing reviews
  $reviews = [];
  $reviewResult = $conn->query("SELECT * FROM reviews WHERE user_id='$user_id'");
  while ($r = $reviewResult->fetch_assoc()) {
    $reviews[$r['booking_id']] = $r;
  }
  ?>

  <!-- Booking History Section -->
  <div class="history-container">
    <h2>Your Booking History</h2>
    <table class="history-table">
      <thead>
        <tr>
          <th>ID</th>
          <th>Package</th>
          <th>Date</th>
          <th>People</th>
          <th>Total Price</th>
          <th>Status</th>
          <th>Payment Status</th>
          <th>Review</th>
        </tr>
      </thead>
      <tbody>
        <?php while ($row = $bookings->fetch_assoc()): ?>
          <tr>
            <td><?= $row['booking_id']; ?></td>
            <td><?= htmlspecialchars($row['title']); ?></td>
            <td><?= $row['booking_date']; ?></td>
            <td><?= $row['number_of_people']; ?></td>
            <td>₹ <?= $row['total_price']; ?></td>
            <td><span class="status <?= $row['status']; ?>"><?= ucfirst($row['status']); ?></span></td>
            <td>
              <span class="payment-status <?= $row['payment_status'] == 'Paid' ? 'Paid' : 'Pending'; ?>">
                <?= ucfirst($row['payment_status']); ?>
              </span>
            </td>
            <td>
              <?php if (isset($reviews[$row['booking_id']])): ?>
                <span class="review-text"><?= htmlspecialchars($reviews[$row['booking_id']]['review_text'] ?? $reviews[$row['booking_id']]['comment']); ?>
                  (<?= $reviews[$row['booking_id']]['rating']; ?>/5)</span>
              <?php else: ?>
                <button type="button" class="review-btn" data-id="<?= $row['booking_id']; ?>">Add Review</button>
              <?php endif; ?>
            </td>
          </tr>

          <!-- Hidden Review Form Row -->
          <tr id="review-form-<?= $row['booking_id']; ?>" style="display:none;">
            <td colspan="8">
              <form method="POST" class="review-card review-form" data-id="<?= intval($row['booking_id']); ?>">
                <input type="hidden" name="booking_id" value="<?= intval($row['booking_id']); ?>">
                <input type="hidden" name="package_id" value="<?= intval($row['package_id']); ?>">
                <textarea name="review_text" placeholder="Write your review..." required></textarea>
                <label>Rating:
                  <select name="rating">
                    <option value="1">1</option>
                    <option value="2">2</option>
                    <option value="3">3</option>
                    <option value="4">4</option>
                    <option value="5" selected>5</option>
                  </select>
                </label>
                <button type="submit" class="save-btn">Submit Review</button>
              </form>
              <script>
                document.querySelectorAll('.review-form').forEach(form => {
                  form.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const bookingId = this.dataset.id;

                    fetch('api/submit_review.php', {
                        method: 'POST',
                        body: formData
                      })
                      .then(res => res.json())
                      .then(data => {
                        if (data.success) {
                          const reviewCell = document.querySelector(`#review-form-${bookingId}`).previousElementSibling.querySelector('td:last-child');
                          reviewCell.innerHTML = `${data.review_text} (${data.rating}/5)`;
                          document.getElementById('review-form-' + bookingId).style.display = 'none';
                        } else {
                          alert(data.message || 'Something went wrong!');
                        }
                      })
                      .catch(err => console.error(err));
                  });
                });
              </script>
            </td>
          </tr>
        <?php endwhile; ?>
      </tbody>
    </table>
  </div>

  <script>
    // Toggle review form visibility
    document.querySelectorAll('.review-btn').forEach(btn => {
      btn.addEventListener('click', function() {
        const bookingId = this.getAttribute('data-id');
        const formRow = document.getElementById('review-form-' + bookingId);
        formRow.style.display = formRow.style.display === 'none' ? 'table-row' : 'none';
        formRow.scrollIntoView({
          behavior: "smooth",
          block: "center"
        });
      });
    });
  </script>

  <style>
    .review-card {
      background: #f5f5f5;
      padding: 1rem;
      border-radius: 0.5rem;
      display: flex;
      flex-direction: column;
      gap: 0.5rem;
    }

    .review-card textarea {
      width: 100%;
      padding: 0.5rem;
    }

    .save-btn {
      background: #1B1B1B;
      color: white;
      border: none;
      padding: 0.5rem 1rem;
      border-radius: 0.25rem;
      cursor: pointer;
    }

    .review-btn {
      background: #007BFF;
      color: white;
      border: none;
      padding: 0.3rem 0.7rem;
      border-radius: 0.25rem;
      cursor: pointer;
    }

    .payment-status.Paid {
      color: green;
      font-weight: bold;
    }

    .payment-status.Pending {
      color: orange;
      font-weight: bold;
    }

    .status.pending {
      color: orange;
      font-weight: 600;
    }

    .status.confirmed {
      color: green;
      font-weight: 600;
    }

    .status.cancelled {
      color: crimson;
      font-weight: 600;
    }
  </style>

</div>
<!-- Reviews Section -->
<div class="review-container">
  <h2>Your Reviews</h2>

  <?php
  // Fetch reviews grouped by package
  $reviewsByPackage = [];
  $reviewResult = $conn->query("
      SELECT r.*, p.title 
      FROM reviews r
      JOIN packages p ON r.package_id = p.package_id
      WHERE r.user_id='$user_id'
      ORDER BY r.created_at DESC
  ");
  while ($rev = $reviewResult->fetch_assoc()) {
      $reviewsByPackage[$rev['package_id']][] = $rev;
  }

  foreach ($reviewsByPackage as $packageId => $packageReviews):
      $packageTitle = $packageReviews[0]['title']; // All reviews share same package title
  ?>
    <div class="review-card-container" style="border:1px solid #ccc; padding:1rem; margin-bottom:1rem; border-radius:8px;">
      <h3><?= htmlspecialchars($packageTitle); ?></h3>
      <?php foreach ($packageReviews as $rev): ?>
        <div class="review-card" style="margin-bottom:0.5rem; padding:0.5rem; background:#f5f5f5; border-radius:5px;">
          <p><strong>Rating:</strong> ⭐ <?= $rev['rating']; ?>/5</p>
          <p><strong>Comment:</strong> <?= htmlspecialchars($rev['comment']); ?></p>
          <p><small><strong>Date:</strong> <?= $rev['created_at']; ?></small></p>
        </div>
      <?php endforeach; ?>
    </div>
  <?php endforeach; ?>

</div>
