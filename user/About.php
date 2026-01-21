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
  <title>F1 Race - About Us</title>
  <link rel="icon" href="images/nav_icon.png" type="image/png">

  <link rel="stylesheet" href="css/style.css">
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
  <style>
    body {
      background: rgba(35, 37, 38, 0.4) !important;
    }
  </style>
</head>

<body>
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
    <!-- About us Section Start -->
    <section class="hero-section"
      style="  color: #f4f6fb; padding: 15rem 0 20rem 0; text-align: center; position: relative; overflow: hidden;">
      <img src="images/about.jpg" alt="Background" style="
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
        <h2 style="font-size: 3rem; font-weight: 700; padding-top: 50px; color: #f4f6fb;">
          About Us
        </h2>
      </div>
    </section>

    <section class="about-section"
      style="position: relative; padding: 4rem 1rem; background-color: #232526; color: #f4f6fb;">
      <div class="container" style="max-width: 1350px; margin: auto;">

        <!-- Hero Introduction -->
        <div
          style="text-align: center;  padding: 2rem; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border-radius: 20px; border: 1px solid rgba(255,255,255,0.3); box-shadow: 0 6px 20px rgba(0,0,0,0.25);">
          <h2
            style="font-size: 2.8rem; margin-bottom: 1.5rem; background: #fff; -webkit-text-fill-color: transparent; background-clip: text;">
            Welcome to F1 Tickets
          </h2>
          <p
            style="font-size: 1.3rem; margin-bottom: 1.5rem; color: #f1f1f1; max-width: 800px; margin-left: auto; margin-right: auto;">
            Your trusted partner in bringing the high-speed world of Formula 1 right to your fingertips.
          </p>
          <a href="races.php"
            style="display: inline-block; padding: 0.8rem 2.2rem; background: rgba(255, 255, 255, 0.15); backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px); border: 1px solid rgba(255, 255, 255, 0.3); border-radius: 30px; font-weight: 600; font-size: 1.1rem; color: #ffffff; text-decoration: none; cursor: pointer; box-shadow: 0 6px 18px rgba(0, 0, 0, 0.25); transition: all 0.3s ease; text-align: center;"
            onmouseover="this.style.transform='translateY(-5px)'; this.style.boxShadow='0 10px 25px rgba(0,0,0,0.35)'; this.style.background='linear-gradient(45deg,#ff1e1e,#ff6b6b)';"
            onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 6px 18px rgba(0,0,0,0.25)'; this.style.background='rgba(255, 255, 255, 0.15)';">
            🏁 Experience the Thrill of Racing
          </a>


        </div>


        <!-- Story Section -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin: 100px 0; align-items: center;">
          <div>
            <h3 style="font-size: 2rem; margin-bottom: 1.5rem; color: #f1f1f1;">Our Story</h3>
            <p style="font-size: 1.1rem; margin-bottom: 1.2rem; line-height: 1.8; color: #d1d1d1;">
              Born out of pure passion for motorsports, F1 Tickets was created to make it easier for fans around the
              world
              to witness the thrill of Formula 1 live. From the screeching turns of Spa-Francorchamps to the glamour of
              Monaco, we bring the circuits to life — one ticket at a time.
            </p>
            <p style="font-size: 1.1rem; margin-bottom: 1.2rem; line-height: 1.8; color: #d1d1d1;">
              Our goal is simple: to make every step of your journey — from browsing to booking to race day — seamless,
              exciting, and reliable. Whether you're a solo traveler, a family of fans, or a corporate group, we've got
              packages that suit every need.
            </p>
          </div>
          <div class="about-us-video-section">
            <video width="100%" height="auto" autoplay muted playsinline controls
              style="border-radius:12px; outline:none; background:#000;">
              <source src="images/story.mp4" type="video/mp4">
              Your browser does not support the video tag.
            </video>
          </div>
        </div>

        <!-- Services Section -->
        <div style="margin-bottom: 4rem;">
          <h3 style="font-size: 2.2rem; margin-bottom: 2rem; text-align: center; color: #ffffffff;">🚀 Our Premium
            Services</h3>
          <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">

            <div
              style="background: rgba(255, 255, 255, 0.15);backdrop-filter: blur(12px);-webkit-backdrop-filter: blur(12px);padding: 2.5rem;border-radius: 20px;border: 1px solid rgba(255, 255, 255, 0.3);text-align: center;transition: all 0.4s ease;box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);cursor: pointer;"
              onmouseover="this.style.transform='translateY(-10px) scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.35)'"
              onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.25)'">
              <div style="font-size: 3.5rem; margin-bottom: 1.2rem; color: #ff3c3c;">🎫</div>
              <h4 style="font-size: 1.5rem; margin-bottom: 1rem; color: #ffffff;">Official Race Tickets</h4>
              <p style="color: #f1f1f1; line-height: 1.7; font-size: 1rem;">
                Official race ticket booking for all Grand Prix events worldwide.
              </p>
            </div>

            <div
              style="background: rgba(255, 255, 255, 0.15);backdrop-filter: blur(12px);-webkit-backdrop-filter: blur(12px);padding: 2.5rem;border-radius: 20px;border: 1px solid rgba(255, 255, 255, 0.3);text-align: center;transition: all 0.4s ease;box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);cursor: pointer;"
              onmouseover="this.style.transform='translateY(-10px) scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.35)'"
              onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.25)'">
              <div style="font-size: 3.5rem; margin-bottom: 1.2rem; color: #1e90ff;">✈️</div>
              <h4 style="font-size: 1.5rem; margin-bottom: 1rem; color: #ffffff;">Travel Packages</h4>
              <p style="color: #f1f1f1; line-height: 1.7; font-size: 1rem;">
                Customizable travel and hospitality packages for the ultimate experience.
              </p>
            </div>


            <!-- Hotel + Ticket Combos -->
            <div
              style="background: rgba(255, 255, 255, 0.15);backdrop-filter: blur(12px);-webkit-backdrop-filter: blur(12px);padding: 2.5rem;border-radius: 20px;border: 1px solid rgba(255, 255, 255, 0.3);text-align: center;transition: all 0.4s ease;box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);cursor: pointer;"
              onmouseover="this.style.transform='translateY(-10px) scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.35)'"
              onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.25)'">
              <div style="font-size: 3.5rem; margin-bottom: 1.2rem; color: #ff8c00;">🏨</div>
              <h4 style="font-size: 1.5rem; margin-bottom: 1rem; color: #ffffff;">Hotel + Ticket Combos</h4>
              <p style="color: #f1f1f1; line-height: 1.7; font-size: 1rem;">
                Exclusive hotel and ticket combo deals for global races.
              </p>
            </div>

            <!-- Digital Experience -->
            <div
              style="background: rgba(255, 255, 255, 0.15);backdrop-filter: blur(12px);-webkit-backdrop-filter: blur(12px);padding: 2.5rem;border-radius: 20px;border: 1px solid rgba(255, 255, 255, 0.3);text-align: center;transition: all 0.4s ease;box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);cursor: pointer;"
              onmouseover="this.style.transform='translateY(-10px) scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.35)'"
              onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.25)'">
              <div style="font-size: 3.5rem; margin-bottom: 1.2rem; color: #00bfff;">📱</div>
              <h4 style="font-size: 1.5rem; margin-bottom: 1rem; color: #ffffff;">Digital Experience</h4>
              <p style="color: #f1f1f1; line-height: 1.7; font-size: 1rem;">
                Mobile-friendly bookings and digital ticket delivery system.
              </p>
            </div>

            <!-- Secure Payments -->
            <div
              style="background: rgba(255, 255, 255, 0.15);backdrop-filter: blur(12px);-webkit-backdrop-filter: blur(12px);padding: 2.5rem;border-radius: 20px;border: 1px solid rgba(255, 255, 255, 0.3);text-align: center;transition: all 0.4s ease;box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);cursor: pointer;"
              onmouseover="this.style.transform='translateY(-10px) scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.35)'"
              onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.25)'">
              <div style="font-size: 3.5rem; margin-bottom: 1.2rem; color: #32cd32;">🔒</div>
              <h4 style="font-size: 1.5rem; margin-bottom: 1rem; color: #ffffff;">Secure Payments</h4>
              <p style="color: #f1f1f1; line-height: 1.7; font-size: 1rem;">
                100% secure payment system with multiple payment options.
              </p>
            </div>

            <!-- Exclusive Content -->
            <div
              style="background: rgba(255, 255, 255, 0.15);backdrop-filter: blur(12px);-webkit-backdrop-filter: blur(12px);padding: 2.5rem;border-radius: 20px;border: 1px solid rgba(255, 255, 255, 0.3);text-align: center;transition: all 0.4s ease;box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);cursor: pointer;"
              onmouseover="this.style.transform='translateY(-10px) scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.35)'"
              onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.25)'">
              <div style="font-size: 3.5rem; margin-bottom: 1.2rem; color: #ff1493;">📸</div>
              <h4 style="font-size: 1.5rem; margin-bottom: 1rem; color: #ffffff;">Exclusive Content</h4>
              <p style="color: #f1f1f1; line-height: 1.7; font-size: 1rem;">
                Behind-the-scenes content and premium fan merchandise.
              </p>
            </div>
            <!-- VIP Lounge Access -->
            <div
              style="background: rgba(255, 255, 255, 0.15);backdrop-filter: blur(12px);-webkit-backdrop-filter: blur(12px);padding: 2.5rem;border-radius: 20px;border: 1px solid rgba(255, 255, 255, 0.3);text-align: center;transition: all 0.4s ease;box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);cursor: pointer;"
              onmouseover="this.style.transform='translateY(-10px) scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.35)'"
              onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.25)'">
              <div style="font-size: 3.5rem; margin-bottom: 1.2rem; color: gold;">🥂</div>
              <h4 style="font-size: 1.5rem; margin-bottom: 1rem; color: #ffffff;">VIP Lounge Access</h4>
              <p style="color: #f1f1f1; line-height: 1.7; font-size: 1rem;">
                Exclusive access to premium lounges with food, drinks & luxury seating.
              </p>
            </div>

            <!-- Race Day Transport -->
            <div
              style="background: rgba(255, 255, 255, 0.15);backdrop-filter: blur(12px);-webkit-backdrop-filter: blur(12px);padding: 2.5rem;border-radius: 20px;border: 1px solid rgba(255, 255, 255, 0.3);text-align: center;transition: all 0.4s ease;box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);cursor: pointer;"
              onmouseover="this.style.transform='translateY(-10px) scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.35)'"
              onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.25)'">
              <div style="font-size: 3.5rem; margin-bottom: 1.2rem; color: #ff4500;">🚌</div>
              <h4 style="font-size: 1.5rem; margin-bottom: 1rem; color: #ffffff;">Race Day Transport</h4>
              <p style="color: #f1f1f1; line-height: 1.7; font-size: 1rem;">
                Hassle-free transport services to and from the race venue.
              </p>
            </div>

            <!-- Meet & Greet -->
            <div
              style="background: rgba(255, 255, 255, 0.15);backdrop-filter: blur(12px);-webkit-backdrop-filter: blur(12px);padding: 2.5rem;border-radius: 20px;border: 1px solid rgba(255, 255, 255, 0.3);text-align: center;transition: all 0.4s ease;box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);cursor: pointer;"
              onmouseover="this.style.transform='translateY(-10px) scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.35)'"
              onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.25)'">
              <div style="font-size: 3.5rem; margin-bottom: 1.2rem; color: #ff69b4;">🤝</div>
              <h4 style="font-size: 1.5rem; margin-bottom: 1rem; color: #ffffff;">Meet & Greet</h4>
              <p style="color: #f1f1f1; line-height: 1.7; font-size: 1rem;">
                Get up close with drivers & teams with exclusive meet-and-greet sessions.
              </p>
            </div>

            <!-- Live Race Streaming -->
            <div
              style="background: rgba(255, 255, 255, 0.15);backdrop-filter: blur(12px);-webkit-backdrop-filter: blur(12px);padding: 2.5rem;border-radius: 20px;border: 1px solid rgba(255, 255, 255, 0.3);text-align: center;transition: all 0.4s ease;box-shadow: 0 8px 20px rgba(0, 0, 0, 0.25);cursor: pointer;"
              onmouseover="this.style.transform='translateY(-10px) scale(1.05)'; this.style.boxShadow='0 15px 35px rgba(0,0,0,0.35)'"
              onmouseout="this.style.transform='translateY(0) scale(1)'; this.style.boxShadow='0 8px 20px rgba(0,0,0,0.25)'">
              <div style="font-size: 3.5rem; margin-bottom: 1.2rem; color: #00fa9a;">📺</div>
              <h4 style="font-size: 1.5rem; margin-bottom: 1rem; color: #ffffff;">Live Race Streaming</h4>
              <p style="color: #f1f1f1; line-height: 1.7; font-size: 1rem;">
                Enjoy live streaming access with multiple camera angles and replays.
              </p>
            </div>
          </div>
        </div>

        <!-- Mission & Vision Section -->
        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 3rem; margin-bottom: 4rem;">

          <div
            style="background: rgba(255, 255, 255, 0.1); padding: 2.5rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.2); text-align: center; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">

            <div style="font-size: 3rem; margin-bottom: 1rem;">🌟</div>
            <h3 style="font-size: 1.8rem; margin-bottom: 1.5rem; color: #f1f1f1;">Our Mission</h3>
            <p style="font-size: 1.05rem; line-height: 1.8; color: #d1d1d1;">
              To build a global community of racing fans and make live Formula 1 events more accessible and affordable.
              We want every F1 lover to feel the rush of engines, the energy of the crowd, and the intensity of each
              lap.
            </p>
          </div>


          <div
            style="background: rgba(255,255,255,0.1); padding: 2.5rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.2); text-align: center; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">
            <div style="font-size: 3rem; margin-bottom: 1rem;">🌍</div>
            <h3 style="font-size: 1.8rem; margin-bottom: 1.5rem; color: #f1f1f1;">Our Vision</h3>
            <p style="font-size: 1.05rem; line-height: 1.8; color: #d1d1d1;">
              A world where any fan — regardless of location — can be part of the Formula 1 experience.
              Through innovation and dedication, we're shaping the future of race ticketing with speed, simplicity, and
              trust.
            </p>
          </div>
        </div>

        <!-- Community Section -->
        <div
          style="background: rgba(255,255,255,0.1); padding: 3rem; border-radius: 20px; border: 1px solid rgba(255,255,255,0.2); text-align: center; margin-bottom: 4rem; backdrop-filter: blur(12px); -webkit-backdrop-filter: blur(12px);">

          <h3 style="font-size: 2.2rem; margin-bottom: 1.5rem; color: #f1f1f1;">👥 Join Our Racing Community</h3>

          <p
            style="font-size: 1.1rem; margin-bottom: 2rem; line-height: 1.8; color: #d1d1d1; max-width: 800px; margin-left: auto; margin-right: auto;">
            We're more than just a platform — we're a movement. Join thousands of racing enthusiasts who rely on F1
            Tickets to stay connected to their passion. Follow us on social media, subscribe to race alerts, and be part
            of something fast and unforgettable.
          </p>

          <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
            <div
              style="display: flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: rgba(255,255,255,0.1); border-radius: 25px; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
              <span style="font-size: 1.2rem;">📱</span>
              <span>Race Alerts</span>
            </div>
            <div
              style="display: flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: rgba(255,255,255,0.1); border-radius: 25px; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
              <span style="font-size: 1.2rem;">🎯</span>
              <span>Exclusive Content</span>
            </div>
            <div
              style="display: flex; align-items: center; gap: 0.5rem; padding: 0.8rem 1.5rem; background: rgba(255,255,255,0.1); border-radius: 25px; border: 1px solid rgba(255,255,255,0.2); backdrop-filter: blur(8px); -webkit-backdrop-filter: blur(8px);">
              <span style="font-size: 1.2rem;">🏆</span>
              <span>VIP Access</span>
            </div>
          </div>
        </div>


        <!-- Call to Action -->
        <div
          style="text-align: center; padding: 3rem; background: rgba(255,255,255,0.1); border-radius: 20px; border: 2px solid rgba(255,255,255,0.1);">
          <h3
            style="font-size: 2.5rem; margin-bottom: 1.5rem; background: #f1f1f1; -webkit-text-fill-color: transparent; background-clip: text;">
            🌟 Ready to Experience the Thrill?
          </h3>
          <p style="font-size: 1.3rem; margin-bottom: 2rem; color: #e0e0e0; font-weight: 500;">
            Feel the speed. Live the moment. <strong>Book with F1 Tickets today.</strong>
          </p>
          <div style="display: flex; justify-content: center; gap: 2rem; flex-wrap: wrap;">
            <!-- First Button -->
            <a href="races.php"
              style="display: inline-block; padding: 1rem 2.5rem; background: #444; color: white; text-decoration: none; border-radius: 30px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease;"
              onmouseover="this.style.background='#ff1e1e'; this.style.transform='scale(1.05)';"
              onmouseout="this.style.background='#444'; this.style.transform='scale(1)';">
              🏁 View Races
            </a>

            <!-- Second Button -->
            <a href="book_ticket.php"
              style="display: inline-block; padding: 1rem 2.5rem; background: #444; color: white; text-decoration: none; border-radius: 30px; font-weight: 600; font-size: 1.1rem; transition: all 0.3s ease;"
              onmouseover="this.style.background='#16BE45'; this.style.transform='scale(1.05)';"
              onmouseout="this.style.background='#444'; this.style.transform='scale(1)';">
              🎫 Book Now
            </a>
          </div>
        </div>

      </div>
    </section>



    <!-- About us Section End -->


  </main>
  <footer
    style="background: linear-gradient(120deg, #181818 60%, #23283b 100%); color: #f4f6fb; padding: 3.5rem 0 1.5rem 0; text-align: center; border-top: 1px solid #23283b;  box-shadow: 0 -4px 32px rgba(41,121,255,0.08);">
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
  <script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
  <script>
    var wa_btnSetting = { "btnColor": "#16BE45", "ctaText": "", "cornerRadius": 40, "marginBottom": 20, "marginLeft": 20, "marginRight": 20, "btnPosition": "right", "whatsAppNumber": "6356497821", "welcomeMessage": "Welcome to F1 Car Booking – Your race to the thrill begins here!", "zIndex": 999999, "btnColorScheme": "light" };
    window.onload = () => {
      _waEmbed(wa_btnSetting);
    };
  </script>

</body>

</html>