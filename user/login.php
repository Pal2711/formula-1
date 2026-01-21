<?php
ob_start();
session_start();
require_once 'config.php';

$message = '';
$messageType = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = trim($_POST['username']);
    $password = $_POST['password'];

    if (empty($username) || empty($password)) {
        $message = 'Username and password are required';
        $messageType = 'error';
    } else {
        try {
            $pdo = getDBConnection();
            $stmt = $pdo->prepare("SELECT id, username, password, full_name FROM users WHERE username = ? OR email = ?");
            $stmt->execute([$username, $username]);
            $user = $stmt->fetch();

            if ($user && password_verify($password, $user['password'])) {
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['full_name'] = $user['full_name'];

                $redirect = isset($_GET['redirect']) ? $_GET['redirect'] : 'index.php';
                header("Location: $redirect");
                exit();
            } else {
                $message = 'Invalid username or password';
                $messageType = 'error';
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
    <title>F1 Race - Login</title>
    <link rel="icon" href="images/nav_icon.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;400;500;700&display=swap" rel="stylesheet">
</head>

<body>
    <header class="sticky">
        <nav class="navbar">
            <div class="nav-container">
                <a href="index.php">
                    <img src="images/main_logo.png" alt="F1 Hero" height="70px" width="80px" style="object-fit:cover;">
                </a>
                <ul class="nav-menu">
                    <li><a href="index.php">Home</a></li>
                    <li><a href="About.php">About us</a></li>
                    <li><a href="driver.php">Driver</a></li>
                    <li><a href="team.php">Team</a></li>
                    <li><a href="races.php">Races</a></li>

                    <li><a href="login.php">Login</a></li>
                </ul>
            </div>
        </nav>
    </header>

    <main>
        <div class="login-container"
            style="padding: 90px 0; background-image: url('images/login.jpg'); background-size: cover; background-position: center;">
            <div class="container">
                <div class="form-container">
                    <h2 style="text-align: center; color: #121212; margin-bottom: 2rem;">Login ere</h2>

                    <?php if ($message): ?>
                        <div class="message <?php echo $messageType; ?>">
                            <?php echo htmlspecialchars($message); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST">
                        <div class="form-group">
                            <label for="username">Username or Email</label>
                            <input type="text" id="username" name="username" required
                                value="<?php echo isset($_POST['username']) ? htmlspecialchars($_POST['username']) : ''; ?>">
                        </div>

                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" id="password" name="password" required>
                        </div>

                        <button type="submit" class="btn">Login</button>
                    </form>

                    <p style="text-align: center; margin-top: 1rem;">
                        Don't have an account? <a href="register.php" style="color: #ffe7e6;">Register here</a>
                    </p>
                </div>
            </div>
        </div>
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
                        <span style="font-size:2.2rem;">🏁</span>
                        <span style="color:#ff1e1e; font-size:2.2rem; font-weight:900; letter-spacing:1px;">F1</span>
                        Ticket Booking
                    </div>
                    <div style="margin-top: 0.7rem; color: #b0b8c1; font-size: 1.1rem;">
                        Your gateway to the world of Formula 1. Book,<br> experience, and enjoy the thrill of racing!
                    </div>
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
                        <a href="#" title="Twitter"><img src="images/x-icon.png" alt="Twitter Icon"></a>
                        <a href="#" title="Facebook"><img src="images/facbook-icon.png" alt="Facebook Icon"></a>
                        <a href="#" title="Instagram"><img src="images/ins-icon.png" alt="Instagram Icon"></a>
                    </div>
                </div>

                <!-- Contact Us -->
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
            </div>
            <div style="margin-top: 2.2rem; font-size: 0.98rem; color: #b0b8c1;">&copy; <?php echo date('Y'); ?> F1
                Ticket Booking. All rights reserved.</div>
        </div>
    </footer>
</body>

</html>