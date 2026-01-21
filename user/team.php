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
    <title>F1 Race - teams</title>
    <link rel="icon" href="images/nav_icon.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .f1-team-card {
            border-radius: 14px;
            padding: 20px;
            width: 640px;
            color: white;
            position: relative;
            overflow: hidden;
            margin: 20px auto;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .f1-team-card:hover {
            transform: scale(1.05);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.4);
        }
    </style>
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
                    <li><a href='team.php'>Team</a></li>
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
        <!-- Hero Section Start -->
        <section class="hero-section"
            style="color: #f4f6fb; padding: 15rem 0 15rem 0; text-align: center; position: relative; overflow: hidden;">
            <img src="images/tems.jpg" alt="Background" style="
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
                <h2 style="font-size: 4rem; font-weight: 700; margin-bottom: 1rem; color: #f4f6fb;">F1 Teams</h2>
                <p style="font-size: 2rem; margin-bottom: 2rem; color: #b0b8c1;">Find Your Favorite Formula 1 Teams</p>
            </div>
        </section>
        <!-- Hero Section End -->

        <!-- 2025 F1 Teams List Start -->
        <section class="drivers-list-section"
            style="position: relative; background: linear-gradient(120deg, #181818 60%, #23283b 100%); color: #f4f6fb; padding: 4rem 0;">
            <div class="container" style="max-width: 1100px; margin: 0 auto;">
                <div class="drivers-grid">

                    <!-- McLaren Card -->
                    <div class="f1-team-card"
                        style="background: linear-gradient(90deg, #ff8000, #db9c3eff 100%);border-radius: 14px;padding: 20px;width: 640px;color: white;position: relative;overflow: hidden;margin: 0 auto;cursor: pointer;">
                        <div class="f1-team-header">
                            <div class="f1-team-title">McLaren</div>
                            <div class="f1-team-logo" style="background: transparent;">
                                <img src="images/mclaren1.png" alt="McLaren Logo">
                            </div>
                        </div>

                        <div class="f1-team-drivers">
                            <div class="f1-driver-item">
                                <img src="images/2025-3.png" alt="Oscar Piastri">
                                <span>Oscar <strong>PIASTRI</strong></span>
                            </div>
                            <div class="f1-driver-item">
                                <img src="images/2025-1.png" alt="Lando Norris">
                                <span>Lando <strong>NORRIS</strong></span>
                            </div>
                        </div>

                        <div class="f1-team-car">
                            <img src="images/car1.jpg" alt="McLaren Car">
                        </div>
                    </div>
                    <!-- McLaren Card End -->

                    <!-- ferrai Card -->
                    <div class="f1-team-card"
                        style="background: linear-gradient(90deg, #82030c 60%, #e7102f 100%);border-radius: 14px;padding: 20px;width: 640px;color: white;position: relative;overflow: hidden;margin: 0 auto;cursor: pointer;">
                        <div class="f1-team-header">
                            <div class="f1-team-title">Ferrari</div>
                            <div class="f1-team-logo" style="background: transparent;">
                                <img src="images/ferrari.png" alt="ferrari Logo">
                            </div>
                        </div>

                        <div class="f1-team-drivers">
                            <div class="f1-driver-item">
                                <img src="images/2025-4.png" alt="Oscar Piastri">
                                <span>Charles <strong>LECLERC</strong></span>
                            </div>
                            <div class="f1-driver-item">
                                <img src="images/2025-5.png" alt="Lando Norris">
                                <span>Lewis <strong>HAMILTON</strong></span>
                            </div>
                        </div>

                        <div class="f1-team-car">
                            <img src="images/car4.jpg" alt="McLaren Car">
                        </div>
                    </div>
                    <!-- ferrai Card End -->

                    <!-- Mercedes Card -->
                    <div class="f1-team-card"
                        style="background: linear-gradient(90deg, #00836d 60%, #00836d 100%);border-radius: 14px;padding: 20px;width: 640px;color: white;position: relative;overflow: hidden;margin: 0 auto;cursor: pointer;">
                        <div class="f1-team-header">
                            <div class="f1-team-title">Mercedes</div>
                            <div class="f1-team-logo" style="background: transparent;">
                                <img src="images/Mercedess.png" alt="ferrari Logo">
                            </div>
                        </div>

                        <div class="f1-team-drivers">
                            <div class="f1-driver-item">
                                <img src="images/2025-9.png" alt="Oscar Piastri">
                                <span>Esteban <strong>OCON</strong></span>
                            </div>
                            <div class="f1-driver-item">
                                <img src="images/2025-10.png" alt="Lando Norris">
                                <span>Oliver <strong>BEARMAN</strong></span>
                            </div>
                        </div>

                        <div class="f1-team-car">
                            <img src="images/car7.jpg" alt="McLaren Car">
                        </div>
                    </div>
                    <!-- Mercedes Card End -->

                    <!-- Haas Card -->
                    <div class="f1-team-card"
                        style="background: linear-gradient(90deg, #5f6264 60%, #929597 100%);border-radius: 14px;padding: 20px;width: 640px;color: white;position: relative;overflow: hidden;margin: 0 auto;cursor: pointer;">
                        <div class="f1-team-header">
                            <div class="f1-team-title">Haas</div>
                            <div class="f1-team-logo" style="background: transparent;">
                                <img src="images/haas.png" alt="haas Logo">
                            </div>
                        </div>

                        <div class="f1-team-drivers">
                            <div class="f1-driver-item">
                                <img src="images/2025-6.png" alt="Oscar Piastri">
                                <span>George <strong>RUSSELL</strong></span>
                            </div>
                            <div class="f1-driver-item">
                                <img src="images/2025-7.png" alt="Lando Norris">
                                <span>Kimi <strong>ANTONELLI</strong></span>
                            </div>
                        </div>

                        <div class="f1-team-car">
                            <img src="images/car5.jpg" alt="McLaren Car">
                        </div>
                    </div>
                    <!-- Haas Card End -->

                    <!-- Kick Sauber Card -->
                    <div class="f1-team-card"
                        style="background: linear-gradient(90deg, #006700 60%, #01ba0d 100%);border-radius: 14px;padding: 20px;width: 640px;color: white;position: relative;overflow: hidden;margin: 0 auto;cursor: pointer;">
                        <div class="f1-team-header">
                            <div class="f1-team-title">Kick Sauber</div>
                            <div class="f1-team-logo" style="background: transparent;">
                                <img src="images/Kick Sauber.png" alt="Kick Sauber Logo">
                            </div>
                        </div>

                        <div class="f1-team-drivers">
                            <div class="f1-driver-item">
                                <img src="images/2025-6.png" alt="Oscar Piastri">
                                <span>Nico <strong>HULKNBERG</strong></span>
                            </div>
                            <div class="f1-driver-item">
                                <img src="images/2025-7.png" alt="Lando Norris">
                                <span>Gabriel <strong>BORTOETO</strong></span>
                            </div>
                        </div>

                        <div class="f1-team-car">
                            <img src="images/car6.jpg" alt="McLaren Car">
                        </div>
                    </div>
                    <!-- Kick Sauber Card End -->

                    <!-- Red Bull Card -->
                    <div class="f1-team-card"
                        style="background: linear-gradient(90deg, #043787 60%, #4b82ba 100%);border-radius: 14px;padding: 20px;width: 640px;color: white;position: relative;overflow: hidden;margin: 0 auto;cursor: pointer;">
                        <div class="f1-team-header">
                            <div class="f1-team-title">Red Bull Racing</div>
                            <div class="f1-team-logo" style="background: transparent;">
                                <img src="images/Red Bull.png" alt=" Red Bull Logo">
                            </div>
                        </div>

                        <div class="f1-team-drivers">
                            <div class="f1-driver-item">
                                <img src="images/2025-2.png" alt="Oscar Piastri">
                                <span>Max <strong>VERSTAPPEN</strong></span>
                            </div>
                            <div class="f1-driver-item">
                                <img src="images/2025-12.png" alt="Lando Norris">
                                <span>Yuki <strong>TSUNODA</strong></span>
                            </div>
                        </div>

                        <div class="f1-team-car">
                            <img src="images/car9.jpg" alt="McLaren Car">
                        </div>
                    </div>
                    <!-- Red Bull Card End -->

                    <!-- Aston Martin Card -->
                    <div class="f1-team-card"
                        style="background: linear-gradient(90deg, #00482c 60%, #20956d 100%);border-radius: 14px;padding: 20px;width: 640px;color: white;position: relative;overflow: hidden;margin: 0 auto;cursor: pointer;">
                        <div class="f1-team-header">
                            <div class="f1-team-title">Aston Martin</div>
                            <div class="f1-team-logo" style="background: transparent;">
                                <img src="images/Aston Martin.png" alt=" Aston Martin Logo">
                            </div>
                        </div>

                        <div class="f1-team-drivers">
                            <div class="f1-driver-item">
                                <img src="images/2025-13.png" alt="Oscar Piastri">
                                <span>Lance <strong>STROLL</strong></span>
                            </div>
                            <div class="f1-driver-item">
                                <img src="images/2025-14.png" alt="Lando Norris">
                                <span>Fernando <strong>ALONSO</strong></span>
                            </div>
                        </div>

                        <div class="f1-team-car">
                            <img src="images/car3.jpg" alt="McLaren Car">
                        </div>
                    </div>
                    <!-- Aston Martin Card End -->

                    <!-- Racing  Card -->
                    <div class="f1-team-card"
                        style="background: linear-gradient(90deg, #2446ad 60%, #6893fa 100%);border-radius: 14px;padding: 20px;width: 640px;color: white;position: relative;overflow: hidden;margin: 0 auto;cursor: pointer;">
                        <div class="f1-team-header">
                            <div class="f1-team-title">Racing Bulls</div>
                            <div class="f1-team-logo" style="background: transparent;">
                                <img src="images/Racing.png" alt=" Racing Logo">
                            </div>
                        </div>

                        <div class="f1-team-drivers">
                            <div class="f1-driver-item">
                                <img src="images/2025-15.png" alt="Oscar Piastri">
                                <span>Liam <strong>LAWSON</strong></span>
                            </div>
                            <div class="f1-driver-item">
                                <img src="images/2025-16.png" alt="Lando Norris">
                                <span>Isack <strong>HADJAR</strong></span>
                            </div>
                        </div>

                        <div class="f1-team-car">
                            <img src="images/car3.jpg" alt="McLaren Car">
                        </div>
                    </div>
                    <!-- Racing Card End -->

                </div>
            </div>
        </section>
        <!-- 2025 F1 Teams List End -->
    </main>
</body>

</html>


</main>
<footer
    style="position: relative;  background: linear-gradient(120deg, #181818 60%, #23283b 100%); color: #f4f6fb; padding: 3.5rem 0 1.5rem 0; text-align: center; border-top: 1px solid #23283b; box-shadow: 0 -4px 32px rgba(41,121,255,0.08);">
    <div class="container" style="max-width: 1200px; margin: 0 auto;">
        <div
            style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 2.5rem; padding-bottom: 2.2rem; border-bottom: 1px solid #23283b;">
            <!-- Logo & Tagline -->
            <div style="flex:1; min-width:max-content; text-align:center;">
                <div
                    style="font-size: 2rem; font-weight: 700; letter-spacing: 2px; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size:2.2rem;">🏁</span> <span
                        style="color:#ff1e1e; font-size:2.2rem; font-weight:900; letter-spacing:1px;">F1</span>
                    Ticket Booking
                </div>
                <div style="margin-top: 0.7rem; color: #b0b8c1; font-size: 1.1rem;">Your gateway to the world of
                    Formula 1.
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
                    <a href='mailto:info@f1tickets.com'
                        style='color:#f4f6fb; text-decoration:underline;'>info@f1tickets.com</a>
                </div>
                <div style="color:#b0b8c1; font-size:1rem;">Phone:
                    <a href='tel:+1234567890' style='color:#f4f6fb; text-decoration:underline;'>+1 234 567 890</a>
                </div>
            </div>
            <div style="margin-top: 2.2rem; font-size: 0.98rem; color: #b0b8c1;">&copy; <?php echo date('Y'); ?> F1
                Ticket
                Booking. All rights reserved.</div>
        </div>
</footer>
<script src="js/script.js"></script>
</body>

</html>