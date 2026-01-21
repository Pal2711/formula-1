<?php
// admin/login.php

include '../user/config.php';

if (session_status() === PHP_SESSION_NONE) {
  session_start();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
  $username = $_POST['username'];
  $password = $_POST['password'];

  if ($username === 'admin' && $password === 'admin123') {
    $_SESSION['admin_logged_in'] = true;
    header('Location: index.php');
    exit();
  } else {
    $error = "Invalid username or password.";
  }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />
  <title>Admin Login</title>
  <link rel="icon" href="image/nav_icon.png" type="image/png">

  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">

  <style>
    * {
      box-sizing: border-box;
      margin: 0;
      padding: 0;
      font-family: 'Poppins', sans-serif;
    }

    html,
    body {
      height: 100%;
      width: 100%;
    }

    .video-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100vw;
      height: 100vh;
      object-fit: cover;
      z-index: -1;
    }

    .login-wrapper {
      position: relative;
      z-index: 1;
      display: flex;
      align-items: center;
      justify-content: center;
      height: 100vh;
      width: 100%;
      background: rgba(0, 0, 0, 0.4);
    }

    .login-box {
      background: rgba(255, 255, 255, 0.08);
      border: 1px solid rgba(255, 255, 255, 0.2);
      padding: 2rem;
      border-radius: 15px;
      width: 100%;
      max-width: 400px;
      color: white;
      box-shadow: 0 0 20px rgba(0, 0, 0, 0.6);
    }

    .login-box h2 {
      text-align: center;
      margin-bottom: 1.5rem;
      font-weight: 600;
      color: #fff;
    }

    .form-group {
      margin-bottom: 1.2rem;
    }

    label {
      display: block;
      margin-bottom: 0.5rem;
      color: #ddd;
      font-size: 0.95rem;
    }

    input[type="text"],
    input[type="password"] {
      width: 100%;
      padding: 0.6rem;
      border: none;
      border-radius: 8px;
      background: rgba(255, 255, 255, 0.1);
      color: #fff;
      font-size: 1rem;
      backdrop-filter: blur(3px);
    }

    input::placeholder {
      color: rgba(255, 255, 255, 0.5);
    }

    button {
      width: 100%;
      padding: 0.7rem;
      background: rgba(0, 123, 255, 0.2);
      /* soft transparent blue */
      border: 1px solid rgba(255, 255, 255, 0.3);
      border-radius: 12px;
      color: #ffffff;
      font-weight: 600;
      font-size: 1rem;
      backdrop-filter: blur(3px);
      box-shadow: 0 0 10px rgba(0, 123, 255, 0.2);
      transition: all 0.3s ease;
    }

    button:hover {
      background: rgba(0, 123, 255, 0.4);
      box-shadow: 0 0 15px rgba(0, 123, 255, 0.5);
      transform: scale(1.02);
    }

    .error {
      color: #ff6b6b;
      text-align: center;
      margin-bottom: 1rem;
    }
  </style>
</head>

<body>

  <!-- Background Video -->
  <video autoplay muted loop playsinline class="video-bg">
    <source src="image/login1.mp4" type="video/mp4" />
    Your browser does not support the video tag.
  </video>

  <div class="login-wrapper">
    <div class="login-box">
      <h2>Admin Login</h2>

      <?php if (isset($error)): ?>
        <p class="error"><?php echo $error; ?></p>
      <?php endif; ?>

      <form method="POST" action="login.php">
        <div class="form-group">
          <label for="username">Username</label>
          <input type="text" id="username" name="username" placeholder="Enter username" required />
        </div>
        <div class="form-group">
          <label for="password">Password</label>
          <input type="password" id="password" name="password" placeholder="Enter password" required />
        </div>
        <button type="submit">Login</button>
      </form>
    </div>
  </div>

</body>

</html>