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
    <title>F1 Race - Drivers</title>
    <link rel="icon" href="images/nav_icon.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
    <style>
        .driver-card {
            transition: transform 0.3s ease;
            /* smooth zoom */
        }

        .driver-card:hover {
            transform: scale(1.05);
            /* zoom in */
        }

        .driver-section {
            transition: transform 0.4s ease, box-shadow 0.4s ease;
        }

        .driver-section:hover {
            transform: scale(1.05);
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
            style="color: #f4f6fb; padding: 15rem 0 15rem 0; text-align: center; position: relative; overflow: hidden;">
            <img src="images/drive.jpg" alt="Background" style="
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
                <h2 style="font-size: 4rem; font-weight: 700; margin-bottom: 1rem; color: #f4f6fb;"> F1 Drivers 2025
                </h2>
                <p style="font-size: 2rem; margin-bottom: 2rem; color: #b0b8c1;">Find the current Formula 1 drivers for
                    the 2025 season</p>
            </div>
        </section>
        <!-- driver Section End -->

        <!-- 2025 F1 Drivers List Start -->
        <section class="drivers-list-section"
            style="position: relative; background: linear-gradient(120deg, #181818 60%, #23283b 100%); color: #f4f6fb; padding: 4rem 0;">
            <div class="container" style="max-width: 1100px; margin: 0 auto;">
                <div class="drivers-grid">
                    <!-- Each driver card -->
                    <!-- First driver card -->
                    <div class="driver-section"
                        style=" display: flex; align-items: stretch; border-radius: 20px; overflow: hidden; min-height: 280px; margin-bottom: 0.5rem; box-shadow: 0 4px 32px rgba(0,0,0,0.18); width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; font-family: 'Roboto', Arial, sans-serif; background: linear-gradient(90deg, #ff8000 60%, #ffb84d 100%);">
                        <!-- Left info section -->
                        <div
                            style=" flex: 1 1 45%; display: flex; flex-direction: column; justify-content: flex-start; padding: 2.5rem 2rem 2rem 2.5rem; color: #fff;">
                            <div class="driver-name">
                                <div style="font-size: 1.2rem; font-weight: 400;">Oscar</div>
                                <div
                                    style="font-size: 2.2rem; font-weight: 900; letter-spacing: 1px; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif;">
                                    Piastri</div>
                            </div>
                            <div style="font-size: 1.1rem; font-weight: 500; color: #e0e0e0;">
                                McLaren</div>
                            <div
                                style="font-size: 2.1rem; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif; font-weight: 700; color: #fff;">
                                81</div>
                            <img src="images/australia.png" alt="Australia Flag"
                                style="width: 36px; height: 34px; border-radius: 25px; border: 3px solid; margin-top: auto;">
                        </div>
                        <!-- Right image section -->
                        <div
                            style=" flex: 1 1 55%; display: flex; align-items: flex-end; justify-content: center; background: transparent; min-width: 220px; position: relative;">
                            <img src="images/2025-3.png" alt="Oscar Piastri"
                                style=" max-height: 260px; width: auto; object-fit: contain; margin-bottom: 0.5rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.18));">
                        </div>
                    </div>
                    <!-- Second driver card -->
                    <div class="driver-section"
                        style=" display: flex; align-items: stretch; border-radius: 20px; overflow: hidden; min-height: 280px; margin-bottom: 0.5rem; box-shadow: 0 4px 32px rgba(0,0,0,0.18); width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; font-family: 'Roboto', Arial, sans-serif; background: linear-gradient(90deg, #ff8000 60%, #ffb84d 100%);">
                        <!-- Left info section -->
                        <div
                            style=" flex: 1 1 45%; display: flex; flex-direction: column; justify-content: flex-start; padding: 2.5rem 2rem 2rem 2.5rem; color: #fff;">
                            <dic class="driver-name">
                                <div style="font-size: 1.2rem; font-weight: 400;">Lando</div>
                                <div
                                    style="font-size: 2.2rem; font-weight: 900; letter-spacing: 1px; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif;">
                                    Norris</div>
                            </dic>
                            <div style="font-size: 1.1rem; font-weight: 500; color: #e0e0e0;">
                                McLaren</div>
                            <div
                                style="font-size: 2.1rem; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif; font-weight: 700; color: #fff;">
                                4</div>
                            <img src="images/uk.png" alt="Australia Flag"
                                style="width: 36px; height: 34px; border-radius: 25px; border: 3px solid; margin-top: auto;">
                        </div>
                        <!-- Right image section -->
                        <div
                            style=" flex: 1 1 55%; display: flex; align-items: flex-end; justify-content: center; background: transparent; min-width: 220px; position: relative;">
                            <img src="images/2025-1.png" alt="Oscar Piastri"
                                style=" max-height: 260px; width: auto; object-fit: contain; margin-bottom: 0.5rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.18));">
                        </div>
                    </div>
                    <!-- second driver card -->
                    <div class="driver-section"
                        style=" display: flex; align-items: stretch; border-radius: 20px; overflow: hidden; min-height: 280px; margin-bottom: 0.5rem; box-shadow: 0 4px 32px rgba(0,0,0,0.18); width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; font-family: 'Roboto', Arial, sans-serif; background: linear-gradient(90deg, #82030c 60%, #e7102f 100%);">
                        <!-- Left info section -->
                        <div
                            style=" flex: 1 1 45%; display: flex; flex-direction: column; justify-content: flex-start; padding: 2.5rem 2rem 2rem 2.5rem; color: #fff;">
                            <div class="driver-name">
                                <div style="font-size: 1.2rem; font-weight: 400;">Charles</div>
                                <div
                                    style="font-size: 2.2rem; font-weight: 900; letter-spacing: 1px; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif;">
                                    Leclerc</div>
                            </div>
                            <div style="font-size: 1.1rem; font-weight: 500; color: #e0e0e0;">
                                Ferrari</div>
                            <div
                                style="font-size: 2.1rem; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif; font-weight: 700; color: #fff;">
                                16</div>
                            <img src="images/poland.png" alt="Australia Flag"
                                style="width: 36px; height: 34px; border-radius: 25px; border: 3px solid; margin-top: auto;">
                        </div>
                        <!-- Right image section -->
                        <div
                            style=" flex: 1 1 55%; display: flex; align-items: flex-end; justify-content: center; background: transparent; min-width: 220px; position: relative;">
                            <img src="images/2025-4.png" alt="Oscar Piastri"
                                style=" max-height: 260px; width: auto; object-fit: contain; margin-bottom: 0.5rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.18));">
                        </div>
                    </div>
                    <!-- Second driver card -->
                    <div class="driver-section"
                        style=" display: flex; align-items: stretch; border-radius: 20px; overflow: hidden; min-height: 280px; margin-bottom: .5rem; box-shadow: 0 4px 32px rgba(0,0,0,0.18); width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; font-family: 'Roboto', Arial, sans-serif; background: linear-gradient(90deg, #82030c 60%, #e7102f 100%);">
                        <!-- right info section -->
                        <div
                            style=" flex: 1 1 45%; display: flex; flex-direction: column; justify-content: flex-start; padding: 2.5rem 2rem 2rem 2.5rem; color: #fff;">
                            <div class="driver-name">
                                <div style="font-size: 1.2rem; font-weight: 400;">Lewis</div>
                                <div
                                    style="font-size: 2.2rem; font-weight: 900; letter-spacing: 1px; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif;">
                                    Hamilton</div>
                            </div>
                            <div style="font-size: 1.1rem; font-weight: 500; color: #e0e0e0;">
                                McLaren</div>
                            <div
                                style="font-size: 2.1rem; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif; font-weight: 700; color: #fff;">
                                44</div>
                            <img src="images/uk.png" alt="Australia Flag"
                                style="width: 36px; height: 34px; border-radius: 25px; border: 3px solid; margin-top: auto;">
                        </div>
                        <!-- Right image section -->
                        <div
                            style=" flex: 1 1 55%; display: flex; align-items: flex-end; justify-content: center; background: transparent; min-width: 220px; position: relative;">
                            <img src="images/2025-5.png" alt="Oscar Piastri"
                                style=" max-height: 260px; width: auto; object-fit: contain; margin-bottom: 0.5rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.18));">
                        </div>
                    </div>
                    <!-- third driver card -->
                    <div class="driver-section"
                        style=" display: flex; align-items: stretch; border-radius: 20px; overflow: hidden; min-height: 280px; margin-bottom: 0.5rem; box-shadow: 0 4px 32px rgba(0,0,0,0.18); width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; font-family: 'Roboto', Arial, sans-serif; background: linear-gradient(90deg, #00836d 60%, #00836d 100%);">
                        <!-- Left info section -->
                        <div
                            style=" flex: 1 1 45%; display: flex; flex-direction: column; justify-content: flex-start; padding: 2.5rem 2rem 2rem 2.5rem; color: #fff;">
                            <div class="driver-name">
                                <div style="font-size: 1.2rem; font-weight: 400;">George</div>
                                <div
                                    style="font-size: 2.2rem; font-weight: 900; letter-spacing: 1px; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif;">
                                    George</div>
                            </div>
                            <div style="font-size: 1.1rem; font-weight: 500; color: #e0e0e0;">
                                Mercedes</div>
                            <div
                                style="font-size: 2.1rem; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif; font-weight: 700; color: #fff;">
                                63</div>
                            <img src="images/uk.png" alt="Australia Flag"
                                style="width: 36px; height: 34px; border-radius: 25px; border: 3px solid; margin-top: auto;">
                        </div>
                        <!-- Right image section -->
                        <div
                            style=" flex: 1 1 55%; display: flex; align-items: flex-end; justify-content: center; background: transparent; min-width: 220px; position: relative;">
                            <img src="images/2025-6.png" alt="Oscar Piastri"
                                style=" max-height: 260px; width: auto; object-fit: contain; margin-bottom: 0.5rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.18));">
                        </div>
                    </div>
                    <!-- third driver card -->
                    <div class="driver-section"
                        style=" display: flex; align-items: stretch; border-radius: 20px; overflow: hidden; min-height: 280px; margin-bottom: 0.5rem; box-shadow: 0 4px 32px rgba(0,0,0,0.18); width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; font-family: 'Roboto', Arial, sans-serif; background: linear-gradient(90deg, #00836d 60%, #00836d 100%);">
                        <!-- Left info section -->
                        <div
                            style=" flex: 1 1 45%; display: flex; flex-direction: column; justify-content: flex-start; padding: 2.5rem 2rem 2rem 2.5rem; color: #fff;">
                            <div class="driver-name">
                                <div style="font-size: 1.2rem; font-weight: 400;">Kimi</div>
                                <div
                                    style="font-size: 2.2rem; font-weight: 900; letter-spacing: 1px; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif;">
                                    Antonelli</div>
                            </div>
                            <div style="font-size: 1.1rem; font-weight: 500; color: #e0e0e0;">
                                Mercedes</div>
                            <div
                                style="font-size: 2.1rem; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif; font-weight: 700; color: #fff;">
                                12</div>
                            <img src="images/italy.png" alt="Australia Flag"
                                style="width: 36px; height: 34px; border-radius: 25px; border: 3px solid; margin-top: auto;">
                        </div>
                        <!-- Right image section -->
                        <div
                            style=" flex: 1 1 55%; display: flex; align-items: flex-end; justify-content: center; background: transparent; min-width: 220px; position: relative;">
                            <img src="images/2025-7.png" alt="Oscar Piastri"
                                style=" max-height: 260px; width: auto; object-fit: contain; margin-bottom: 0.5rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.18));">
                        </div>
                    </div>
                    <!-- four drive card -->
                    <div class="driver-section"
                        style=" display: flex; align-items: stretch; border-radius: 20px; overflow: hidden; min-height: 280px; margin-bottom: 0.5rem; box-shadow: 0 4px 32px rgba(0,0,0,0.18); width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; font-family: 'Roboto', Arial, sans-serif; background: linear-gradient(90deg, #006700 60%, #01ba0d 100%);">
                        <!-- Left info section -->
                        <div
                            style=" flex: 1 1 45%; display: flex; flex-direction: column; justify-content: flex-start; padding: 2.5rem 2rem 2rem 2.5rem; color: #fff;">
                            <div class="driver-name">
                                <div style="font-size: 1.2rem; font-weight: 400;">Nico</div>
                                <div
                                    style="font-size: 2.2rem; font-weight: 900; letter-spacing: 1px; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif;">
                                    Hulkenberg</div>
                            </div>
                            <div style="font-size: 1.1rem; font-weight: 500; color: #e0e0e0;">
                                Kick Sauber</div>
                            <div
                                style="font-size: 2.1rem; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif; font-weight: 700; color: #fff;">
                                27</div>
                            <img src="images/germany.png" alt="Australia Flag"
                                style="width: 36px; height: 34px; border-radius: 25px; border: 3px solid; margin-top: auto;">
                        </div>
                        <!-- Right image section -->
                        <div
                            style=" flex: 1 1 55%; display: flex; align-items: flex-end; justify-content: center; background: transparent; min-width: 220px; position: relative;">
                            <img src="images/2025-8.png" alt="Oscar Piastri"
                                style=" max-height: 260px; width: auto; object-fit: contain; margin-bottom: 0.5rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.18));">
                        </div>
                    </div>
                    <!-- four drive card -->
                    <div class="driver-section"
                        style=" display: flex; align-items: stretch; border-radius: 20px; overflow: hidden; min-height: 280px; margin-bottom: 0.5rem; box-shadow: 0 4px 32px rgba(0,0,0,0.18); width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; font-family: 'Roboto', Arial, sans-serif; background: linear-gradient(90deg, #006700 60%, #01ba0d 100%);">
                        <!-- Left info section -->
                        <div
                            style=" flex: 1 1 45%; display: flex; flex-direction: column; justify-content: flex-start; padding: 2.5rem 2rem 2rem 2.5rem; color: #fff;">
                            <div class="driver-name">
                                <div style="font-size: 1.2rem; font-weight: 400;">Gabriel</div>
                                <div
                                    style="font-size: 2.2rem; font-weight: 900; letter-spacing: 1px; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif;">
                                    Bortoleto</div>
                            </div>
                            <div style="font-size: 1.1rem; font-weight: 500; color: #e0e0e0;">
                                Kick Sauber</div>
                            <div
                                style="font-size: 2.1rem; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif; font-weight: 700; color: #fff;">
                                5</div>
                            <img src="images/brazil.png" alt="Australia Flag"
                                style="width: 36px; height: 34px; border-radius: 25px; border: 3px solid; margin-top: auto;">
                        </div>
                        <!-- Right image section -->
                        <div
                            style=" flex: 1 1 55%; display: flex; align-items: flex-end; justify-content: center; background: transparent; min-width: 220px; position: relative;">
                            <img src="images/2025-9.png" alt="Oscar Piastri"
                                style=" max-height: 260px; width: auto; object-fit: contain; margin-bottom: 0.5rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.18));">
                        </div>
                    </div>
                    <!-- five drive card -->
                    <div class="driver-section"
                        style=" display: flex; align-items: stretch; border-radius: 20px; overflow: hidden; min-height: 280px; margin-bottom: 0.5rem; box-shadow: 0 4px 32px rgba(0,0,0,0.18); width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; font-family: 'Roboto', Arial, sans-serif; background: linear-gradient(90deg, #5f6264 60%, #929597 100%);">
                        <!-- Left info section -->
                        <div
                            style=" flex: 1 1 45%; display: flex; flex-direction: column; justify-content: flex-start; padding: 2.5rem 2rem 2rem 2.5rem; color: #fff;">
                            <div class="driver-name">
                                <div style="font-size: 1.2rem; font-weight: 400;">Esteban</div>
                                <div
                                    style="font-size: 2.2rem; font-weight: 900; letter-spacing: 1px; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif;">
                                    Ocon</div>
                            </div>
                            <div style="font-size: 1.1rem; font-weight: 500; color: #e0e0e0;">
                                Haas</div>
                            <div
                                style="font-size: 2.1rem; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif; font-weight: 700; color: #fff;">
                                31</div>
                            <img src="images/france.png" alt="Australia Flag"
                                style="width: 36px; height: 34px; border-radius: 25px; border: 3px solid; margin-top: auto;">
                        </div>
                        <!-- Right image section -->
                        <div
                            style=" flex: 1 1 55%; display: flex; align-items: flex-end; justify-content: center; background: transparent; min-width: 220px; position: relative;">
                            <img src="images/2025-10.png" alt="Oscar Piastri"
                                style=" max-height: 260px; width: auto; object-fit: contain; margin-bottom: 0.5rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.18));">
                        </div>
                    </div>
                    <!-- five drive card -->
                    <div class="driver-section"
                        style=" display: flex; align-items: stretch; border-radius: 20px; overflow: hidden; min-height: 280px; margin-bottom: 0.5rem; box-shadow: 0 4px 32px rgba(0,0,0,0.18); width: 100%; max-width: 900px; margin-left: auto; margin-right: auto; font-family: 'Roboto', Arial, sans-serif; background: linear-gradient(90deg, #5f6264 60%, #929597 100%);">
                        <!-- Left info section -->
                        <div
                            style=" flex: 1 1 45%; display: flex; flex-direction: column; justify-content: flex-start; padding: 2.5rem 2rem 2rem 2.5rem; color: #fff;">
                            <div class="driver-name">
                                <div style="font-size: 1.2rem; font-weight: 400;">Oliver</div>
                                <div
                                    style="font-size: 2.2rem; font-weight: 900; letter-spacing: 1px; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif;">
                                    Bearman</div>
                            </div>
                            <div style="font-size: 1.1rem; font-weight: 500; color: #e0e0e0;">
                                Haas</div>
                            <div
                                style="font-size: 2.1rem; font-family: 'UngapBlocks', 'Roboto', Arial, sans-serif; font-weight: 700; color: #fff;">
                                87</div>
                            <img src="images/uk.png" alt="Australia Flag"
                                style="width: 36px; height: 34px; border-radius: 25px; border: 3px solid; margin-top: auto;">
                        </div>
                        <!-- Right image section -->
                        <div
                            style=" flex: 1 1 55%; display: flex; align-items: flex-end; justify-content: center; background: transparent; min-width: 220px; position: relative;">
                            <img src="images/2025-11.png" alt="Oscar Piastri"
                                style=" max-height: 260px; width: auto; object-fit: contain; margin-bottom: 0.5rem; filter: drop-shadow(0 4px 16px rgba(0,0,0,0.18));">
                        </div>
                    </div>
                </div>
        </section>
        <!-- 2025 F1 Drivers List End -->

    </main>
    <footer
        style=" position: relative; background: linear-gradient(120deg, #181818 60%, #23283b 100%); color: #f4f6fb; padding: 3.5rem 0 1.5rem 0; text-align: center; border-top: 1px solid #23283b;  box-shadow: 0 -4px 32px rgba(41,121,255,0.08);">
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