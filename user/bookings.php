<?php
require_once 'config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: login.php?redirect=bookings.php");
    exit();
}

$pdo = getDBConnection();

// Get user's bookings
$stmt = $pdo->prepare("
    SELECT b.*, r.race_name, r.track_name, r.location, r.race_date, r.race_time, 
           tt.ticket_type, tt.price
    FROM bookings b
    JOIN races r ON b.race_id = r.id
    JOIN ticket_types tt ON b.ticket_type_id = tt.id
    WHERE b.user_id = ?
    ORDER BY b.booking_date DESC
");
$stmt->execute([$_SESSION['user_id']]);
$bookings = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F1 Race - My Bookings</title>
    <link rel="icon" href="images/nav_icon.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="sticky">
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
        <div class="booking-section">
            <div class="container">
                <h1 style="text-align: center; color: #f4f6fb; margin-bottom: 2rem; padding-top: 100px;">My Bookings
                </h1>

                <!-- ✅ Success message after booking -->
                <?php if (isset($_SESSION['booking_success'])): ?>
                    <div
                        style="background: #28a745; color: white; padding: 1rem; border-radius: 5px; text-align: center; margin-bottom: 1.5rem;">
                        <?php
                        echo htmlspecialchars($_SESSION['booking_success']);
                        unset($_SESSION['booking_success']); // Show only once
                        ?>
                    </div>
                <?php endif; ?>

                <?php if (empty($bookings)): ?>
                    <div
                        style="text-align: center; background: white; padding: 3rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <h2 style="color: #666; margin-bottom: 1rem;">No bookings found</h2>
                        <p style="color: #888; margin-bottom: 2rem;">You haven't booked any tickets yet.</p>
                        <a href="index.php" class="btn">Browse Races</a>
                    </div>
                <?php else: ?>
                    <div
                        style="background: white; border-radius: 10px; overflow: hidden; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>Booking ID</th>
                                    <th>Race</th>
                                    <th>Track</th>
                                    <th>Location</th>
                                    <th>Date</th>
                                    <th>Ticket Type</th>
                                    <th>Quantity</th>
                                    <th>Total Amount</th>
                                    <th>Status</th>
                                    <th>Booked On</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach ($bookings as $booking): ?>
                                    <tr>
                                        <td>#<?php echo $booking['id']; ?></td>
                                        <td><?php echo htmlspecialchars($booking['race_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['track_name']); ?></td>
                                        <td><?php echo htmlspecialchars($booking['location']); ?></td>
                                        <td><?php echo date('M j, Y', strtotime($booking['race_date'])); ?><br>
                                            <small><?php echo date('g:i A', strtotime($booking['race_time'])); ?></small>
                                        </td>
                                        <td><?php echo htmlspecialchars($booking['ticket_type']); ?></td>
                                        <td><?php echo $booking['quantity']; ?></td>
                                        <td>$<?php echo number_format($booking['total_amount'], 2); ?></td>
                                        <td>
                                            <span style="
                                                padding: 4px 8px; 
                                                border-radius: 3px; 
                                                font-size: 0.8rem; 
                                                font-weight: bold;
                                                color: white;
                                                background-color: <?php
                                                switch ($booking['status']) {
                                                    case 'confirmed':
                                                        echo '#28a745';
                                                        break;
                                                    case 'pending':
                                                        echo '#ffc107';
                                                        break;
                                                    case 'cancelled':
                                                        echo '#dc3545';
                                                        break;
                                                    default:
                                                        echo '#6c757d';
                                                }
                                                ?>">
                                                <?php echo strtoupper($booking['status']); ?>
                                            </span>
                                        </td>
                                        <td><?php echo date('M j, Y g:i A', strtotime($booking['booking_date'])); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>

                    <div style="text-align: center; margin-top: 2rem;">
                        <p style="color: #666; padding-bottom: 50px;">
                            Total Bookings: <?php echo count($bookings); ?> |
                            Total Amount:
                            $<?php echo number_format(array_sum(array_column($bookings, 'total_amount')), 2); ?>
                        </p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer
        style="background: linear-gradient(120deg, #181818 60%, #23283b 100%); color: #f4f6fb; padding: 3.5rem 0 1.5rem 0; text-align: center; border-top: 1px solid #23283b; box-shadow: 0 -4px 32px rgba(41,121,255,0.08);">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div
                style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 2.5rem; padding-bottom: 2.2rem; border-bottom: 1px solid #23283b;">
                <div style="flex:1; min-width:max-content; text-align:center;">
                    <div
                        style="font-size: 2rem; font-weight: 700; letter-spacing: 2px; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size:2.2rem;">🏁</span>
                        <span style="color:#ff1e1e; font-size:2.2rem; font-weight:900; letter-spacing:1px;">F1</span>
                        Ticket Booking
                    </div>
                    <div style="margin-top: 0.7rem; color: #b0b8c1; font-size: 1.1rem;">
                        Your gateway to the world of Formula 1.
                        Book,<br> experience, and enjoy the thrill of racing!
                    </div>
                </div>

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

                <div style="flex:1; min-width:max-content; text-align:left;">
                    <div style="font-weight:600; margin-bottom:0.7rem; font-size:1.1rem;">Stay Connected</div>
                    <div style="display:flex; flex-direction:column; gap:0.7rem; margin-bottom:1.2rem;">
                        <a href="#"><img src="images/x-icon.png" alt="Twitter"></a>
                        <a href="#"><img src="images/facbook-icon.png" alt="Facebook"></a>
                        <a href="#"><img src="images/ins-icon.png" alt="Instagram"></a>
                    </div>
                </div>

                <div style="flex:1; min-width:200px; text-align:left;">
                    <div style="font-weight:600; margin-bottom:0.7rem; font-size:1.1rem;">Contact Us</div>
                    <div style="color:#b0b8c1; font-size:1rem; margin-bottom:0.3rem;">
                        Email: <a href='mailto:info@f1tickets.com'
                            style='color:#f4f6fb; text-decoration:underline;'>info@f1tickets.com</a>
                    </div>
                    <div style="color:#b0b8c1; font-size:1rem;">
                        Phone: <a href='tel:+1234567890' style='color:#f4f6fb; text-decoration:underline;'>+1 234 567
                            890</a>
                    </div>
                </div>

                <div style="margin-top: 2.2rem; font-size: 0.98rem; color: #b0b8c1;">
                    &copy; <?php echo date('Y'); ?> F1 Ticket Booking. All rights reserved.
                </div>
            </div>
    </footer>

    <script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
    <script>
        var wa_btnSetting = {
            "btnColor": "#16BE45",
            "ctaText": "",
            "cornerRadius": 40,
            "marginBottom": 20,
            "marginLeft": 20,
            "marginRight": 20,
            "btnPosition": "right",
            "whatsAppNumber": "6356497821",
            "welcomeMessage": "Welcome to F1 Car Booking – Your race to the thrill begins here!",
            "zIndex": 999999,
            "btnColorScheme": "light"
        };
        window.onload = () => {
            _waEmbed(wa_btnSetting);
        };
    </script>

</body>

</html>