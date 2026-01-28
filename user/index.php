<?php
require_once 'config.php';


// Get all races
$pdo = getDBConnection();
$stmt = $pdo->query("SELECT * FROM races ORDER BY race_date ASC");
$races = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>F1 Race - index</title>
  <link rel="icon" href="images/nav_icon.png" type="image/png">
  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
  <header>
    <nav class="navbar">
      <div class="nav-container">
        <div class="logo">
          <a href="index.php">
            <img src="images/main_logo.png" alt="F1 Hero" height="70px" width="80px" object-fit="cover">
          </a>
        </div>
        <ul class="nav-menu">
          <li><a href="index.php">Home</a></li>
          <li><a href="About.php">About us</a></li>
          <li><a href="driver.php">Driver</a></li>
          <li><a href="team.php">Team</a></li>
          <li><a href="races.php">Races</a></li>


          <?php if (isLoggedIn()): ?>
            <li><a href="bookings.php">My Bookings</a></li>
            <?php if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1): ?>
              <li><a href="admin_panel.php">Admin Panel</a></li>
            <?php endif; ?>
            <li><a href="logout.php">Logout</a></li>
            <?php
            $user = getCurrentUser();
            ?>
            <li class="user-info">
              Welcome, <?php echo $user && isset($user['full_name']) ? htmlspecialchars($user['full_name']) : 'Guest'; ?>
            </li>

          <?php else: ?>
            <li><a href="login.php">Login</a></li>
          <?php endif; ?>
        </ul>
      </div>
    </nav>
  </header>

  <main>
    <!-- Hero Section Start -->
    <section class="hero-section"
      style=" color: #f4f6fb; padding: 15rem 0 15rem 0; text-align: center; position: relative; overflow: hidden;">
      <img src="images/f1.jpg" alt="Background" style="
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      object-fit: cover;
      z-index: 0;
      filter: brightness(0.4);
    ">
      <div class="container" style="position: relative; z-index: 1;">
        <h2 style="font-size: 2.8rem; font-weight: 700; margin-bottom: 1rem; color: #f4f6fb;">Experience the Thrill of
          Formula 1 Live!</h2>
        <p style="font-size: 1.3rem; margin-bottom: 2rem; color: #b0b8c1;">Book your tickets for the most electrifying
          races around the globe. Secure your seat now and be part of the action!</p>
        <a href="races.php" class="cta-button" style="font-size: 1.2rem;">Book Tickets</a>
      </div>
    </section>
    <!-- Hero Section End -->

    <!-- Upcoming Races Preview Start -->
    <section class="upcoming-races" style=" background-color: #232526; padding: 3rem 0;">
      <div class="container">
        <h2
          style="text-align:center; color:#f4f6fb; margin-bottom:2rem; font-family: UngapBlocks; margin-right: 72%; font-size: 50px;">
          Upcoming Races
        </h2>
        <div class="races-grid">

          <!-- Race Card 1 -->
          <div class="race-card">
            <div class="race-image"><img src="images/uprace1.jpg" alt="Race"></div>
            <div class="race-info">
              <h3>Monaco Grand Prix</h3>
              <div class="track">Track: Circuit de Monaco</div>
              <div class="location">Location: Monte Carlo, Monaco</div>
            </div>
          </div>

          <!-- Race Card 2 -->
          <div class="race-card">
            <div class="race-image"><img src="images//uprace2.jpg" alt="Race"></div>
            <div class="race-info">
              <h3>British Grand Prix</h3>
              <div class="track">Track: Silverstone Circuit</div>
              <div class="location">Location: Silverstone, UK</div>
            </div>
          </div>

          <!-- Race Card 3 -->
          <div class="race-card">
            <div class="race-image"><img src="images//uprace3.jpg" alt="Race"></div>
            <div class="race-info">
              <h3>Italian Grand Prix</h3>
              <div class="track">Track: Monza Circuit</div>
              <div class="location">Location: Monza, Italy</div>
            </div>
          </div>

          <!-- Race Card 4 -->
          <div class="race-card">
            <div class="race-image"><img src="images//uprace4.jpg" alt="Race"></div>
            <div class="race-info">
              <h3>Singapore Grand Prix</h3>
              <div class="track">Track: Marina Bay Street Circuit</div>
              <div class="location">Location: Singapore</div>
            </div>
          </div>

          <!-- Race Card 5 -->
          <div class="race-card">
            <div class="race-image"><img src="images//uprace5.jpg" alt="Race"></div>
            <div class="race-info">
              <h3>Japanese Grand Prix</h3>
              <div class="track">Track: Suzuka Circuit</div>
              <div class="location">Location: Suzuka, Japan</div>
            </div>
          </div>

          <!-- Race Card 6 -->
          <div class="race-card">
            <div class="race-image"><img src="images//uprace6.jpg" alt="Race"></div>
            <div class="race-info">
              <h3>Abu Dhabi Grand Prix</h3>
              <div class="track">Track: Yas Marina Circuit</div>
              <div class="location">Location: Abu Dhabi, UAE</div>
            </div>
          </div>
        </div>
      </div>
      <div style="text-align: center; margin-top: 2rem;">
        <a href="races.php" class="book-button" style="padding: 0.8rem 3rem;background-color: #00fff7;color: #000;font-weight: bold;
    border-radius: 8px;text-decoration: none;font-family: 'UngapBlocks', sans-serif;font-size: 18px;box-shadow: 0 0 10px #00fff7;transition: background-color 0.3s, color 0.3s;
  ">All the races →</a>
      </div>

    </section>

    <!-- Upcoming Races Preview End -->

    <!-- Features Section Start -->
    <section class="features" style="position: relative;">
      <div class="container">
        <h2 style="margin-right: 70%; font-size: 50px; font-family: UngapBlocks; width: max-content;">Why Choose F1
          Tickets?</h2>
        <div class="features-grid">
          <div class="feature">
            <h3>🏁 Premium Experience</h3>
            <p>Get the best seats for Formula 1 races with our premium ticket options</p>
          </div>
          <div class="feature">
            <h3>🎫 Easy Booking</h3>
            <p>Simple and secure online booking process with instant confirmation</p>
          </div>
          <div class="feature">
            <h3>🌍 Global Coverage</h3>
            <p>Access to all Formula 1 races around the world</p>
          </div>
          <div class="feature">
            <h3>💳 Secure Payment</h3>
            <p>Safe and encrypted payment processing for peace of mind</p>
          </div>
        </div>
      </div>
    </section>
    <!-- Features Section End -->

    <!-- About section -->
    <section
      style="position: relative;background-color: #1c1c1e; color: #f4f6fb; padding: 2.5rem 5rem; font-family: 'Roboto', sans-serif;margin: auto;">
      <h2 style="font-size: 2rem; text-align: center; margin-bottom: 1rem;">🏁 About Us</h2>
      <p style="font-size: 1.05rem; margin-bottom: 1.5rem; text-align: center;">
        <strong>F1 Tickets</strong> is your ultimate destination for live Formula 1 experiences. From booking official
        race tickets to arranging travel and accommodation, we make it easy for fans to be part of the world’s fastest
        motorsport.
      </p>

      <h3 style="font-size: 1.3rem; margin-top: 1.5rem;">🚀 What We Offer</h3>
      <p style="font-size: 1.05rem; margin-bottom: 1.5rem;">
        We provide a complete Formula 1 experience — including race ticket reservations, hotel and travel packages,
        secure payment options, and instant digital ticket delivery. Whether you’re attending your first race or your
        tenth, we make every step simple and exciting.
      </p>

      <h3 style="font-size: 1.3rem; margin-top: 1.8rem;">🌍 Our Vision</h3>
      <p style="font-size: 1.05rem; margin-bottom: 1.5rem;">
        We believe that every fan should have the chance to feel the roar of the engines and the rush of the crowd — no
        matter where they are in the world. Our vision is to make live F1 races accessible, affordable, and
        unforgettable.
      </p>

      <h3 style="font-size: 1.3rem; margin-top: 1.8rem;">👥 Be Part of It</h3>
      <p style="font-size: 1.05rem;">
        Join thousands of racing fans who trust F1 Tickets for their motorsport adventures. Stay updated with race
        alerts, behind-the-scenes content, and exclusive deals. The race is on — don’t miss it!
      </p>
      <a href="about.php" class="book-button" style="margin-top: 20px; display: inline-block;">Read more</a>


    </section>


    <!-- Testimonials Section Start -->
    <section class="reachout-slider-section"
      style="background: #181818; color: #fff; padding: 4rem 0;    position: relative;">
      <div class="container">
        <h2
          style="text-align:center; color:#f4f6fb; font-family: UngapBlocks; margin-bottom:2.5rem; margin-right: 75% ;font-size: 50px;">
          What
          Fans Say</h2>
        <div class="reachout-slider-wrapper" style="overflow:hidden;">
          <div class="reachout-slider-track" id="reachoutCarousel"
            style="display:flex; gap:2rem; will-change:transform;">
            <?php
            require_once 'config.php';
            $messages = fetchAllMessages();
            if (count($messages) > 0):
              // Duplicate the messages for seamless looping
              $allMsgs = array_merge($messages, $messages);
              foreach ($allMsgs as $msg):
                ?>
                <div class="reachout-card"
                  style="min-width:320px; background:#222; border-radius:1rem; padding:2rem; box-shadow:0 2px 8px #0002;">
                  <p>“<?php echo htmlspecialchars($msg['message']); ?>”</p>
                  <div style="margin-top:1rem; font-weight:500; color:#ffd700;">—
                    <?php echo htmlspecialchars($msg['name']); ?>
                  </div>
                </div>
              <?php endforeach; else: ?>
              <div style="color:#ccc; font-style:italic;">No feedback yet. Be the first to leave one!</div>
            <?php endif; ?>
          </div>
        </div>
      </div>
    </section>


    <!-- Testimonials Section End -->

    <!-- DRIVERS Section Start -->
    <section class="gallery-highlights"
      style="background: #121212; padding: 4rem 0; width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw;">
      <h2
        style="text-align:center; color:#f4f6fb; font-family: UngapBlocks; margin-bottom:2.5rem; letter-spacing:2px;margin-right: 70% ;font-size: 50px;">
        DRIVERS</h2>
      <div class="drivers-slider-wrapper" style="position:relative; max-width:1300px; margin:0 auto; overflow:hidden;">
        <div class="drivers-slider-track" id="drivers-slider-track"
          style="display:flex; gap:2rem; padding-bottom:10px; will-change:transform;">
          <!-- Driver cards duplicated for seamless loop -->
          <!-- First set -->
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver1.jpg" alt="oscar piastri"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Oscar Piastri</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver2.jpg" alt="lando norris"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Lando Norris</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver3.jpg" alt="charles leclerc"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Charles Leclerc</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver4.jpg" alt="lewis hamilton"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Lewis Hamilton</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver5.jpg" alt="george russell"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">George Russell</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver6.jpg" alt="kimi antonelli "
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Kimi Antonelli </div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver7.jpg" alt="nico hulkenberg"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Nico Hulkenberg</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver8.jpg" alt="lourenzo bortoleto"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Lourenzo Bortoleto</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver9.jpg" alt="esteban ocon"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Esteban Ocon</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver10.jpg" alt="oliver bearman"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Oliver Bearman</div>
          </div>
          <!-- Second set (duplicate) -->
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver1.jpg" alt="oscar piastri"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Oscar Piastri</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver2.jpg" alt="lando norris"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Lando Norris</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver3.jpg" alt="charles leclerc"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Charles Leclerc</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver4.jpg" alt="lewis hamilton"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Lewis Hamilton</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver5.jpg" alt="george russell"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">George Russell</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver6.jpg" alt="kimi antonelli "
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Kimi Antonelli </div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver7.jpg" alt="nico hulkenberg"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Nico Hulkenberg</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver8.jpg" alt="lourenzo bortoleto"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Lourenzo Bortoleto</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver9.jpg" alt="esteban ocon"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Esteban Ocon</div>
          </div>
          <div style="text-align:center; min-width:320px; flex:0 0 320px;">
            <img src="images/driver10.jpg" alt="oliver bearman"
              style="width:90%; height: 400px; border-radius:18px; box-shadow:0 4px 24px rgba(41,121,255,0.12); object-fit:cover; aspect-ratio:16/9;">
            <div style="color:#f4f6fb; margin-top:0.5rem; font-weight:600;">Oliver Bearman</div>
          </div>
        </div>
      </div>
    </section>
    <!-- DRIVERS Section End -->

    <!-- Car Gallery Slider Section Start -->
    <section class="car-gallery-slider" style="background: #181818; padding: 3rem 0;    position: relative;">
      <div class="container">
        <h2
          style="text-align:center;font-family: UngapBlocks; color:#f4f6fb; margin-bottom:2rem; margin-right: 70%;font-size: 50px;">
          F1 Car Gallery
        </h2>
        <div class="car-slider-wrapper" style="position:relative; max-width:1300px; margin:0 auto; overflow:hidden;">
          <button class="car-slider-arrow left" id="car-slider-left"
            style="position:absolute; top:50%; transform:translateY(-50%); left:-50px; z-index:10; background:rgba(0,0,0,0.5); border:none; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#f4f6fb; font-size:24px;">&larr;</button>
          <div class="car-slider-track" id="car-slider-track"
            style="display:flex; overflow-x:auto; scroll-behavior:smooth; gap:1.5rem; padding-bottom:10px;">
            <img src="images/car2.jpg" alt="Car 2"
              style="height:410px; padding: 55px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.18); flex:0 0 auto;">
            <img src="images/car3.jpg" alt="Car 3"
              style="height:410px; padding: 55px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.18); flex:0 0 auto;">
            <img src="images/car4.jpg" alt="Car 4"
              style="height:410px; padding: 55px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.18); flex:0 0 auto;">
            <img src="images/car5.jpg" alt="Car 5"
              style="height:410px; padding: 55px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.18); flex:0 0 auto;">
            <img src="images/car6.jpg" alt="Car 6"
              style="height:410px; padding: 55px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.18); flex:0 0 auto;">
            <img src="images/car7.jpg" alt="Car 7"
              style="height:410px; padding: 55px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.18); flex:0 0 auto;">
            <img src="images/car8.jpg" alt="Car 8"
              style="height:410px; padding: 55px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.18); flex:0 0 auto;">
            <img src="images/car9.jpg" alt="Car 9"
              style="height:410px; padding: 55px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.18); flex:0 0 auto;">
            <img src="images/car10.jpg" alt="Car 10"
              style="height:410px; padding: 55px; border-radius:12px; box-shadow:0 2px 12px rgba(0,0,0,0.18); flex:0 0 auto;">
          </div>
          <button class="car-slider-arrow right" id="car-slider-right"
            style="position:absolute; top:50%; transform:translateY(-50%); right:-50px; z-index:10; background:rgba(0,0,0,0.5); border:none; border-radius:50%; width:40px; height:40px; display:flex; align-items:center; justify-content:center; cursor:pointer; color:#f4f6fb; font-size:24px;">&rarr;</button>
        </div>
      </div>
    </section>
    <!-- Car Gallery Slider Section End -->


    <!-- 2025 SEASON Drivers & Teams Leaderboard Start -->
    <section
      style="background: #181820; padding: 4rem 0 6rem 0; width: 100vw; position: relative; left: 50%; right: 50%; margin-left: -50vw; margin-right: -50vw;">
      <div style="max-width: 1400px; margin: 0 auto;">
        <h2
          style="color: #fff; font-size: 3rem; font-weight: 900; font-family: UngapBlocks; letter-spacing: 2px; margin-bottom: 2rem;">
          2025 SEASON</h2>
        <div style="gap: 2.5rem;  margin-bottom: 2.5rem;">
          <span id="drivers-tab" class="season-tab active"
            style="color: #fff; font-size: 1.4rem; font-weight: 700; border-bottom: 4px solid #ff1e1e; padding-bottom: 0.2rem; margin-right: 2.5rem; cursor:pointer;">DRIVERS</span>
          <span id="teams-tab" class="season-tab"
            style="color: #b0b8c1; font-size: 1.2rem; font-weight: 500; cursor:pointer;">TEAMS</span>
        </div>
        <!-- Drivers Leaderboard -->
        <div id="drivers-leaderboard">
          <div style="display: flex; gap: 2.5rem; justify-content: center; flex-wrap: wrap;">
            <!-- 2nd Place -->
            <div class="winersection"
              style="background: linear-gradient(120deg, #ff8000 60%, #b85c00 100%); border-radius: 18px; min-width: 370px; max-width: 400px; flex: 1 1 370px; padding: 2.5rem 2rem 1.5rem 2rem; margin-top: 25px; position: relative; display: flex; flex-direction: column; align-items: flex-start; box-shadow: 0 4px 32px rgba(0,0,0,0.18);border: 3px solid #fff; transition: border-color 0.3s ease, transform 0.3s ease; ">
              <div style="font-size: 2.1rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem;">2<sup
                  style='font-size:1rem;'>ND</sup></div>
              <div class="winername" style="font-size: 2rem; font-weight: 700; color: #fff; margin-bottom: 0.2rem;">
                Lando <span style='color:#fff;'>Norris</span></div>
              <div style="font-size: 1.1rem; color: #fff; margin-bottom: 0.5rem;">McLaren</div>
              <img src="images/2025-1.png" alt="Lando Norris"
                style="position: absolute; right: 0.5rem; bottom: 1.5rem; height: 220px; border-radius: 12px; object-fit: cover;">
              <div style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.7rem;">
                <img src="https://flagcdn.com/gb.svg" alt="UK" style="width: 28px; height: 20px; border-radius: 3px;">
              </div>
              <div style="font-size: 2rem; font-weight: 900; color: #fff; margin-top: 2.5rem;">226 <span
                  style="font-size:1.1rem; font-weight:600;">PTS</span></div>
            </div>
            <!-- 1st Place -->
            <div class="winersection"
              style="background: linear-gradient(120deg, #ff8000 60%, #b85c00 100%); border-radius: 18px; min-width: 370px; max-width: 400px; flex: 1 1 370px; padding: 2.5rem 2rem 1.5rem 2rem; position: relative; display: flex; flex-direction: column; align-items: flex-start; box-shadow: 0 4px 32px rgba(0,0,0,0.18);z-index: 2;border: 3px solid #fff; transition: border-color 0.3s ease, transform 0.3s ease; ">
              <div style="font-size: 2.1rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem;">1<sup
                  style='font-size:1rem;'>ST</sup></div>
              <div class="winername" style="font-size: 2rem; font-weight: 700; color: #fff; margin-bottom: 0.2rem;">
                Oscar <span style='color:#fff;'>Piastri</span></div>
              <div style="font-size: 1.1rem; color: #fff; margin-bottom: 0.5rem;">McLaren</div>
              <img src="images/2025-3.png" alt="Oscar Piastri"
                style="position: absolute; right: 1.5rem; bottom: 1.5rem; height: 260px; border-radius: 12px;  object-fit: cover;">
              <div style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.7rem;">
                <img src="https://flagcdn.com/au.svg" alt="Australia"
                  style="width: 28px; height: 20px; border-radius: 3px;">
              </div>
              <div style="font-size: 2rem; font-weight: 900; color: #fff; margin-top: 2.5rem;">324 <span
                  style="font-size:1.1rem; font-weight:600;">PTS</span></div>
            </div>
            <!-- 3rd Place -->
            <div class="winersection"
              style="background: linear-gradient(120deg, #1e3c72 60%, #2a5298 100%); border-radius: 18px; min-width: 370px; max-width: 400px; flex: 1 1 370px; padding: 2.5rem 2rem 1.5rem 2rem; position: relative; display: flex; flex-direction: column; align-items: flex-start; margin-top: 50px; box-shadow: 0 4px 32px rgba(0,0,0,0.18);border: 3px solid #fff; transition: border-color 0.3s ease, transform 0.3s ease; ">
              <div style="font-size: 2.1rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem;">3<sup
                  style='font-size:1rem;'>RD</sup></div>
              <div class="winername" style="font-size: 2rem; font-weight: 700; color: #fff; margin-bottom: 0.2rem;">Max
                <span style='color:#fff;'>Verstappen</span>
              </div>
              <div style="font-size: 1.1rem; color: #fff; margin-bottom: 0.5rem;">Red Bull Racing</div>
              <img src="images/2025-2.png" alt="Max Verstappen"
                style="position: absolute; right: -0.5rem; bottom: 1.5rem; height: 210px; border-radius: 12px;object-fit: cover;">
              <div style="margin-top: 1.5rem; display: flex; align-items: center; gap: 0.7rem;">
                <img src="https://flagcdn.com/nl.svg" alt="Netherlands"
                  style="width: 28px; height: 20px; border-radius: 3px;">
              </div>
              <div style="font-size: 2rem; font-weight: 900; color: #fff; margin-top: 2.5rem;">165 <span
                  style="font-size:1.1rem; font-weight:600;">PTS</span></div>
            </div>
          </div>
        </div>
        <!-- Teams Leaderboard (hidden by default) -->
        <div id="teams-leaderboard" style="display:none;">
          <div style="display: flex; gap: 2.5rem; justify-content: center; flex-wrap: wrap;">
            <!-- 2nd Place -->
            <div class="winersection"
              style="background: linear-gradient(120deg, #b31217 60%, #e52d27 100%); border-radius: 18px; min-width: 370px; max-width: 400px; flex: 1 1 370px; padding: 2.5rem 2rem 1.5rem 2rem;margin-top: 25px; position: relative; display: flex; flex-direction: column; align-items: flex-start; box-shadow: 0 4px 32px rgba(0,0,0,0.18);border: 3px solid #fff; transition: border-color 0.3s ease, transform 0.3s ease; ">
              <div style="font-size: 2.1rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem;">2<sup
                  style='font-size:1rem;'>ND</sup></div>
              <div class="winername"
                style="font-size: 2rem; font-weight: 700; color: #fff; margin-bottom: 0.2rem; font-family: 'Roboto', sans-serif;">
                Ferrari</div>
              <div style="font-size: 2rem; font-weight: 900; color: #fff; margin-bottom: 0.2rem;">222 <span
                  style='font-size:1.1rem; font-weight:600;'>PTS</span></div>
              <div style="font-size: 1.1rem; color: #fff; margin-bottom: 0.5rem;">Charles <span
                  style='font-weight:700;'>Leclerc</span><br>Lewis <span style='font-weight:700;'>Hamilton</span></div>
              <img src="images/ferrari.png" alt="Ferrari Logo"
                style="position: absolute; right: 1.5rem; top: 1.5rem; width: 48px; height: 48px; border-radius: 50%; background: #fff; padding: 4px;">
              <img src="images/car4.jpg" alt="Ferrari Car"
                style="width: 100%; margin-top: 2.5rem; border-radius: 0 0 12px 12px; object-fit: contain;">
            </div>
            <!-- 1st Place -->
            <div class="winersection"
              style="background: linear-gradient(120deg, #ff8000 60%, #b85c00 100%); border-radius: 18px; min-width: 370px; max-width: 400px; flex: 1 1 370px; padding: 2.5rem 2rem 1.5rem 2rem; position: relative; display: flex; flex-direction: column; align-items: flex-start; box-shadow: 0 4px 32px rgba(0,0,0,0.18); z-index: 2; border: 3px solid #fff; transition: border-color 0.3s ease, transform 0.3s ease; ">
              <div style="font-size: 2.1rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem;">1<sup
                  style='font-size:1rem;'>ST</sup></div>
              <div class="winername"
                style="font-size: 2rem; font-weight: 700; color: #fff; margin-bottom: 0.2rem; font-family: 'Roboto', sans-serif;">
                McLaren</div>
              <div style="font-size: 2rem; font-weight: 900; color: #fff; margin-bottom: 0.2rem;">460 <span
                  style='font-size:1.1rem; font-weight:600;'>PTS</span></div>
              <div style="font-size: 1.1rem; color: #fff; margin-bottom: 0.5rem;">Oscar <span
                  style='font-weight:700;'>Piastri</span><br>Lando <span style='font-weight:700;'>Norris</span></div>
              <img src="images/McLaren.png" alt="McLaren Logo"
                style="position: absolute; right: 1.5rem; top: 1.5rem; width: 48px; height: 48px; border-radius: 50%; background: #fff; padding: 8px;">
              <img src="images/car1.jpg" alt="McLaren Car"
                style="width: 100%; margin-top: 2.5rem; border-radius: 0 0 12px 12px; object-fit: contain;">
            </div>
            <!-- 3rd Place -->
            <div class="winersection"
              style="background: linear-gradient(120deg, #11998e 60%, #38ef7d 100%); border-radius: 18px; min-width: 370px; max-width: 400px; flex: 1 1 370px; padding: 2.5rem 2rem 1.5rem 2rem; margin-top: 50px;position: relative; display: flex; flex-direction: column; align-items: flex-start; box-shadow: 0 4px 32px rgba(0,0,0,0.18);border: 3px solid #fff; transition: border-color 0.3s ease, transform 0.3s ease; ">
              <div style="font-size: 2.1rem; font-weight: 900; color: #fff; margin-bottom: 0.5rem;">3<sup
                  style='font-size:1rem;'>RD</sup></div>
              <div class="winername"
                style="font-size: 2rem; font-weight: 700; color: #fff; margin-bottom: 0.2rem; font-family: 'Roboto', sans-serif;">
                Mercedes</div>
              <div style="font-size: 2rem; font-weight: 900; color: #fff; margin-bottom: 0.2rem;">210 <span
                  style='font-size:1.1rem; font-weight:600;'>PTS</span></div>
              <div style="font-size: 1.1rem; color: #fff; margin-bottom: 0.5rem;">George <span
                  style='font-weight:700;'>Russell</span><br>Kimi <span style='font-weight:700;'>Antonelli</span></div>
              <img src="images/Mercedes.png" alt="Mercedes Logo"
                style="position: absolute; right: 1.5rem; top: 1.5rem; width: 48px; height: 48px; border-radius: 50%; background: #fff; padding: 4px;">
              <img src="images/car7.jpg" alt="Mercedes Car"
                style="width: 100%; margin-top: 2.5rem; border-radius: 0 0 12px 12px; object-fit: contain;">
            </div>
          </div>
        </div>
      </div>
    </section>
    <!-- 2025 SEASON Drivers & Teams Leaderboard End -->

    <!-- Partners/Sponsors Section Start -->
    <section class="partners-sponsors"
      style="background: #121212; padding: 2.5rem 0; border-top: 1px solid #23283b;     position: relative;">
      <div class="container-fluid">
        <h2
          style="text-align:center; font-family: UngapBlocks; color:#f4f6fb; margin-bottom:3rem; margin-right: 70% ;font-size: 50px;">
          Our
          Partners</h2>

        <div class="partners-logos-row"
          style="display: flex; flex-wrap: nowrap; overflow-x: auto; gap: 20px; margin-left: 80px; justify-content: flex-start; padding: 0 1rem;">
          <img src="images/Partners1.jpg" alt="Partners logo" style="height: 30px; margin-right: 10px;">
          <img src="images/Partners2.jpg" alt="Partners logo" style="height: 30px; margin-right: 10px;">
          <img src="images/Partners3.jpg" alt="Partners logo" style="height: 30px; margin-right: 10px;">
          <img src="images/Partners4.jpg" alt="Partners logo" style="height: 30px; margin-right: 10px;">
          <img src="images/Partners5.jpg" alt="Partners logo" style="height: 30px; margin-right: 10px;">
          <img src="images/Partners6.jpg" alt="Partners logo" style="height: 30px; margin-right: 10px;">
          <img src="images/Partners7.jpg" alt="Partners logo" style="height: 30px; margin-right: 10px;">
          <img src="images/Partners8.jpg" alt="Partners logo" style="height: 30px; margin-right: 10px;">
          <img src="images/Partners9.jpg" alt="Partners logo" style="height: 30 px; margin-right: 10px;">
        </div>
      </div>
    </section>
    <!-- Partners/Sponsors Section End -->


  </main>
  <footer
    style="background: linear-gradient(120deg, #181818 60%, #23283b 100%); color: #f4f6fb; padding: 3.5rem 0 1.5rem 0; text-align: center; border-top: 1px solid #23283b; box-shadow: 0 -4px 32px rgba(41,121,255,0.08);">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
      <div
        style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 2.5rem; padding-bottom: 2.2rem; border-bottom: 1px solid #23283b;">
        <!-- Logo & Tagline -->
        <div style="flex:1; min-width:max-content; text-align:center;">
          <div
            style="font-size: 2rem; font-weight: 700; letter-spacing: 2px; display: flex; align-items: center; gap: 0.5rem;">
            <span style="font-size:2.2rem;">🏁</span> <span
              style="color:#ff1e1e; font-size:2.2rem; font-weight:900; letter-spacing:1px;">F1</span> Ticket Booking
          </div>
          <div style="margin-top: 0.7rem; color: #b0b8c1; font-size: 1.1rem;">Your gateway to the world of Formula 1.
            Book,<br> experience, and enjoy the thrill of racing!</div>
        </div>

        <!-- Quick Links -->
        <nav style="flex:1; min-width:max-content; text-align:center;">
          <div style="font-weight:600; margin-bottom:0.7rem; font-size:1.1rem;">Quick Links</div>
          <a href="index.php" class="footer-icon">Home</a>
          <a href="About.php" class="footer-icon">About</a>
          <a href="races.php" class="footer-icon">Races</a>
          <a href="Reachout.php" class="footer-icon">Feedback</a>
        </nav>
        <!-- Stay Connected -->
        <div style="flex:1; min-width:max-content; text-align:left;">
          <div style="font-weight:600; margin-bottom:0.7rem; font-size:1.1rem;">Stay Connected</div>
          <div style="display:flex; flex-direction:column; gap:0.7rem; margin-bottom:1.2rem;">
            <a href="#" title="Twitter"><span> <img src="images/x-icon.png"></span></a>
            <a href="#" title="Facebook"><span><img src="images/facbook-icon.png"></span></a>
            <a href="#" title="Instagram"><span><img src="images/ins-icon.png"></span></a>
          </div>
        </div>
        <div style="flex:1; min-width:200px; text-align:left;">
          <div style="font-weight:600; margin-bottom:0.7rem; font-size:1.1rem;">Contact Us</div>
          <div style="color:#b0b8c1; font-size:1rem; margin-bottom:0.3rem;">Email:
            <a href='mailto:info@f1tickets.com' style='color:#f4f6fb; text-decoration:underline;'>info@f1tickets.com</a>
          </div>
          <div style="color:#b0b8c1; font-size:1rem;">Phone:
            <a href='tel:+1234567890' style='color:#f4f6fb; text-decoration:underline;'>+1 234 567 890</a>
          </div>
        </div>
        <div style="margin-top: 2.2rem; font-size: 0.98rem; color: #b0b8c1;">&copy; <?php echo date('Y'); ?> F1 Ticket
          Booking. All rights reserved.</div>
      </div>
  </footer>
  <script src="js/script.js"></script>
  <script>
    document.addEventListener('DOMContentLoaded', function () {
      const driversTab = document.getElementById('drivers-tab');
      const teamsTab = document.getElementById('teams-tab');
      const driversLeaderboard = document.getElementById('drivers-leaderboard');
      const teamsLeaderboard = document.getElementById('teams-leaderboard');

      if (driversTab && teamsTab && driversLeaderboard && teamsLeaderboard) {
        driversTab.addEventListener('click', function () {
          driversLeaderboard.style.display = '';
          teamsLeaderboard.style.display = 'none';
          driversTab.classList.add('active');
          driversTab.style.color = '#fff';
          driversTab.style.borderBottom = '4px solid #ff1e1e';
          teamsTab.classList.remove('active');
          teamsTab.style.color = '#b0b8c1';
          teamsTab.style.borderBottom = 'none';
        });
        teamsTab.addEventListener('click', function () {
          driversLeaderboard.style.display = 'none';
          teamsLeaderboard.style.display = '';
          teamsTab.classList.add('active');
          teamsTab.style.color = '#fff';
          teamsTab.style.borderBottom = '4px solid #ff1e1e';
          driversTab.classList.remove('active');
          driversTab.style.color = '#b0b8c1';
          driversTab.style.borderBottom = 'none';
        });
      }
    });
  </script>

</body>

</html>
