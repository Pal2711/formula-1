<?php
require_once 'config.php';

// Check if user is logged in
if (!isLoggedIn()) {
    header("Location: login.php?redirect=book_ticket.php?race_id=" . $_GET['race_id']);
    exit();
}

$raceId = isset($_GET['race_id']) ? intval($_GET['race_id']) : 0;
$message = '';
$messageType = '';

if ($raceId <= 0) {
    header("Location: index.php");
    exit();
}

$pdo = getDBConnection();

// Get race details
$stmt = $pdo->prepare("SELECT * FROM races WHERE id = ?");
$stmt->execute([$raceId]);
$race = $stmt->fetch();

if (!$race) {
    header("Location: index.php");
    exit();
}

// Get ticket types for this race
$stmt = $pdo->prepare("SELECT * FROM ticket_types WHERE race_id = ? ORDER BY price ASC");
$stmt->execute([$raceId]);
$ticketTypes = $stmt->fetchAll();

// Handle booking submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticketTypeId = intval($_POST['ticket_type_id']);
    $quantity = intval($_POST['quantity']);

    if ($quantity <= 0) {
        $message = 'Invalid quantity';
        $messageType = 'error';
    } else {
        try {
            // Get ticket type details
            $stmt = $pdo->prepare("SELECT * FROM ticket_types WHERE id = ? AND race_id = ?");
            $stmt->execute([$ticketTypeId, $raceId]);
            $ticketType = $stmt->fetch();

            if (!$ticketType) {
                $message = 'Invalid ticket type';
                $messageType = 'error';
            } elseif ($ticketType['available_quantity'] < $quantity) {
                $message = 'Not enough tickets available';
                $messageType = 'error';
            } else {
                // Calculate total amount
                $totalAmount = $ticketType['price'] * $quantity;

                // Start transaction
                $pdo->beginTransaction();

                try {
                    // Insert booking
                    $stmt = $pdo->prepare("INSERT INTO bookings (user_id, race_id, ticket_type_id, quantity, total_amount, status) VALUES (?, ?, ?, ?, ?, 'confirmed')");
                    $stmt->execute([$_SESSION['user_id'], $raceId, $ticketTypeId, $quantity, $totalAmount]);

                    // Update available quantity
                    $stmt = $pdo->prepare("UPDATE ticket_types SET available_quantity = available_quantity - ? WHERE id = ?");
                    $stmt->execute([$quantity, $ticketTypeId]);

                    // Commit and redirect
                    $pdo->commit();
                    header("Location: bookings.php");
                    exit();

                } catch (Exception $e) {
                    $pdo->rollBack();
                    $message = 'Booking failed: ' . $e->getMessage();
                    $messageType = 'error';
                }
            }
        } catch (PDOException $e) {
            $message = 'Database error: ' . $e->getMessage();
            $messageType = 'error';
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>F1 Race - Book Tickets <?php echo htmlspecialchars($race['race_name']); ?></title>
    <link rel="icon" href="images/nav_icon.png" type="image/png">

    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
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
        <div class="bookticket-mainpage" style="padding: 6% 0;">
            <div class="container">
                <div style="max-width: 1400px; margin: 0 auto;">
                    <h1 style="text-align: center; color: #f4f6fb; margin-bottom: 2rem;">Book Tickets</h1>

                    <!-- Race Information -->
                    <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1); margin-bottom: 2rem;">
                        <h2 style="color: #181818; margin-bottom: 1rem;"><?php echo htmlspecialchars($race['race_name']); ?></h2>
                        <p style="color: #181818;"><strong>Track:</strong> <?php echo htmlspecialchars($race['track_name']); ?></p>
                        <p style="color: #181818;"><strong>Location:</strong> <?php echo htmlspecialchars($race['location']); ?></p>
                        <p style="color: #181818;"><strong>Date:</strong> <?php echo date('F j, Y', strtotime($race['race_date'])); ?></p>
                        <p style="color: #181818;"><strong>Time:</strong> <?php echo date('g:i A', strtotime($race['race_time'])); ?></p>
                        <p style="color: #181818;"><strong>Description:</strong> <?php echo htmlspecialchars($race['description']); ?></p>
                    </div>

                    <?php if ($message): ?>
                        <div class="message <?php echo $messageType; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <!-- Ticket Types -->
                    <div style="background: white; padding: 2rem; border-radius: 10px; box-shadow: 0 5px 15px rgba(0,0,0,0.1);">
                        <h3 style="color: #181818; margin-bottom: 1.5rem;">Available Ticket Types</h3>

                        <?php foreach ($ticketTypes as $ticketType): ?>
                            <div style="border: 1px solid #ddd; border-radius: 5px; padding: 1.5rem; margin-bottom: 1rem;">
                                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
                                    <h4 style="color: #181818;"><?php echo htmlspecialchars($ticketType['ticket_type']); ?></h4>
                                    <span style="font-size: 1.2rem; font-weight: bold; color: #181818;">$<?php echo number_format($ticketType['price'], 2); ?></span>
                                </div>
                                <p style="color: #666; margin-bottom: 1rem;"><?php echo htmlspecialchars($ticketType['description']); ?></p>
                                <p style="color: #888; margin-bottom: 1rem;">Available: <?php echo $ticketType['available_quantity']; ?> tickets</p>

                                <?php if ($ticketType['available_quantity'] > 0): ?>
                                    <form method="POST" style="display: flex; gap: 1rem; align-items: center;" onsubmit="return confirm('Are you sure you want to book this ticket?');">
                                        <input type="hidden" name="ticket_type_id" value="<?php echo $ticketType['id']; ?>">
                                        <label for="quantity_<?php echo $ticketType['id']; ?>">Quantity:</label>
                                        <input type="number" id="quantity_<?php echo $ticketType['id']; ?>" name="quantity"
                                            min="1" max="<?php echo $ticketType['available_quantity']; ?>" value="1"
                                            style="width: 80px; padding: 5px; border: 1px solid #ddd; border-radius: 3px;">
                                        <button type="submit" class="btn" style="background-color: #121212;">Book Now</button>
                                    </form>
                                <?php else: ?>
                                    <p style="color: #181818; font-weight: bold;">SOLD OUT</p>
                                <?php endif; ?>
                            </div>
                        <?php endforeach; ?>
                    </div>

                    <div style="text-align: center; margin-top: 5rem;">
                        <a href="index.php" class="btn btn-secondary"
                            style="text-decoration: none; padding: 20px 35px; color: #fff; background:#6c757d; border-radius:8px; transition:0.3s;">
                            Back to Home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer style="background: linear-gradient(120deg, #181818 60%, #23283b 100%); color: #f4f6fb; padding: 3.5rem 0 1.5rem 0; text-align: center; border-top: 1px solid #23283b; box-shadow: 0 -4px 32px rgba(41,121,255,0.08);">
        <div class="container" style="max-width: 1200px; margin: 0 auto;">
            <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: flex-start; gap: 2.5rem; padding-bottom: 2.2rem; border-bottom: 1px solid #23283b;">
                <div style="flex:1; min-width:max-content; text-align:center;">
                    <div style="font-size: 2rem; font-weight: 700; letter-spacing: 2px; display: flex; align-items: center; gap: 0.5rem;">
                        <span style="font-size:2.2rem;">🏁</span>
                        <span style="color:#ff1e1e; font-size:2.2rem; font-weight:900; letter-spacing:1px;">F1</span>
                        Ticket Booking
                    </div>
                    <div style="margin-top: 0.7rem; color: #b0b8c1; font-size: 1.1rem;">
                        Your gateway to the world of Formula 1. Book, experience, and enjoy the thrill of racing!
                    </div>
                </div>

                <nav style="flex:1; min-width:max-content; text-align:center;">
                    <div style="font-weight:600; margin-bottom:0.7rem; font-size:1.1rem;">Quick Links</div>
                    <a href="index.php" style="color: #f4f6fb; text-decoration: none; display:block; margin-bottom:0.4rem;">Home</a>
                    <a href="About.php" style="color: #f4f6fb; text-decoration: none; display:block; margin-bottom:0.4rem;">About</a>
                    <a href="races.php" style="color: #f4f6fb; text-decoration: none; display:block; margin-bottom:0.4rem;">Races</a>
                    <a href="Reachout.php" style="color: #f4f6fb; text-decoration: none; display:block; margin-bottom:0.4rem;">Feedback</a>
                </nav>

                <div style="flex:1; min-width:max-content; text-align:left;">
                    <div style="font-weight:600; margin-bottom:0.7rem; font-size:1.1rem;">Stay Connected</div>
                    <div style="display:flex; flex-direction:column; gap:0.7rem; margin-bottom:1.2rem;">
                        <a href="#" title="Twitter"><span><img src="images/x-icon.png"></span></a>
                        <a href="#" title="Facebook"><span><img src="images/facbook-icon.png"></span></a>
                        <a href="#" title="Instagram"><span><img src="images/ins-icon.png"></span></a>
                    </div>
                </div>

                <div style="flex:1; min-width:200px; text-align:left;">
                    <div style="font-weight:600; margin-bottom:0.7rem; font-size:1.1rem;">Contact Us</div>
                    <div style="color:#b0b8c1; font-size:1rem; margin-bottom:0.3rem;">
                        Email: <a href='mailto:info@f1tickets.com' style='color:#f4f6fb; text-decoration:underline;'>info@f1tickets.com</a>
                    </div>
                    <div style="color:#b0b8c1; font-size:1rem;">
                        Phone: <a href='tel:+1234567890' style='color:#f4f6fb; text-decoration:underline;'>+1 234 567 890</a>
                    </div>
                </div>

                <div style="margin-top: 2.2rem; font-size: 0.98rem; color: #b0b8c1;">
                    &copy; <?php echo date('Y'); ?> F1 Ticket Booking. All rights reserved.
                </div>
            </div>
        </div>
    </footer>

    <script src="js/script.js"></script>
   
</body>
</html>
