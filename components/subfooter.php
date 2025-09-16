<?php
// subfooter.php
?>

<head>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<style>
    *,a{text-decoration: none;color:var(--black-color);}
    *::selection{background: var(--black-color);color:var(--white-color);}
</style>
<div class="container mt-5 mb-5">
  <!-- FAQ Section -->
  <h3 class="mb-3">Frequently Asked Questions</h3>
  <div class="accordion" id="faqAccordion">
    <?php
    $faqs = [
      ["How do I book a flight on Globe Gateways?", "You can easily search, compare and book flights directly from our homepage with secure payment options."],
      ["Can I cancel my booking?", "Yes, cancellations are possible. Refund policies depend on the airline or hotel terms."],
      ["Do you offer international travel packages?", "Yes, we provide both domestic and international packages at competitive prices."],
      ["Is my payment secure?", "We use encrypted payment gateways ensuring 100% safe transactions."],
      ["How do I contact customer support?", "You can reach us 24/7 via our support page or helpline."],
      ["What is the cheapest day to book flights?", "Midweek bookings (Tuesday/Wednesday) usually offer cheaper fares."],
      ["Do you provide travel insurance?", "Yes, optional travel insurance can be added during checkout."],
      ["Can I book hotels without flights?", "Yes, hotels can be booked independently through our hotel search."],
      ["Are there discounts for group bookings?", "Yes, we offer special deals for group and corporate travel."],
      ["Can I pay in installments?", "Some packages allow EMI payment options with select banks."],
      ["Do you offer visa assistance?", "Yes, our team helps with online visa applications for multiple countries."],
      ["How do I track flight status?", "You can check flight status on our Flight Status page."],
      ["Are meals included in flight bookings?", "Meals depend on the airline and type of ticket purchased."],
      ["Can I change my travel date?", "Date changes are allowed based on airline/hotel policies with applicable charges."],
      ["What currencies are accepted?", "We accept INR and major international currencies for online payments."],
      ["Do you have a loyalty program?", "Yes, frequent users can earn rewards with our MyRewards program."],
      ["Can I book last-minute tickets?", "Yes, last-minute bookings are available depending on availability."],
      ["Do you provide cab services?", "Yes, local and intercity cabs can be booked directly from our site."],
      ["Is there an app for mobile bookings?", "Yes, you can download our mobile app for easy bookings."],
      ["Do you offer student discounts?", "Special student discounts are available on select flights and hotels."]
    ];

    foreach ($faqs as $index => $faq): ?>
      <div class="accordion-item">
        <h2 class="accordion-header" id="heading<?= $index ?>">
          <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
            data-bs-target="#collapse<?= $index ?>" aria-expanded="false" aria-controls="collapse<?= $index ?>">
            <?= $faq[0] ?>
          </button>
        </h2>
        <div id="collapse<?= $index ?>" class="accordion-collapse collapse"
          aria-labelledby="heading<?= $index ?>" data-bs-parent="#faqAccordion">
          <div class="accordion-body">
            <?= $faq[1] ?>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>

  <!-- Suggested Places Section -->
  <h3 class="mt-5 mb-3" >Best Suggested Places</h3>
  <div class="row mt-1" style="user-select:none;">
    <?php
    $places = [
      ["Goa, India", "Famous for beaches, nightlife, and water sports."],
      ["Manali, India", "Snowy mountains, adventure sports, and scenic beauty."],
      ["Kerala, India", "Backwaters, Ayurveda, and lush green landscapes."],
      ["Jaipur, India", "The Pink City known for forts, palaces, and culture."],
      ["Ladakh, India", "Adventure destination with high passes and monasteries."],
      ["Bali, Indonesia", "Paradise island with temples, beaches, and culture."],
      ["Dubai, UAE", "Luxury shopping, Burj Khalifa, and desert safari."],
      ["Paris, France", "Romantic city with Eiffel Tower and rich history."],
      ["Singapore", "Modern city with gardens, Sentosa, and nightlife."],
      ["Maldives", "Tropical luxury island with overwater villas."],
      ["Thailand", "Beaches, temples, nightlife, and affordable shopping."],
      ["Sri Lanka", "Cultural heritage, tea gardens, and beaches."],
      ["London, UK", "Historic landmarks, shopping, and global culture."],
      ["New York, USA", "Skyscrapers, Times Square, and Statue of Liberty."],
      ["Turkey", "Unique mix of Asia & Europe, Istanbul, and Cappadocia."],
      ["Switzerland", "Alps, lakes, and scenic train journeys."],
      ["Nepal", "Mount Everest treks and spiritual experiences."],
      ["Japan", "Cherry blossoms, Tokyo, and advanced technology."],
      ["Australia", "Sydney Opera House, Great Barrier Reef, and wildlife."],
      ["Mauritius", "Beautiful beaches, luxury resorts, and honeymoon spot."]
    ];

    foreach ($places as $place): ?>
      <div class="col-md-3 mb-3">
        <div class="card h-100 shadow-sm border-0">
          <div class="card-body text-center">
            <h6 class="card-title fw-bold"><?= $place[0] ?></h6>
            <p class="card-text small text-muted"><?= $place[1] ?></p>
          </div>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
</div>
