<?php
// admin/index.php

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// ✅ Redirect if not logged in as admin
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// ✅ Include correct config path
include '../user/config.php';
$pdo = getDBConnection();

// ✅ Overall Statistics
$stats = [];

// Total users
$stmt = $pdo->query("SELECT COUNT(*) FROM users");
$stats['total_users'] = $stmt->fetchColumn();

// Today's new users
$stmt = $pdo->query("SELECT COUNT(*) FROM users WHERE DATE(created_at) = CURDATE()");
$stats['today_users'] = $stmt->fetchColumn();

// Booking stats: total, revenue, confirmed, pending, today
$stmt = $pdo->query("
    SELECT 
        COUNT(*) AS total_bookings,
        IFNULL(SUM(total_amount), 0) AS total_revenue,
        COUNT(CASE WHEN status = 'confirmed' THEN 1 END) AS confirmed_bookings,
        COUNT(CASE WHEN status = 'pending' THEN 1 END) AS pending_bookings,
        COUNT(CASE WHEN DATE(booking_date) = CURDATE() THEN 1 END) AS today_bookings
    FROM bookings
");
$bookingStats = $stmt->fetch();
$stats = array_merge($stats, $bookingStats);

// Race stats: total, upcoming, past
$stmt = $pdo->query("
    SELECT 
        COUNT(*) AS total_races,
        COUNT(CASE WHEN race_date > CURDATE() THEN 1 END) AS upcoming_races,
        COUNT(CASE WHEN race_date <= CURDATE() THEN 1 END) AS past_races
    FROM races
");
$raceStats = $stmt->fetch();
$stats = array_merge($stats, $raceStats);

// ✅ Feedback count
$stmt = $pdo->query("SELECT COUNT(*) FROM reachout");
$stats['feedback_count'] = $stmt->fetchColumn();

// ✅ Recent 5 Bookings with User and Race info
$stmt = $pdo->query("
    SELECT b.*, u.full_name, u.email, r.race_name, r.location
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN races r ON b.race_id = r.id
    ORDER BY b.booking_date DESC
    LIMIT 5
");
$recentBookings = $stmt->fetchAll();

// ✅ Next 5 Upcoming Races
$stmt = $pdo->query("
    SELECT r.*, COUNT(b.id) AS booking_count
    FROM races r
    LEFT JOIN bookings b ON r.id = b.race_id
    WHERE r.race_date > CURDATE()
    GROUP BY r.id
    ORDER BY r.race_date ASC
    LIMIT 5
");
$upcomingRaces = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - F1 Ticket Booking</title>
    <link rel="icon" href="image/nav_icon.png" type="image/png">
    <link rel="stylesheet" href="css/style.css">
    <style>
        .admin-container {
            max-width: 1400px;
            margin: 0 auto;
            padding: 20px;
            background: #f4f6fb;
            min-height: 100vh;
        }

        .admin-header {
            background: #23283b;
            color: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 30px;
        }

        .admin-nav {
            display: flex;
            gap: 10px;
            margin-top: 15px;
        }

        .btn {
            padding: 10px 20px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            font-weight: 500;
        }

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-danger {
            background: #dc3545;
            color: white;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }

        .stat-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            text-align: center;
        }

        .stat-number {
            font-size: 32px;
            font-weight: bold;
            color: #23283b;
            margin-bottom: 5px;
        }

        .stat-label {
            color: #666;
            font-size: 14px;
        }

        .dashboard-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 20px;
        }

        .dashboard-card {
            background: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .dashboard-card h3 {
            margin-top: 0;
            color: #23283b;
            border-bottom: 2px solid #007bff;
            padding-bottom: 10px;
        }

        .recent-item {
            padding: 10px 0;
            border-bottom: 1px solid #eee;
        }

        .recent-item:last-child {
            border-bottom: none;
        }

        .status-confirmed {
            color: #28a745;
            font-weight: bold;
        }

        .status-pending {
            color: #ffc107;
            font-weight: bold;
        }

        .status-cancelled {
            color: #dc3545;
            font-weight: bold;
        }

        @media (max-width: 768px) {
            .dashboard-grid {
                grid-template-columns: 1fr;
            }
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <div class="admin-title-img">
                <img src="image/main_logo.png" alt="F1 Hero" height="70px" width="80px" object-fit="cover">
                <h1> Ticket Booking - Admin Dashboard</h1>
            </div>
            <p>Welcome back! Here's an overview of your F1 ticket booking system.</p>


            <div class="admin-nav">
                <a href="index.php" class="btn btn-primary">🏠 Go to the Dashboard</a>
                <a href="manage_users.php" class="btn btn-primary">👥 Manage Users</a>
                <a href="manage_races.php" class="btn btn-primary">🏎️ Manage Races</a>
                <a href="manage_feedback.php" class="btn btn-primary">👻 Manage feedback</a>
                <a href="manage_bookings.php" class="btn btn-primary">🎫 Manage Bookings</a>

                <a href="logout.php" class="btn btn-danger">🔓 Logout</a>
            </div>
        </div>


        <!-- Statistics Cards -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo number_format($stats['total_users']); ?></div>
                <div class="stat-label">Total Users</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo number_format($stats['total_bookings']); ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$<?php echo number_format($stats['total_revenue'], 2); ?></div>
                <div class="stat-label">Total Revenue</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo number_format($stats['total_races']); ?></div>
                <div class="stat-label">Total Races</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo number_format($stats['confirmed_bookings']); ?></div>
                <div class="stat-label">Confirmed Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo number_format($stats['feedback_count']); ?></div>
                <div class="stat-label">Feedback</div>
            </div>


        </div>

        <!-- Dashboard Content -->
        <div class="dashboard-grid">
            <!-- Recent Bookings -->
            <div class="dashboard-card">
                <h3>Recent Bookings</h3>
                <?php if (empty($recentBookings)): ?>
                    <p style="color: #666; text-align: center; padding: 20px;">No recent bookings</p>
                <?php else: ?>
                    <?php foreach ($recentBookings as $booking): ?>
                        <div class="recent-item">
                            <strong><?php echo htmlspecialchars($booking['full_name']); ?></strong>
                            <span class="status-<?php echo $booking['status']; ?>" style="float: right;">
                                <?php echo strtoupper($booking['status']); ?>
                            </span><br>
                            <small>
                                <?php echo htmlspecialchars($booking['race_name']); ?> -
                                $<?php echo number_format($booking['total_amount'], 2); ?>
                            </small><br>
                            <small style="color: #666;">
                                <?php echo date('M j, Y g:i A', strtotime($booking['booking_date'])); ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                    <div style="text-align: center; margin-top: 15px;">
                        <a href="manage_bookings.php" class="btn btn-primary">View All Bookings</a>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Upcoming Races -->
            <div class="dashboard-card">
                <h3>Upcoming Races</h3>
                <?php if (empty($upcomingRaces)): ?>
                    <p style="color: #666; text-align: center; padding: 20px;">No upcoming races</p>
                <?php else: ?>
                    <?php foreach ($upcomingRaces as $race): ?>
                        <div class="recent-item">
                            <strong><?php echo htmlspecialchars($race['race_name']); ?></strong>
                            <span style="float: right; color: #007bff; font-weight: bold;">
                                <?php echo $race['booking_count']; ?> bookings
                            </span><br>
                            <small>
                                📍 <?php echo htmlspecialchars($race['location']); ?>
                            </small><br>
                            <small style="color: #666;">
                                📅 <?php echo date('M j, Y g:i A', strtotime($race['race_date'] . ' ' . $race['race_time'])); ?>
                            </small>
                        </div>
                    <?php endforeach; ?>
                    <div style="text-align: center; margin-top: 15px;">
                        <a href="manage_races.php" class="btn btn-primary">View All Races</a>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Quick Stats -->
        <div
            style="background: white; padding: 20px; border-radius: 8px; margin-top: 20px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3 style="color: #23283b; margin-top: 0;">Today's Activity</h3>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 20px;">
                <div style="text-align: center;">
                    <div style="font-size: 24px; font-weight: bold; color: #007bff;">
                        <?php echo number_format($stats['today_users']); ?>
                    </div>
                    <div style="color: #666;">New Users Today</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 24px; font-weight: bold; color: #28a745;">
                        <?php echo number_format($stats['today_bookings']); ?>
                    </div>
                    <div style="color: #666;">Bookings Today</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 24px; font-weight: bold; color: #ffc107;">
                        <?php echo number_format($stats['upcoming_races']); ?>
                    </div>
                    <div style="color: #666;">Upcoming Races</div>
                </div>
                <div style="text-align: center;">
                    <div style="font-size: 24px; font-weight: bold; color: #dc3545;">
                        <?php echo number_format($stats['past_races']); ?>
                    </div>
                    <div style="color: #666;">Past Races</div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>