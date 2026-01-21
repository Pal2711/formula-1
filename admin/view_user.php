<?php
// admin/view_user.php

session_start();

// Check if the admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include correct config file path
$configPath = '../user/config.php';
if (!file_exists($configPath)) {
    die("❌ Error: Config file not found at $configPath");
}
require_once $configPath;

// Get DB connection
$pdo = getDBConnection();

// Get user ID from URL
if (!isset($_GET['id']) || !is_numeric($_GET['id'])) {
    header('Location: manage_users.php');
    exit();
}

$userId = (int) $_GET['id'];

// Get user details
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$userId]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: manage_users.php');
    exit();
}

// Get user's bookings
$stmt = $pdo->prepare("
    SELECT b.*, 
           r.race_name, r.track_name, r.location, r.race_date, r.race_time,
           tt.ticket_type, tt.price
    FROM bookings b
    JOIN races r ON b.race_id = r.id
    JOIN ticket_types tt ON b.ticket_type_id = tt.id
    WHERE b.user_id = ?
    ORDER BY b.booking_date DESC
");
$stmt->execute([$userId]);
$bookings = $stmt->fetchAll();

// Calculate user statistics
$totalBookings = count($bookings);
$totalSpent = array_sum(array_column($bookings, 'total_amount'));

$confirmedBookings = count(array_filter($bookings, function($b) {
    return $b['status'] === 'confirmed';
}));

$pendingBookings = count(array_filter($bookings, function($b) {
    return $b['status'] === 'pending';
}));

$cancelledBookings = count(array_filter($bookings, function($b) {
    return $b['status'] === 'cancelled';
}));
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View User - <?php echo htmlspecialchars($user['full_name']); ?></title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        .admin-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 20px;
            background: #f4f6fb;
            min-height: 100vh;
        }
        .admin-header {
            background: #23283b;
            color: white;
            padding: 15px 20px;
            border-radius: 8px;
            margin-bottom: 20px;
        }
        .user-info {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
            margin-bottom: 20px;
        }
        .info-card {
            background: #f8f9fa;
            padding: 15px;
            border-radius: 8px;
            border-left: 4px solid #007bff;
        }
        .info-label {
            font-weight: bold;
            color: #666;
            margin-bottom: 5px;
        }
        .info-value {
            font-size: 16px;
            color: #333;
        }
        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }
        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
            text-align: center;
        }
        .stat-number {
            font-size: 24px;
            font-weight: bold;
            color: #23283b;
        }
        .stat-label {
            color: #666;
            margin-top: 5px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0,0,0,0.1);
        }
        .table th, .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }
        .table th {
            background: #23283b;
            color: white;
        }
        .btn {
            padding: 8px 16px;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
            display: inline-block;
            margin: 2px;
        }
        .btn-primary {
            background: #007bff;
            color: white;
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
    </style>
</head>
<body>
    <div class="admin-container">
        <div class="admin-header">
            <h1>User Details - <?php echo htmlspecialchars($user['full_name']); ?></h1>
            <nav>
                <a href="manage_users.php" class="btn btn-primary">Back to Users</a>
                <a href="index.php" class="btn btn-primary">Dashboard</a>
            </nav>
        </div>

        <!-- User Information -->
        <div class="user-info">
            <h3>User Information</h3>
            <div class="info-grid">
                <div class="info-card">
                    <div class="info-label">User ID</div>
                    <div class="info-value">#<?php echo $user['id']; ?></div>
                </div>
                <div class="info-card">
                    <div class="info-label">Username</div>
                    <div class="info-value"><?php echo htmlspecialchars($user['username']); ?></div>
                </div>
                <div class="info-card">
                    <div class="info-label">Full Name</div>
                    <div class="info-value"><?php echo htmlspecialchars($user['full_name']); ?></div>
                </div>
                <div class="info-card">
                    <div class="info-label">Email</div>
                    <div class="info-value"><?php echo htmlspecialchars($user['email']); ?></div>
                </div>
                <div class="info-card">
                    <div class="info-label">Phone</div>
                    <div class="info-value"><?php echo htmlspecialchars($user['phone'] ?? 'Not provided'); ?></div>
                </div>
                <div class="info-card">
                    <div class="info-label">Registration Date</div>
                    <div class="info-value"><?php echo isset($user['created_at']) ? date('M j, Y g:i A', strtotime($user['created_at'])) : 'N/A'; ?></div>
                </div>
            </div>
        </div>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $totalBookings; ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$<?php echo number_format($totalSpent, 2); ?></div>
                <div class="stat-label">Total Spent</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $confirmedBookings; ?></div>
                <div class="stat-label">Confirmed</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $pendingBookings; ?></div>
                <div class="stat-label">Pending</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $cancelledBookings; ?></div>
                <div class="stat-label">Cancelled</div>
            </div>
        </div>

        <!-- Bookings History -->
        <div style="background: white; padding: 20px; border-radius: 8px; box-shadow: 0 2px 8px rgba(0,0,0,0.1);">
            <h3>Booking History</h3>
            
            <?php if (empty($bookings)): ?>
                <p style="text-align: center; color: #666; padding: 20px;">No bookings found for this user.</p>
            <?php else: ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th>Booking ID</th>
                            <th>Race</th>
                            <th>Track</th>
                            <th>Location</th>
                            <th>Race Date</th>
                            <th>Ticket Type</th>
                            <th>Quantity</th>
                            <th>Amount</th>
                            <th>Status</th>
                            <th>Booking Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($bookings as $booking): ?>
                            <tr>
                                <td>#<?php echo $booking['id']; ?></td>
                                <td><?php echo htmlspecialchars($booking['race_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['track_name']); ?></td>
                                <td><?php echo htmlspecialchars($booking['location']); ?></td>
                                <td>
                                    <?php echo date('M j, Y', strtotime($booking['race_date'])); ?><br>
                                    <small><?php echo date('g:i A', strtotime($booking['race_time'])); ?></small>
                                </td>
                                <td><?php echo htmlspecialchars($booking['ticket_type']); ?></td>
                                <td><?php echo $booking['quantity']; ?></td>
                                <td>$<?php echo number_format($booking['total_amount'], 2); ?></td>
                                <td>
                                    <span class="status-<?php echo $booking['status']; ?>">
                                        <?php echo strtoupper($booking['status']); ?>
                                    </span>
                                </td>
                                <td><?php echo date('M j, Y g:i A', strtotime($booking['booking_date'])); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>
