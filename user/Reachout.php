<?php
require_once 'config.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $name = trim($_POST['name']);
  $userMessage = trim($_POST['message']);

  if (empty($name) || empty($userMessage)) {
    $message = 'Both fields are required';
    $messageType = 'error';
  } else {
    try {
      // Save message using function
      saveContactMessage($name, $userMessage);

      $message = 'Message submitted successfully!';
      $messageType = 'success';
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
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>F1 Race - Feedback</title>
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
    <div class="feedback-main-section"style="padding: 90px 0; background-image: url('images/feedback.jpg'); background-size: cover; background-position: center;">
      <div class="container">
      <div class="form-container">
        <h2 style="text-align: center; color: #121212; margin-bottom: 2rem;">Send Us a Message</h2>

        <?php if ($message): ?>
          <div class="message <?php echo $messageType; ?>">
            <?php echo htmlspecialchars($message); ?>
          </div>
        <?php endif; ?>

        <form method="POST">
          <div class="form-group">
            <label for="name">Name *</label>
            <input type="text" id="name" name="name" required value="<?php
            if (isset($_POST['name'])) {
              echo htmlspecialchars($_POST['name']);
            } elseif (isLoggedIn()) {
              echo htmlspecialchars(getCurrentUser()['username']);
            }
            ?>">

          </div>

          <div class="form-group">
            <label for="message">Message *</label>
            <textarea id="message" name="message" required
              rows="5"><?php echo isset($_POST['message']) ? htmlspecialchars($_POST['message']) : ''; ?></textarea>
          </div>

          <button type="submit" class="btn">Submit</button>
        </form>
      </div>
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
            <span style="font-size:2.2rem;">🏁</span> <span
              style="color:#ff1e1e; font-size:2.2rem; font-weight:900; letter-spacing:1px;">F1</span> Ticket Booking
          </div>
          <div style="margin-top: 0.7rem; color: #b0b8c1; font-size: 1.1rem;">Your gateway to the world of Formula
            1.<br>Book, experience, and enjoy the thrill of racing!</div>
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