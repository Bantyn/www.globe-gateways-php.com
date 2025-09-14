<div class="about-wrapper">
  <!-- Header -->
  <div class="about-header">
    <h1 class="about-title text-animate">About Globe Gateways</h1>
    <p class="about-subtitle">
      We are your trusted partner in exploring the world. From international tours to
      local escapes, Globe Gateways is dedicated to curating memorable travel
      experiences for every traveler. 🌍✨
    </p>
  </div>

  <!-- Mission -->
  <div class="about-section mission">
    <h2 class="section-heading magnet">Our Mission</h2>
    <p>
      To provide travelers with carefully curated packages that blend comfort,
      adventure, and culture. We believe travel should be more than a trip – it
      should be a lifetime memory.
    </p>
  </div>

  <!-- Vision -->
  <div class="about-section vision">
    <h2 class="section-heading magnet">Our Vision</h2>
    <p>
      To become a global leader in travel experiences by offering innovative,
      affordable, and customer-centric services while connecting people with the
      beauty of the world.
    </p>
  </div>

  <!-- Features -->
  <div class="about-features">
    <h2 class="section-heading magnet">Why Choose Globe Gateways?</h2>
    <div class="feature-cards">
      <div class="hvr feature-card fade-in"><i class="ri-earth-fill"></i>
        <h3>Global Reach</h3>
        <p>Explore destinations across 40+ countries with customized travel packages.</p>
      </div>
      <div class="hvr feature-card fade-in delay-1"><i class="ri-customer-service-2-fill"></i>
        <h3>24/7 Support</h3>
        <p>Our travel experts are always ready to guide you, anytime and anywhere.</p>
      </div>
      <div class="hvr feature-card fade-in delay-2"><i class="ri-hotel-fill"></i>
        <h3>Luxury & Comfort</h3>
        <p>Handpicked hotels, comfortable stays, and smooth transportation for you.</p>
      </div>
      <div class="hvr feature-card fade-in delay-3"><i class="ri-price-tag-3-fill"></i>
        <h3>Affordable Pricing</h3>
        <p>Best value packages with no hidden costs – making travel accessible to all.</p>
      </div>
    </div>
  </div>

  <!-- Journey Timeline -->
  <div class="about-timeline">
    <h2 class="section-heading magnet">Our Journey</h2>
    <ul>
      <li><span>2015</span> - Founded with a vision to make travel simpler.</li>
      <li><span>2018</span> - Expanded to international destinations.</li>
      <li><span>2021</span> - Served over 50,000 happy customers worldwide.</li>
      <li><span>2024</span> - Recognized as a top-rated travel agency in Asia.</li>
    </ul>
  </div>

  <!-- Stats -->
  <div class="about-stats">
    <div class="stat"><h2 class="counter" data-target="50000">0</h2><p>Happy Travelers</p></div>
    <div class="stat"><h2 class="counter" data-target="40">0</h2><p>Countries</p></div>
    <div class="stat"><h2 class="counter" data-target="150">0</h2><p>Tours Organized</p></div>
  </div>

  <!-- Team -->
  <div class="about-team">
    <h2 class="section-heading magnet">Meet Our Experts</h2>
    <div class="team-cards">
      <div class="team-card">
        <img src="https://picsum.photos/1920/1920" style="width: 20vw;" alt="Team Member">
        <h3>Banty Patel</h3><p>Founder & CEO</p>
      </div>
      <div class="team-card">
        <img src="https://picsum.photos/1920/1920" style="width: 20vw;" alt="Team Member">
        <h3>Alisha Patel</h3><p>Travel Consultant</p>
      </div>
      <div class="team-card">
        <img src="https://picsum.photos/1920/1920" style="width: 20vw;" alt="Team Member">
        <h3>Ayush Palavwala</h3><p>Operations Manager</p>
      </div>
    </div>
  </div>

  <!-- Call to Action -->
  <div class="about-cta">
    <h2 class="cta-title">Ready for your next adventure?</h2>
    <p>
      Join thousands of happy travelers who chose Globe Gateways for their journeys.
      Let’s create your story today.
    </p>
    <a href="page/packages.php"><button class="exploreBtn magnet">Explore Packages</button></a>
  </div>
</div>

<script>
document.addEventListener("DOMContentLoaded", () => {
  gsap.registerPlugin(ScrollTrigger);

  // Timeline items
  gsap.utils.toArray(".about-timeline li").forEach((item, i) => {
    gsap.from(item, {
      x: i % 2 === 0 ? -150 : 150,
      opacity: 0,
      duration: 1,
      ease: "power2.out",
      scrollTrigger: { trigger: item, start: "top 85%", toggleActions: "play none none reverse" }
    });
  });

  // Stats counter animation
  const counters = document.querySelectorAll(".counter");
  counters.forEach(counter => {
    let target = +counter.dataset.target;
    ScrollTrigger.create({
      trigger: counter,
      start: "top 85%",
      once: true,
      onEnter: () => {
        gsap.to(counter, {
          innerText: target,
          duration: 2,
          snap: { innerText: 1 },
          ease: "power1.out"
        });
      }
    });
  });

  // Team cards
  gsap.from(".team-card", {
    y: 100,
    opacity: 0,
    scale: 0.8,
    stagger: 0.3,
    duration: 1.2,
    ease: "back.out(1.7)",
    scrollTrigger: {
      trigger: ".about-team",
      start: "top 80%",
      toggleActions: "play none none reverse"
    }
  });
});
</script>
hvr 
