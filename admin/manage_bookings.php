<?php
// admin/manage_bookings.php

session_start();

// Check if the user is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// Include database configuration (corrected path)
include '../user/config.php';

$pdo = getDBConnection();

// Handle booking status update
if (isset($_POST['update_status'])) {
    $bookingId = $_POST['booking_id'];
    $status = $_POST['status'];

    try {
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$status, $bookingId]);

        $message = "Booking status updated successfully.";
        $messageType = "success";
    } catch (PDOException $e) {
        $message = "Error updating booking status: " . $e->getMessage();
        $messageType = "error";
    }
}

// Handle booking deletion
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $bookingId = $_GET['delete'];

    try {
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
        $stmt->execute([$bookingId]);

        $message = "Booking deleted successfully.";
        $messageType = "success";
    } catch (PDOException $e) {
        $message = "Error deleting booking: " . $e->getMessage();
        $messageType = "error";
    }
}

// Get filter parameters
$statusFilter = $_GET['status'] ?? '';
$dateFilter = $_GET['date'] ?? '';

// Build the query with filters
$query = "
    SELECT b.*, 
           u.username, u.full_name, u.email,
           r.race_name, r.track_name, r.location, r.race_date, r.race_time,
           tt.ticket_type, tt.price
    FROM bookings b
    JOIN users u ON b.user_id = u.id
    JOIN races r ON b.race_id = r.id
    JOIN ticket_types tt ON b.ticket_type_id = tt.id
    WHERE 1=1
";

$params = [];

if ($statusFilter) {
    $query .= " AND b.status = ?";
    $params[] = $statusFilter;
}

if ($dateFilter) {
    $query .= " AND DATE(b.booking_date) = ?";
    $params[] = $dateFilter;
}

$query .= " ORDER BY b.booking_date DESC";

$stmt = $pdo->prepare($query);
$stmt->execute($params);
$bookings = $stmt->fetchAll();

// Get booking statistics
$statsQuery = "
    SELECT 
        COUNT(*) as total_bookings,
        SUM(total_amount) as total_revenue,
        COUNT(CASE WHEN status = 'confirmed' THEN 1 END) as confirmed_bookings,
        COUNT(CASE WHEN status = 'pending' THEN 1 END) as pending_bookings,
        COUNT(CASE WHEN status = 'cancelled' THEN 1 END) as cancelled_bookings
    FROM bookings
";
$statsStmt = $pdo->query($statsQuery);
$stats = $statsStmt->fetch();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Bookings - Admin Panel</title>
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

        .filters {
            background: white;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .filter-group {
            display: inline-block;
            margin-right: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
            font-size: 12px;
        }

        .table th,
        .table td {
            padding: 8px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background: #23283b;
            color: white;
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

        .btn-primary {
            background: #007bff;
            color: white;
        }

        .btn-success {
            background: #28a745;
            color: white;
        }

        .btn-warning {
            background: #ffc107;
            color: #212529;
        }

        .message {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 20px;
        }

        .message.success {
            background: #d4edda;
            color: #155724;
            border: 1px solid #c3e6cb;
        }

        .message.error {
            background: #f8d7da;
            color: #721c24;
            border: 1px solid #f5c6cb;
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

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
            margin-bottom: 20px;
        }

        .stat-card {
            background: white;
            padding: 15px;
            border-radius: 8px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
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
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <div class="admin-title-img">
                <img src="image/main_logo.png" alt="F1 Hero" height="70px" width="80px" object-fit="cover">
                <h1> Ticket Booking - Manage Bookings</h1>
            </div>
                <p>Use the options below to <strong>Manage Users</strong>, bookings, and races.</p>



            <div class="admin-nav">
                <a href="index.php" class="btn btn-primary">🏠 Go to the Dashboard</a>
                <a href="manage_users.php" class="btn btn-primary">👥 Manage Users</a>
                <a href="manage_races.php" class="btn btn-primary">🏎️ Manage Races</a>
                <a href="manage_feedback.php" class="btn btn-primary">👻 Manage feedback</a>
                <a href="manage_bookings.php" class="btn btn-primary">🎫 Manage Bookings</a>

                <a href="logout.php" class="btn btn-danger">🔓 Logout</a>
            </div>
        </div>


        <?php if (isset($message)): ?>
            <div class="message <?php echo $messageType; ?>">
                <?php echo htmlspecialchars($message); ?>
            </div>
        <?php endif; ?>

        <!-- Statistics -->
        <div class="stats-grid">
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['total_bookings']; ?></div>
                <div class="stat-label">Total Bookings</div>
            </div>
            <div class="stat-card">
                <div class="stat-number">$<?php echo number_format($stats['total_revenue'], 2); ?></div>
                <div class="stat-label">Total Revenue</div>
            </div>
            <div class="stat-card">
                <div class="stat-number"><?php echo $stats['confirmed_bookings']; ?></div>
                <div class="stat-label">Confirmed</div>
            </div>
        </div>

        <!-- Filters -->
        <div class="filters">
            <form method="GET">
                <div class="filter-group">
                    
                </div>
                <div class="filter-group">
                    <label for="date">Booking Date:</label>
                    <input type="date" name="date" id="date" value="<?php echo htmlspecialchars($dateFilter); ?>">
                </div>
                <button type="submit" class="btn btn-primary">Filter</button>
                <a href="manage_bookings.php" class="btn btn-secondary">Clear Filters</a>
            </form>
        </div>

        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>User</th>
                        <th>Race</th>
                        <th>Track</th>
                        <th>Location</th>
                        <th>Race Date</th>
                        <th>Ticket Type</th>
                        <th>Quantity</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Booking Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($bookings as $booking): ?>
                        <tr>
                            <td>#<?php echo $booking['id']; ?></td>
                            <td>
                                <strong><?php echo htmlspecialchars($booking['full_name']); ?></strong><br>
                                <small><?php echo htmlspecialchars($booking['email']); ?></small>
                            </td>
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
                            <td>
                                <form method="POST" style="display: inline;">
                                    
                                    <input type="hidden" name="update_status" value="1">
                                </form>
                                <a href="?delete=<?php echo $booking['id']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this booking?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>
</body>

</html>