<?php
  // Dynamic page config
  $site_name    = "bookHotel";
  $site_tagline = "Hotel Booking";

  // Dynamic check-in / check-out dates (server-side)
  $checkin  = date('Y-m-d', strtotime('+1 day'));
  $checkout = date('Y-m-d', strtotime('+2 days'));

  // Current year for footer copyright
  $current_year = date('Y');
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title><?php echo htmlspecialchars($site_name); ?> – <?php echo htmlspecialchars($site_tagline); ?></title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" rel="stylesheet"/>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
  <link rel="stylesheet" href="style.css"/>
</head>
<body>

<!-- ========== NAVBAR ========== -->
<nav class="navbar navbar-expand-lg navbar-dark sticky-top" id="mainNav">
  <div class="container">
    <a class="navbar-brand fw-800 fs-4" href="#">
      <i class="bi bi-building-fill text-warning me-1"></i>bookHotel
    </a>
    <button class="navbar-toggler border-0" type="button" data-bs-toggle="collapse" data-bs-target="#navMenu">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navMenu">
      <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-1">
        <li class="nav-item"><a class="nav-link" href="hotels.html">Hotels</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Destinations</a></li>
        <li class="nav-item"><a class="nav-link" href="#">My Bookings</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
        <li class="nav-item ms-lg-3">
          <a class="btn btn-outline-warning btn-sm px-3" href="login.html">Login / Sign Up</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<!-- ========== HERO SECTION ========== -->
<section class="hero-section d-flex align-items-center">
  <div class="hero-overlay"></div>
  <div class="container position-relative z-1 text-white text-center py-5">
    <h1 class="display-4 fw-800 mb-2">Find Your Perfect Stay</h1>
    <p class="lead mb-4 opacity-75">Over 1 million hotels across 200+ countries. Best price guaranteed.</p>

    <!-- Search Tabs -->
    <div class="search-card mx-auto">
      <ul class="nav nav-pills search-tabs mb-4" id="searchTab">
        <li class="nav-item">
          <button class="nav-link active" data-bs-toggle="pill" data-bs-target="#hotels">
            <i class="bi bi-building me-1"></i>Hotels
          </button>
        </li>
      </ul>

      <div class="tab-content">
        <!-- Hotels Tab -->
        <div class="tab-pane fade show active" id="hotels">
          <div class="row g-2 align-items-end">
            <div class="col-12 col-md-4">
              <label class="form-label small fw-600 text-muted">WHERE</label>
              <div class="input-group">
                <span class="input-group-text bg-white border-end-0"><i class="bi bi-geo-alt-fill text-warning"></i></span>
                <input type="text" class="form-control border-start-0 ps-0" placeholder="City, hotel or destination"/>
              </div>
            </div>
            <div class="col-6 col-md-2">
              <label class="form-label small fw-600 text-muted">CHECK-IN</label>
              <input type="date" class="form-control" value="<?php echo $checkin; ?>"/>
            </div>
            <div class="col-6 col-md-2">
              <label class="form-label small fw-600 text-muted">CHECK-OUT</label>
              <input type="date" class="form-control" value="<?php echo $checkout; ?>"/>
            </div>
            <div class="col-6 col-md-2">
              <label class="form-label small fw-600 text-muted">ROOMS & GUESTS</label>
              <select class="form-select">
                <option>1 Room, 2 Guests</option>
                <option>1 Room, 1 Guest</option>
                <option>2 Rooms, 4 Guests</option>
                <option>3 Rooms, 6 Guests</option>
              </select>
            </div>
            <div class="col-6 col-md-2">
              <button class="btn btn-warning w-100 fw-700 py-2">
                <i class="bi bi-search me-1"></i>Search
              </button>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== TRUST BADGES ========== -->
<section class="py-4 bg-white border-bottom">
  <div class="container">
    <div class="row text-center g-3">
      <div class="col-6 col-md-3">
        <div class="d-flex align-items-center justify-content-center gap-2">
          <i class="bi bi-shield-check-fill text-success fs-4"></i>
          <div class="text-start">
            <div class="fw-700 small">Secure Booking</div>
            <div class="text-muted" style="font-size:0.75rem">100% Safe & Encrypted</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="d-flex align-items-center justify-content-center gap-2">
          <i class="bi bi-tag-fill text-warning fs-4"></i>
          <div class="text-start">
            <div class="fw-700 small">Best Price</div>
            <div class="text-muted" style="font-size:0.75rem">Price Match Guarantee</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="d-flex align-items-center justify-content-center gap-2">
          <i class="bi bi-headset text-primary fs-4"></i>
          <div class="text-start">
            <div class="fw-700 small">24/7 Support</div>
            <div class="text-muted" style="font-size:0.75rem">Always here to help</div>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="d-flex align-items-center justify-content-center gap-2">
          <i class="bi bi-arrow-counterclockwise text-danger fs-4"></i>
          <div class="text-start">
            <div class="fw-700 small">Free Cancellation</div>
            <div class="text-muted" style="font-size:0.75rem">On select hotels</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== POPULAR DESTINATIONS ========== -->
<section class="py-5 bg-light">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="fw-800 mb-1">Popular Destinations</h2>
        <p class="text-muted mb-0">Handpicked cities loved by travellers</p>
      </div>
      <a href="#" class="btn btn-outline-primary btn-sm">View All</a>
    </div>
    <div class="row g-3">
      <div class="col-6 col-md-3">
        <div class="dest-card">
          <img src="https://images.unsplash.com/photo-1570168007204-dfb528c6958f?w=400&q=80" alt="Mumbai"/>
          <div class="dest-overlay">
            <h5 class="fw-700 mb-0">Mumbai</h5>
            <small>342 Hotels</small>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="dest-card">
          <img src="https://images.unsplash.com/photo-1614082242765-7c98ca0f3df3?w=400&q=80" alt="Goa"/>
          <div class="dest-overlay">
            <h5 class="fw-700 mb-0">Goa</h5>
            <small>218 Hotels</small>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="dest-card">
          <img src="https://images.unsplash.com/photo-1587474260584-136574528ed5?w=400&q=80" alt="Delhi"/>
          <div class="dest-overlay">
            <h5 class="fw-700 mb-0">Delhi</h5>
            <small>415 Hotels</small>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="dest-card">
          <img src="https://images.unsplash.com/photo-1477587458883-47145ed94245?w=400&q=80" alt="Jaipur"/>
          <div class="dest-overlay">
            <h5 class="fw-700 mb-0">Jaipur</h5>
            <small>187 Hotels</small>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="dest-card">
          <img src="https://th.bing.com/th/id/OIP.aY2bWZrLy8hna1aiaIunowHaEc?w=297&h=180&c=7&r=0&o=7&dpr=1.5&pid=1.7&rm=3" alt="Kerala"/>
          <div class="dest-overlay">
            <h5 class="fw-700 mb-0">Kerala</h5>
            <small>296 Hotels</small>
          </div>
        </div>
      </div>
      <div class="col-6 col-md-4">
        <div class="dest-card">
          <img src="https://images.unsplash.com/photo-1626621341517-bbf3d9990a23?w=400&q=80" alt="Manali"/>
          <div class="dest-overlay">
            <h5 class="fw-700 mb-0">Manali</h5>
            <small>143 Hotels</small>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="dest-card">
          <img src="https://wallpapers.com/images/hd/lake-pichola-palace-rajputana-hd-dspdgwndxa2ug3qu.jpg" alt="Udaipur"/>
          <div class="dest-overlay">
            <h5 class="fw-700 mb-0">Udaipur</h5>
            <small>112 Hotels</small>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== FEATURED HOTELS ========== -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
      <div>
        <h2 class="fw-800 mb-1">Top-Rated Hotels</h2>
        <p class="text-muted mb-0">Loved by millions of happy guests</p>
      </div>
      <a href="#" class="btn btn-outline-primary btn-sm">View All</a>
    </div>
    <div class="row g-4">

      <!-- Hotel Card 1 -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="hotel-card card border-0 shadow-sm h-100">
          <div class="position-relative">
            <img src="https://images.unsplash.com/photo-1566073771259-6a8506099945?w=400&q=80" class="card-img-top hotel-img" alt="Hotel"/>
            <span class="badge bg-success position-absolute top-0 start-0 m-2">Free Cancellation</span>
            <button class="btn-wishlist" aria-label="Add to wishlist"><i class="bi bi-heart"></i></button>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <h6 class="fw-700 mb-0">The Grand Palace</h6>
              <span class="rating-badge">4.8 <i class="bi bi-star-fill"></i></span>
            </div>
            <p class="text-muted small mb-2"><i class="bi bi-geo-alt-fill me-1 text-danger"></i>Mumbai, India</p>
            <div class="d-flex gap-1 flex-wrap mb-3">
              <span class="amenity-tag"><i class="bi bi-wifi"></i> WiFi</span>
              <span class="amenity-tag"><i class="bi bi-droplet-fill"></i> Pool</span>
              <span class="amenity-tag"><i class="bi bi-cup-hot"></i> Breakfast</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="text-muted text-decoration-line-through small">₹6,500</span>
                <div class="fw-800 text-primary fs-5">₹4,299<span class="fs-6 fw-400 text-muted">/night</span></div>
              </div>
              <a href="#" class="btn btn-primary btn-sm px-3">Book Now</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Hotel Card 2 -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="hotel-card card border-0 shadow-sm h-100">
          <div class="position-relative">
            <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=400&q=80" class="card-img-top hotel-img" alt="Hotel"/>
            <span class="badge bg-warning text-dark position-absolute top-0 start-0 m-2">Best Seller</span>
            <button class="btn-wishlist" aria-label="Add to wishlist"><i class="bi bi-heart"></i></button>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <h6 class="fw-700 mb-0">Sunset Beach Resort</h6>
              <span class="rating-badge">4.6 <i class="bi bi-star-fill"></i></span>
            </div>
            <p class="text-muted small mb-2"><i class="bi bi-geo-alt-fill me-1 text-danger"></i>Goa, India</p>
            <div class="d-flex gap-1 flex-wrap mb-3">
              <span class="amenity-tag"><i class="bi bi-wifi"></i> WiFi</span>
              <span class="amenity-tag"><i class="bi bi-droplet-fill"></i> Pool</span>
              <span class="amenity-tag"><i class="bi bi-car-front"></i> Parking</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="text-muted text-decoration-line-through small">₹8,000</span>
                <div class="fw-800 text-primary fs-5">₹5,499<span class="fs-6 fw-400 text-muted">/night</span></div>
              </div>
              <a href="#" class="btn btn-primary btn-sm px-3">Book Now</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Hotel Card 3 -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="hotel-card card border-0 shadow-sm h-100">
          <div class="position-relative">
            <img src="https://images.unsplash.com/photo-1520250497591-112f2f40a3f4?w=400&q=80" class="card-img-top hotel-img" alt="Hotel"/>
            <span class="badge bg-danger position-absolute top-0 start-0 m-2">35% OFF</span>
            <button class="btn-wishlist" aria-label="Add to wishlist"><i class="bi bi-heart"></i></button>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <h6 class="fw-700 mb-0">Heritage Haveli</h6>
              <span class="rating-badge">4.9 <i class="bi bi-star-fill"></i></span>
            </div>
            <p class="text-muted small mb-2"><i class="bi bi-geo-alt-fill me-1 text-danger"></i>Jaipur, India</p>
            <div class="d-flex gap-1 flex-wrap mb-3">
              <span class="amenity-tag"><i class="bi bi-wifi"></i> WiFi</span>
              <span class="amenity-tag"><i class="bi bi-cup-hot"></i> Breakfast</span>
              <span class="amenity-tag"><i class="bi bi-fan"></i> AC</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="text-muted text-decoration-line-through small">₹7,200</span>
                <div class="fw-800 text-primary fs-5">₹4,680<span class="fs-6 fw-400 text-muted">/night</span></div>
              </div>
              <a href="#" class="btn btn-primary btn-sm px-3">Book Now</a>
            </div>
          </div>
        </div>
      </div>

      <!-- Hotel Card 4 -->
      <div class="col-12 col-md-6 col-lg-3">
        <div class="hotel-card card border-0 shadow-sm h-100">
          <div class="position-relative">
            <img src="https://images.unsplash.com/photo-1611892440504-42a792e24d32?w=400&q=80" class="card-img-top hotel-img" alt="Hotel"/>
            <span class="badge bg-info text-dark position-absolute top-0 start-0 m-2">New</span>
            <button class="btn-wishlist" aria-label="Add to wishlist"><i class="bi bi-heart"></i></button>
          </div>
          <div class="card-body">
            <div class="d-flex justify-content-between align-items-start mb-1">
              <h6 class="fw-700 mb-0">Mountain View Lodge</h6>
              <span class="rating-badge">4.7 <i class="bi bi-star-fill"></i></span>
            </div>
            <p class="text-muted small mb-2"><i class="bi bi-geo-alt-fill me-1 text-danger"></i>Manali, India</p>
            <div class="d-flex gap-1 flex-wrap mb-3">
              <span class="amenity-tag"><i class="bi bi-wifi"></i> WiFi</span>
              <span class="amenity-tag"><i class="bi bi-fire"></i> Fireplace</span>
              <span class="amenity-tag"><i class="bi bi-cup-hot"></i> Breakfast</span>
            </div>
            <div class="d-flex justify-content-between align-items-center">
              <div>
                <span class="text-muted text-decoration-line-through small">₹5,500</span>
                <div class="fw-800 text-primary fs-5">₹3,299<span class="fs-6 fw-400 text-muted">/night</span></div>
              </div>
              <a href="#" class="btn btn-primary btn-sm px-3">Book Now</a>
            </div>
          </div>
        </div>
      </div>

    </div>
  </div>
</section>

<!-- ========== EXCLUSIVE DEALS ========== -->
<section class="py-5 deals-section text-white">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-800">Exclusive Deals & Offers</h2>
      <p class="opacity-75">Limited time offers — grab them before they're gone</p>
    </div>
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="deal-card p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
              <span class="badge bg-warning text-dark mb-2">Weekend Special</span>
              <h5 class="fw-700">Flat 30% Off on Weekend Stays</h5>
              <p class="opacity-75 small mb-0">Valid on check-ins Fri – Sun. Min. 2 nights.</p>
            </div>
            <i class="bi bi-moon-stars-fill fs-2 text-warning opacity-50"></i>
          </div>
          <div class="d-flex align-items-center gap-2 mt-3">
            <code class="coupon-code">WEEKEND30</code>
            <button class="btn btn-sm btn-outline-light" onclick="copyCode(this, 'WEEKEND30')">Copy</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="deal-card p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
              <span class="badge bg-danger mb-2">Monsoon Sale</span>
              <h5 class="fw-700">Up to 50% Off on Hill Stations</h5>
              <p class="opacity-75 small mb-0">Book by July 31. Travel till Sep 30.</p>
            </div>
            <i class="bi bi-cloud-rain-fill fs-2 text-info opacity-50"></i>
          </div>
          <div class="d-flex align-items-center gap-2 mt-3">
            <code class="coupon-code">MONSOON50</code>
            <button class="btn btn-sm btn-outline-light" onclick="copyCode(this, 'MONSOON50')">Copy</button>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="deal-card p-4">
          <div class="d-flex justify-content-between align-items-start mb-3">
            <div>
              <span class="badge bg-success mb-2">New User</span>
              <h5 class="fw-700">₹1000 Off on First Booking</h5>
              <p class="opacity-75 small mb-0">For new users on bookings above ₹3000.</p>
            </div>
            <i class="bi bi-gift-fill fs-2 text-success opacity-50"></i>
          </div>
          <div class="d-flex align-items-center gap-2 mt-3">
            <code class="coupon-code">FIRST1000</code>
            <button class="btn btn-sm btn-outline-light" onclick="copyCode(this, 'FIRST1000')">Copy</button>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== WHY CHOOSE US ========== -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-800 mb-1">Why Choose bookHotel?</h2>
    <p class="text-muted mb-5">Trusted by 10 million+ travellers worldwide</p>
    <div class="row g-4">
      <div class="col-6 col-md-3">
        <div class="feature-box p-4 h-100">
          <div class="feature-icon mb-3"><i class="bi bi-buildings-fill"></i></div>
          <h6 class="fw-700">1M+ Properties</h6>
          <p class="text-muted small mb-0">Hotels, resorts, villas, homestays across 200+ countries</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="feature-box p-4 h-100">
          <div class="feature-icon mb-3"><i class="bi bi-currency-rupee"></i></div>
          <h6 class="fw-700">Best Prices</h6>
          <p class="text-muted small mb-0">Price match guarantee. Pay less, experience more</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="feature-box p-4 h-100">
          <div class="feature-icon mb-3"><i class="bi bi-phone-fill"></i></div>
          <h6 class="fw-700">Easy Booking</h6>
          <p class="text-muted small mb-0">Book in under 2 minutes on web or mobile app</p>
        </div>
      </div>
      <div class="col-6 col-md-3">
        <div class="feature-box p-4 h-100">
          <div class="feature-icon mb-3"><i class="bi bi-stars"></i></div>
          <h6 class="fw-700">Verified Reviews</h6>
          <p class="text-muted small mb-0">Authentic reviews from verified guests only</p>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== TESTIMONIALS ========== -->
<section class="py-5 bg-white">
  <div class="container">
    <div class="text-center mb-5">
      <h2 class="fw-800 mb-1">What Guests Say</h2>
      <p class="text-muted">Real experiences from real travellers</p>
    </div>
    <div class="row g-4">
      <div class="col-12 col-md-4">
        <div class="review-card p-4 h-100">
          <div class="d-flex gap-1 text-warning mb-3">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
          </div>
          <p class="text-muted mb-4">"Absolutely seamless experience! Found a great hotel in Goa at half the price I saw elsewhere. The check-in was smooth and the room was exactly as shown."</p>
          <div class="d-flex align-items-center gap-3">
            <img src="https://i.pravatar.cc/48?img=5" class="rounded-circle" width="48" height="48" alt="Priya S"/>
            <div>
              <div class="fw-700 small">Priya Sharma</div>
              <div class="text-muted" style="font-size:0.75rem">Mumbai · Goa Trip</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="review-card p-4 h-100">
          <div class="d-flex gap-1 text-warning mb-3">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-half"></i>
          </div>
          <p class="text-muted mb-4">"Used the MONSOON50 coupon and saved over ₹3,000 on my Manali trip. Customer support was super responsive when I needed to change dates."</p>
          <div class="d-flex align-items-center gap-3">
            <img src="https://i.pravatar.cc/48?img=12" class="rounded-circle" width="48" height="48" alt="Rahul V"/>
            <div>
              <div class="fw-700 small">Rahul Verma</div>
              <div class="text-muted" style="font-size:0.75rem">Delhi · Manali Trip</div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-12 col-md-4">
        <div class="review-card p-4 h-100">
          <div class="d-flex gap-1 text-warning mb-3">
            <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
          </div>
          <p class="text-muted mb-4">"Heritage Haveli in Jaipur was a dream. bookHotel's photos were accurate, the deal was incredible, and the booking process took less than 3 minutes!"</p>
          <div class="d-flex align-items-center gap-3">
            <img src="https://i.pravatar.cc/48?img=21" class="rounded-circle" width="48" height="48" alt="Ananya K"/>
            <div>
              <div class="fw-700 small">Ananya Kapoor</div>
              <div class="text-muted" style="font-size:0.75rem">Bangalore · Jaipur Trip</div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== APP DOWNLOAD ========== -->
<section class="py-5 app-section">
  <div class="container">
    <div class="row align-items-center g-4">
      <div class="col-12 col-md-7">
        <span class="badge bg-warning text-dark mb-3">Mobile App</span>
        <h2 class="fw-800 mb-3">Book Hotels On the Go</h2>
        <p class="text-muted mb-4">Download the bookHotel app for exclusive app-only deals, instant notifications, and one-tap booking. Available on iOS and Android.</p>
        <div class="d-flex gap-3 flex-wrap">
          <a href="#" class="app-btn d-flex align-items-center gap-2">
            <i class="bi bi-apple fs-4"></i>
            <div class="text-start">
              <div style="font-size:0.65rem" class="opacity-75">Download on the</div>
              <div class="fw-700 small">App Store</div>
            </div>
          </a>
          <a href="#" class="app-btn d-flex align-items-center gap-2">
            <i class="bi bi-google-play fs-4"></i>
            <div class="text-start">
              <div style="font-size:0.65rem" class="opacity-75">Get it on</div>
              <div class="fw-700 small">Google Play</div>
            </div>
          </a>
        </div>
      </div>
      <div class="col-12 col-md-5 text-center">
        <div class="app-mockup mx-auto">
          <div class="phone-frame">
            <div class="phone-screen">
              <div class="p-3 text-start">
                <div class="d-flex align-items-center gap-2 mb-3">
                  <i class="bi bi-building-fill text-warning"></i>
                  <span class="fw-700 small">bookHotel</span>
                </div>
                <div class="bg-white rounded-3 p-2 mb-2 shadow-sm">
                  <div class="text-muted" style="font-size:0.6rem">WHERE</div>
                  <div class="fw-600" style="font-size:0.75rem">Goa, India</div>
                </div>
                <div class="row g-1 mb-2">
                  <div class="col-6 bg-white rounded-3 p-2 shadow-sm">
                    <div class="text-muted" style="font-size:0.6rem">CHECK-IN</div>
                    <div class="fw-600" style="font-size:0.7rem">Fri, Jul 4</div>
                  </div>
                  <div class="col-6 bg-white rounded-3 p-2 shadow-sm">
                    <div class="text-muted" style="font-size:0.6rem">CHECK-OUT</div>
                    <div class="fw-600" style="font-size:0.7rem">Sun, Jul 6</div>
                  </div>
                </div>
                <button class="btn btn-warning w-100 btn-sm fw-700" style="font-size:0.7rem">Search Hotels</button>
                <div class="mt-2 bg-white rounded-3 p-2 shadow-sm d-flex gap-2 align-items-center">
                  <img src="https://images.unsplash.com/photo-1571003123894-1f0594d2b5d9?w=60&q=80" width="36" height="36" class="rounded-2 object-fit-cover" alt="hotel"/>
                  <div>
                    <div class="fw-600" style="font-size:0.65rem">Sunset Beach Resort</div>
                    <div class="text-warning" style="font-size:0.6rem">★ 4.6 · ₹5,499/night</div>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ========== NEWSLETTER ========== -->
<section class="py-5 bg-primary text-white text-center">
  <div class="container">
    <div class="col-12 col-md-6 mx-auto">
      <i class="bi bi-envelope-fill fs-2 mb-3"></i>
      <h3 class="fw-800 mb-2">Get the Best Deals in Your Inbox</h3>
      <p class="opacity-75 mb-4">Subscribe to our newsletter and never miss an exclusive hotel offer.</p>
      <div class="input-group input-group-lg">
        <input type="email" class="form-control border-0" placeholder="Enter your email address" aria-label="Email"/>
        <button class="btn btn-warning fw-700 px-4">Subscribe</button>
      </div>
      <p class="mt-2 opacity-50" style="font-size:0.75rem">No spam, unsubscribe at any time.</p>
    </div>
  </div>
</section>

<!-- ========== FOOTER ========== -->
<footer class="bg-dark text-white pt-5 pb-3">
  <div class="container">
    <div class="row g-4 mb-4">
      <div class="col-12 col-md-4">
        <h5 class="fw-800 mb-3"><i class="bi bi-building-fill text-warning me-1"></i>bookHotel</h5>
        <p class="text-white-50 small">Your trusted travel partner since 2015. We make hotel booking simple, affordable, and enjoyable for millions of travellers.</p>
        <div class="d-flex gap-3 mt-3">
          <a href="#" class="text-white-50 social-icon"><i class="bi bi-facebook fs-5"></i></a>
          <a href="#" class="text-white-50 social-icon"><i class="bi bi-twitter-x fs-5"></i></a>
          <a href="#" class="text-white-50 social-icon"><i class="bi bi-instagram fs-5"></i></a>
          <a href="#" class="text-white-50 social-icon"><i class="bi bi-youtube fs-5"></i></a>
          <a href="#" class="text-white-50 social-icon"><i class="bi bi-linkedin fs-5"></i></a>
        </div>
      </div>
      <div class="col-6 col-md-2">
        <h6 class="fw-700 mb-3">Company</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="#">About Us</a></li>
          <li><a href="#">Careers</a></li>
          <li><a href="#">Press</a></li>
          <li><a href="#">Blog</a></li>
          <li><a href="#">Partners</a></li>
        </ul>
      </div>
      <div class="col-6 col-md-2">
        <h6 class="fw-700 mb-3">Support</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="#">Help Center</a></li>
          <li><a href="#">Contact Us</a></li>
          <li><a href="#">Cancellation Policy</a></li>
          <li><a href="#">Safety Info</a></li>
          <li><a href="#">Report Issue</a></li>
        </ul>
      </div>
      <div class="col-6 col-md-2">
        <h6 class="fw-700 mb-3">Explore</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="#">Hotels</a></li>
          <li><a href="#">Flights</a></li>
          <li><a href="#">Packages</a></li>
          <li><a href="#">Train Booking</a></li>
          <li><a href="#">Car Rentals</a></li>
        </ul>
      </div>
      <div class="col-6 col-md-2">
        <h6 class="fw-700 mb-3">Legal</h6>
        <ul class="list-unstyled footer-links">
          <li><a href="#">Privacy Policy</a></li>
          <li><a href="#">Terms of Use</a></li>
          <li><a href="#">Cookie Policy</a></li>
          <li><a href="#">Sitemap</a></li>
        </ul>
      </div>
    </div>
    <hr class="border-secondary"/>
    <div class="d-flex flex-column flex-md-row justify-content-between align-items-center gap-2">
      <p class="text-white-50 small mb-0">© <?php echo $current_year; ?> bookHotel Technologies Pvt. Ltd. All rights reserved.</p>
      <div class="d-flex gap-2">
        <img src="https://img.shields.io/badge/Visa-1A1F71?style=flat&logo=visa&logoColor=white" height="20" alt="Visa"/>
        <img src="https://img.shields.io/badge/Mastercard-EB001B?style=flat&logo=mastercard&logoColor=white" height="20" alt="Mastercard"/>
        <img src="https://img.shields.io/badge/UPI-1a73e8?style=flat&logo=google-pay&logoColor=white" height="20" alt="UPI"/>
        <img src="https://img.shields.io/badge/PayPal-003087?style=flat&logo=paypal&logoColor=white" height="20" alt="PayPal"/>
      </div>
    </div>
  </div>
</footer>

<!-- Back to top -->
<button id="backToTop" class="btn btn-warning btn-sm rounded-circle shadow" aria-label="Back to top" onclick="window.scrollTo({top:0,behavior:'smooth'})">
  <i class="bi bi-arrow-up"></i>
</button>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script>
  // Copy coupon code
  function copyCode(btn, code) {
    navigator.clipboard.writeText(code);
    btn.textContent = 'Copied!';
    setTimeout(() => btn.textContent = 'Copy', 2000);
  }

  // Navbar scroll effect
  window.addEventListener('scroll', () => {
    const nav = document.getElementById('mainNav');
    nav.classList.toggle('scrolled', window.scrollY > 50);
    document.getElementById('backToTop').classList.toggle('show', window.scrollY > 300);
  });

  // Wishlist toggle
  document.querySelectorAll('.btn-wishlist').forEach(btn => {
    btn.addEventListener('click', () => {
      const icon = btn.querySelector('i');
      icon.classList.toggle('bi-heart');
      icon.classList.toggle('bi-heart-fill');
      icon.classList.toggle('text-danger');
    });
  });

  // Set default dates — handled server-side by PHP (see top of file)
</script>
</body>
</html>
