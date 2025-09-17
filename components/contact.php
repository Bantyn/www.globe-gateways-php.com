<?php
$errorMessages = [];
$successMessage = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $name = trim($_POST['name']);
  $email = trim($_POST['email']);
  $message = trim($_POST['message']);

  // ------------------- VALIDATION -------------------
  if (empty($name) || empty($email) || empty($message)) {
    $errorMessages[] = "All fields are required.";
  }
  if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    $errorMessages[] = "Invalid email format.";
  }
  if (strlen($message) < 10) {
    $errorMessages[] = "Message must be at least 10 characters long.";
  }

  // ------------------- SEND EMAIL -------------------
  if (empty($errorMessages)) {
    $to = "example@example.com"; // your email
    $subject = "New Contact Form Submission";
    $body = "Name: $name\nEmail: $email\nMessage:\n$message";
    $headers = "From: $email";

    if (mail($to, $subject, $body, $headers)) {
      $successMessage = "Message sent successfully!";
      // clear form values
      $name = $email = $message = '';
    } else {
      $errorMessages[] = "Failed to send message. Please try again later.";
    }
  }
}
?>

<div class="contact-container">
  <div class="contact-wrapper">
    <div class="contact-header">
      <h1 class="contact-title">Let's Connect</h1>
      <p class="contact-subtitle">
        Have questions about our travel packages or want a custom trip planned?
        Fill out the form or reach us directly through our contact details.
        Our team is here to make your journey unforgettable! 🌍✈️
      </p>
    </div>
    <div class="contact-form card">
      <h2 class="form-title">Contact Us</h2>

      <!-- ERROR MESSAGES -->
      <?php if (!empty($errorMessages)): ?>
        <div class="error-message">
          <?php foreach ($errorMessages as $msg): ?>
            <p><?php echo htmlspecialchars($msg); ?></p>
          <?php endforeach; ?>
        </div>
      <?php endif; ?>


      <!-- SUCCESS MESSAGE -->
      <?php if ($successMessage): ?>
        <div class="success-message" style="color:green;">
          <p><?php echo htmlspecialchars($successMessage); ?></p>
        </div>
      <?php endif; ?>
      <form action="mailto:example@example.com" method="post" enctype="text/plain">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" required
          value="<?php echo isset($name) ? htmlspecialchars($name) : ''; ?>">

        <label for="email">Email:</label>
        <input type="email" id="email" name="email" required
          value="<?php echo isset($email) ? htmlspecialchars($email) : ''; ?>">

        <label for="message">Message:</label>
        <textarea id="message" name="message" rows="5"
          required><?php echo isset($message) ? htmlspecialchars($message) : ''; ?></textarea>

        <button type="submit" class="btn-submit">Send</button>
      </form>
    </div>

    <div class="contact-info card">
      <h3 class="info-title">Get in Touch</h3>
      <p>Email: <a href="mailto:example@example.com">example@example.com</a></p>
      <p>Phone: +1 (123) 456-7890</p>
      <p>Address: 123 Main St, Anytown, USA</p>

      <div class="social-media">
        <a href="#"><i class="ri-facebook-fill"></i></a>
        <a href="#"><i class="ri-twitter-fill"></i></a>
        <a href="#"><i class="ri-instagram-fill"></i></a>
        <a href="#"><i class="ri-linkedin-fill"></i></a>
        <a href="#"><i class="ri-youtube-fill"></i></a>
      </div>

      <p class="follow-text">Follow us on social media for the latest updates!</p>
    </div>
  </div>
</div>