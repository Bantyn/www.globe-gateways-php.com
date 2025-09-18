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
  <form id="contactForm" method="POST">
    <label for="full_name">Name:</label>
    <input type="text" id="full_name" name="full_name" required>

    <label for="email">Email:</label>
    <input type="email" id="email" name="email" required>

    <label for="subject">Subject:</label>
    <input type="text" id="subject" name="subject" required>

    <label for="message">Message:</label>
    <textarea id="message" name="message" rows="5" required></textarea>

    <button type="submit" class="btn-submit">Send</button>
  </form>
  <p id="formResponse" style="margin-top:10px;"></p>
</div>


  <div class="contact-info card">
    <h3 class="info-title">Get in Touch</h3>
    <p>Email: <a href="mailto:example@example.com">patelbanty@gmail.com</a></p>
    <p>Phone: +91 9909914197</p>
    <p>Address: Surat</p>

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

<script>
document.getElementById('contactForm').addEventListener('submit', function(e) {
    e.preventDefault();

    const formData = new FormData(this);

    fetch('api/submit_contact.php', {
        method: 'POST',
        body: formData
    })
    .then(res => res.json())
    .then(data => {
        const responseEl = document.getElementById('formResponse');
        responseEl.textContent = data.message;
        responseEl.style.color = data.success ? 'green' : 'red';
        if (data.success) this.reset();
    })
    .catch(err => console.error(err));
});
</script>
