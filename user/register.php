<?php
require_once 'config.php';
session_start();

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = trim($_POST['username']);
  $email = trim($_POST['email']);
  $password = $_POST['password'];
  $confirmPassword = $_POST['confirm_password'];
  $fullName = trim($_POST['full_name']);
  $phone = trim($_POST['phone']);

  // Validation
  if (empty($username) || empty($email) || empty($password) || empty($fullName)) {
    $message = 'All required fields must be filled';
    $messageType = 'error';
  } elseif ($password !== $confirmPassword) {
    $message = 'Passwords do not match';
    $messageType = 'error';
  } elseif (strlen($password) < 6) {
    $message = 'Password must be at least 6 characters long';
    $messageType = 'error';
  } else {
    try {
      $pdo = getDBConnection();

      // Check if username or email already exists
      $stmt = $pdo->prepare("SELECT id FROM users WHERE username = ? OR email = ?");
      $stmt->execute([$username, $email]);

      if ($stmt->fetch()) {
        $message = 'Username or email already exists';
        $messageType = 'error';
      } else {
        // Hash password and insert user
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

        $stmt = $pdo->prepare("INSERT INTO users (username, email, password, full_name, phone) VALUES (?, ?, ?, ?, ?)");
        $stmt->execute([$username, $email, $hashedPassword, $fullName, $phone]);

        // Store success message in session
        $_SESSION['register_success'] = "Registration successful! Please login to continue.";

        // Redirect to login page
        header("Location: login.php");
        exit();
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
  <title>F1 Race - Register</title>
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
    <div class="register-container" style="padding: 90px 0; background-image: url('images/login.jpg'); background-size: cover; background-position: center; background-repeat: no-repeat;">
      <div class="container">
        <div class="form-container">
          <h2 style="text-align: center; color: #121212; margin-bottom: 2rem;">Create Account</h2>

          <?php if ($message): ?>
            <div class="message <?php echo $messageType; ?>" style="text-align:center; padding:10px; border-radius:5px; 
                 <?php echo $messageType === 'error' ? 'background:#dc3545; color:white;' : 'background:#28a745; color:white;'; ?>">
              <?php echo htmlspecialchars($message); ?>
            </div>
          <?php endif; ?>

          <form method="POST">
            <div class="form-group">
              <label for="username">Username *</label>
              <input type="text" id="username" name="username" required value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
            </div>

            <div class="form-group">
              <label for="email">Email *</label>
              <input type="email" id="email" name="email" required
                value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>">
            </div>

            <div class="form-group">
              <label for="full_name">Full Name *</label>
              <input type="text" id="full_name" name="full_name" required
                value="<?php echo isset($_POST['full_name']) ? htmlspecialchars($_POST['full_name']) : ''; ?>">
            </div>

            <div class="form-group">
              <label for="phone">Phone Number</label>
              <input type="tel" id="phone" name="phone"
                value="<?php echo isset($_POST['phone']) ? htmlspecialchars($_POST['phone']) : ''; ?>">
            </div>

            <div class="form-group">
              <label for="password">Password *</label>
              <input type="password" id="password" name="password" required minlength="6">
            </div>

            <div class="form-group">
              <label for="confirm_password">Confirm Password *</label>
              <input type="password" id="confirm_password" name="confirm_password" required minlength="6">
            </div>

            <button type="submit" class="btn">Register</button>
          </form>

          <p style="text-align: center; margin-top: 1rem;">
            Already have an account? <a href="login.php" style="color: #ffe7e6;">Login here</a>
          </p>
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
            <span style="color:#ff1e1e; font-size:2.2rem; font-weight:900; letter-spacing:1px;">F1</span> Ticket Booking
          </div>
          <div style="margin-top: 0.7rem; color: #b0b8c1; font-size: 1.1rem;">
            Your gateway to the world of Formula 1. Book,<br> experience, and enjoy the thrill of racing!
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
            <a href="#" title="Twitter"><span> <img src="images/x-icon.png"></span></a>
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
      </div>
      <div style="margin-top: 2.2rem; font-size: 0.98rem; color: #b0b8c1;">&copy; <?php echo date('Y'); ?> F1 Ticket Booking. All rights reserved.</div>
    </div>
  </footer>

  <script async src='https://d2mpatx37cqexb.cloudfront.net/delightchat-whatsapp-widget/embeds/embed.min.js'></script>
  <script>
    var wa_btnSetting = {
      "btnColor": "#16BE45", "ctaText": "", "cornerRadius": 40, "marginBottom": 20,
      "marginLeft": 20, "marginRight": 20, "btnPosition": "right", "whatsAppNumber": "6356497821",
      "welcomeMessage": "Welcome to F1 Car Booking – Your race to the thrill begins here!",
      "zIndex": 999999, "btnColorScheme": "light"
    };
    window.onload = () => { _waEmbed(wa_btnSetting); };
  </script>
</body>
</html>
