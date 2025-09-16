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
          alt="Profile">
        <label for="profileImage" class="upload-btn" style="width:80%">Upload</label>
        <input type="file" id="profileImage" name="profileImage" accept="image/*" onchange="previewImage(event)">
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
          <style>
            .payment-status.Paid {
              color: green;
              font-weight: bold;
            }

            .payment-status.Pending {
              color: orange;
              font-weight: bold;
            }
          </style>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<!-- Reviews Section -->
<div class="review-container">
  <h2>Your Reviews</h2>
  <table class="review-table">
    <thead>
      <tr>

        <th>Package</th>
        <th>Rating</th>
        <th>Comment</th>
        <th>Date</th>
      </tr>
    </thead>
    <tbody>
      <?php while ($row = $reviews->fetch_assoc()): ?>
        <tr>

          <td><?= htmlspecialchars($row['title']); ?></td>
          <td>⭐ <?= $row['rating']; ?>/5</td>
          <td><?= htmlspecialchars($row['comment']); ?></td>
          <td><?= $row['created_at']; ?></td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>
<?php
include '../components/subfooter.php';
?>
<script>
  function previewImage(event) {
    const reader = new FileReader();
    reader.onload = function() {
      document.getElementById("profilePreview").src = reader.result;
    }
    reader.readAsDataURL(event.target.files[0]);
  }
</script>