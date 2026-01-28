<?php
require_once 'config.php';

// Get all races with error handling
try {
  $pdo = getDBConnection();
  $stmt = $pdo->query("SELECT * FROM races ORDER BY race_date ASC");
  $races = $stmt->fetchAll();
} catch (PDOException $e) {
  error_log("Database error in races.php: " . $e->getMessage());
  $races = [];
  $error_message = "Unable to load races at this time. Please try again later.";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>F1 Race - Race</title>
  <link rel="icon" href="images/nav_icon.png" type="image/png">

  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    /* Loader overlay styles */
    #loader-overlay {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      background: rgba(255, 255, 255, 0.95);
      z-index: 99999;
      display: flex;
      align-items: center;
      justify-content: center;
      transition: opacity 0.5s;
    }

    .loader {
      border: 8px solid #f3f3f3;
      border-top: 8px solid #ff1e1e;
      border-radius: 50%;
      width: 70px;
      height: 70px;
      animation: spin 1s linear infinite;
    }

    @keyframes spin {
      0% {
        transform: rotate(0deg);
      }

      100% {
        transform: rotate(360deg);
      }
    }

    #loader-overlay.fade-out {
      opacity: 0;
      pointer-events: none;
    }
  </style>
</head>

<body>
  <!-- Loader Overlay -->
  <header>
    <nav class="navbar">
      <div class="nav-container">
        <a href="index.php">
          <img src="images/main_logo.png" alt="F1 Hero" height="70px" width="80px" object-fit="cover">
        </a>
        <ul class="nav-menu">
          <li><a href="index.php">Home</a></li>
          <li><a href="About.php">About us</a></li>
          <li><a href="driver.php">Driver</a></li>
          <li><a href="team.php">Team</a></li>
          <li><a href="races.php">Races</a></li>

          <?php if (isLoggedIn()): ?>
            <li><a href="bookings.php">My Bookings</a></li>

            <li><a href="logout.php">Logout</a></li>
            <li class="user-info">Welcome, <?php echo htmlspecialchars(getCurrentUser()['full_name']); ?></li>
          <?php else: ?>
            <li><a href="login.php">Login</a></li>
          <?php endif; ?>
        </ul>

      </div>
    </nav>
  </header>

  <main>

    <!-- driver Section Start -->
    <section class="hero-section"
      style="color: #f4f6fb; padding: 15rem 0 20rem 0; text-align: center; position: relative; overflow: hidden;">
      <img src="images/race.jpg" alt="Background" style="
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
        <h2 style="font-size: 4rem; font-weight: 700; margin-bottom: 1rem; color: #f4f6fb;"> F1 Races
        </h2>
      </div>
    </section>
    <!-- driver Section End -->
    <section class="races-section py-5">
      <div class="container">
        <div class="row align-items-start">
          <!-- Left Column: Race Cards -->
          <div class="col-md-6">
            <?php if (isset($error_message)): ?>
              <div class="message error"
                style="background: #ff4757; color: white; padding: 1rem; border-radius: 5px; margin-bottom: 2rem;">
                <?php echo htmlspecialchars($error_message); ?>
              </div>
            <?php endif; ?>

            <?php if (empty($races) && !isset($error_message)): ?>
              <div class="message"
                style="background: #3742fa; color: white; padding: 1rem; border-radius: 5px; margin-bottom: 2rem;">
                No races are currently available. Please check back later.
              </div>
            <?php endif; ?>

            <div class="races-grid">
              <?php foreach ($races as $race): ?>
                <div class="race-card mb-4 p-3 border rounded shadow-sm bg-white">
                  <div class="race-image mb-2">
                    <?php
                    $imagePath = (!empty($race['image']) && file_exists(__DIR__ . '/../uploads/' . $race['image']))
                      ? '../uploads/' . htmlspecialchars($race['image'])  // Use relative path for browser
                      : '../images/f1trek.jpg'; // fallback image
                    ?>
                    <img src="<?php echo $imagePath; ?>" alt="Race Image" class="img-fluid rounded"
                      style="height: 100%; width: 100%; object-fit: cover;">
                  </div>
                  <div class="race-info">
                    <h3><?php echo htmlspecialchars($race['race_name']); ?></h3>
                    <p class="track text-muted"><?php echo htmlspecialchars($race['track_name']); ?></p>
                    <p class="location text-muted"><?php echo htmlspecialchars($race['location']); ?></p>
                    <p class="date"><strong>Date:</strong> <?php echo date('F j, Y', strtotime($race['race_date'])); ?>
                    </p>
                    <p class="time"><strong>Time:</strong> <?php echo date('g:i A', strtotime($race['race_time'])); ?></p>
                    <p class="description"><?php echo htmlspecialchars($race['description']); ?></p>
                    <a href="book_ticket.php?race_id=<?php echo $race['id']; ?>" class="book-button">Book Now</a>
                  </div>
                </div>
              <?php endforeach; ?>


            </div>
          </div>

        </div>
      </div>
    </section>



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
            <a href="index.php"
              style="color: #f4f6fb; text-decoration: none; display:block; margin-bottom:0.4rem;">Home</a>
            <a href="About.php"
              style="color: #f4f6fb; text-decoration: none; display:block; margin-bottom:0.4rem;">About</a>
            <a href="races.php"
              style="color: #f4f6fb; text-decoration: none; display:block; margin-bottom:0.4rem;">Races</a>
            <a href="Reachout.php"
              style="color: #f4f6fb; text-decoration: none; display:block; margin-bottom:0.4rem;">Feedback</a>
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
              <a href='mailto:info@f1tickets.com'
                style='color:#f4f6fb; text-decoration:underline;'>info@f1tickets.com</a>
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
    
</body>

</html>
