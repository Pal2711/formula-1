<?php
session_start();

// ✅ Load config file
$configPath = dirname(__DIR__) . '/user/config.php';
if (file_exists($configPath)) {
    include $configPath;
} else {
    die("Config file not found at: $configPath");
}

$pdo = getDBConnection();

// ✅ Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header('Location: login.php');
    exit();
}

// ✅ Handle race creation
if (isset($_POST['add_race'])) {
    $raceName = $_POST['race_name'];
    $trackName = $_POST['track_name'];
    $location = $_POST['location'];
    $raceDate = $_POST['race_date'];
    $raceTime = $_POST['race_time'];
    $description = $_POST['description'];

    $imageName = null;

    // ✅ Handle image upload with folder check
    if (isset($_FILES['race_image']) && $_FILES['race_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true); // Create folder if not exists
        }
        $imageName = time() . '_' . basename($_FILES['race_image']['name']);
        move_uploaded_file($_FILES['race_image']['tmp_name'], $uploadDir . $imageName);
    }

    try {
        $stmt = $pdo->prepare("INSERT INTO races (race_name, track_name, location, race_date, race_time, description, image) VALUES (?, ?, ?, ?, ?, ?, ?)");
        $stmt->execute([$raceName, $trackName, $location, $raceDate, $raceTime, $description, $imageName]);

        $message = "✅ Race added successfully.";
        $messageType = "success";
    } catch (PDOException $e) {
        $message = "❌ Error adding race: " . $e->getMessage();
        $messageType = "error";
    }
}

// ✅ Handle race update
if (isset($_POST['update_race'])) {
    $raceId = $_POST['race_id'];
    $raceName = $_POST['race_name'];
    $trackName = $_POST['track_name'];
    $location = $_POST['location'];
    $raceDate = $_POST['race_date'];
    $raceTime = $_POST['race_time'];
    $description = $_POST['description'];

    $imageName = $_POST['current_image'] ?? null;
    $trackName = $_POST['current_image'] ?? null;



    // ✅ Handle image upload
    if (isset($_FILES['race_image']) && $_FILES['race_image']['error'] === UPLOAD_ERR_OK) {
        $uploadDir = __DIR__ . '/../uploads/';
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }
        $imageName = time() . '_' . basename($_FILES['race_image']['name']);
        move_uploaded_file($_FILES['race_image']['tmp_name'], $uploadDir . $imageName);
    }

    try {
        $stmt = $pdo->prepare("UPDATE races SET race_name = ?, track_name = ?, location = ?, race_date = ?, race_time = ?, description = ?, image = ? WHERE id = ?");
        $stmt->execute([$raceName, $trackName, $location, $raceDate, $raceTime, $description, $imageName, $raceId]);

        $message = "✅ Race updated successfully.";
        $messageType = "success";
    } catch (PDOException $e) {
        $message = "❌ Error updating race: " . $e->getMessage();
        $messageType = "error";
    }
}

// ✅ Handle race deletion (only if no bookings)
if (isset($_GET['delete']) && is_numeric($_GET['delete'])) {
    $raceId = $_GET['delete'];
    try {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM bookings WHERE race_id = ?");
        $stmt->execute([$raceId]);
        $bookingCount = $stmt->fetchColumn();

        if ($bookingCount > 0) {
            $message = "❌ Cannot delete race. There are $bookingCount booking(s) for this race.";
            $messageType = "error";
        } else {
            $stmt = $pdo->prepare("DELETE FROM races WHERE id = ?");
            $stmt->execute([$raceId]);
            $message = "✅ Race deleted successfully.";
            $messageType = "success";
        }
    } catch (PDOException $e) {
        $message = "❌ Error deleting race: " . $e->getMessage();
        $messageType = "error";
    }
}

// ✅ Fetch all races with booking stats
$stmt = $pdo->query("
    SELECT r.*, 
           COUNT(b.id) as total_bookings,
           COALESCE(SUM(b.total_amount), 0) as total_revenue
    FROM races r
    LEFT JOIN bookings b ON r.id = b.race_id
    GROUP BY r.id
    ORDER BY r.race_date DESC
");
$races = $stmt->fetchAll();

// ✅ Get race details for editing
$editRace = null;
if (isset($_GET['edit']) && is_numeric($_GET['edit'])) {
    $stmt = $pdo->prepare("SELECT * FROM races WHERE id = ?");
    $stmt->execute([$_GET['edit']]);
    $editRace = $stmt->fetch();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Races - Admin Panel</title>
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


        .form-container {
            background: white;
            padding: 20px;
            border-radius: 8px;
            margin-bottom: 20px;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .form-group input,
        .form-group select,
        .form-group textarea {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
            box-sizing: border-box;
        }

        .form-group textarea {
            height: 80px;
            resize: vertical;
        }

        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .table th,
        .table td {
            padding: 12px;
            text-align: left;
            border-bottom: 1px solid #ddd;
        }

        .table th {
            background: #23283b;
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

        .race-date-future {
            color: #28a745;
            font-weight: bold;
        }

        .race-date-past {
            color: #6c757d;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <div class="admin-title-img">
                <img src="image/main_logo.png" alt="F1 Hero" height="70px" width="80px" object-fit="cover">
                <h1> Ticket Booking - Manage Races</h1>
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

        <!-- Add/Edit Race Form -->
        <div class="form-container">
            <h3><?php echo $editRace ? 'Edit Race' : 'Add New Race'; ?></h3>
            <form method="POST" enctype="multipart/form-data">
                <?php if ($editRace): ?>
                    <input type="hidden" name="race_id" value="<?php echo $editRace['id']; ?>">
                <?php endif; ?>

                <div class="form-row">
                    <div class="form-group">
                        <label for="race_name">Race Name:</label>
                        <input type="text" id="race_name" name="race_name" required
                            value="<?php echo $editRace ? htmlspecialchars($editRace['race_name']) : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="track_name">Track Name:</label>
                        <input type="text" id="track_name" name="track_name" required
                            value="<?php echo $editRace ? htmlspecialchars($editRace['track_name']) : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="location">Location:</label>
                    <input type="text" id="location" name="location" required
                        value="<?php echo $editRace ? htmlspecialchars($editRace['location']) : ''; ?>">
                </div>

                <div class="form-row">
                    <div class="form-group">
                        <label for="race_date">Race Date:</label>
                        <input type="date" id="race_date" name="race_date" required
                            value="<?php echo $editRace ? $editRace['race_date'] : ''; ?>">
                    </div>
                    <div class="form-group">
                        <label for="race_time">Race Time:</label>
                        <input type="time" id="race_time" name="race_time" required
                            value="<?php echo $editRace ? $editRace['race_time'] : ''; ?>">
                    </div>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea id="description"
                        name="description"><?php echo $editRace ? htmlspecialchars($editRace['description'] ?? '') : ''; ?></textarea>
                </div>

                <!-- ✅ New Image Upload Field -->
                <div class="form-group">
                    <label for="race_image">Race Image:</label>
                    <input type="file" id="race_image" name="race_image" accept="image/*">
                    <?php if ($editRace && !empty($editRace['image'])): ?>
                        <p>Current Image:</p>
                        <img src="../uploads/<?php echo htmlspecialchars($editRace['image']); ?>" alt="Race Image"
                            style="max-width: 200px;">
                    <?php endif; ?>
                </div>

                <button type="submit" name="<?php echo $editRace ? 'update_race' : 'add_race'; ?>"
                    class="btn btn-success">
                    <?php echo $editRace ? 'Update Race' : 'Add Race'; ?>
                </button>

                <?php if ($editRace): ?>
                    <a href="manage_races.php" class="btn btn-secondary">Cancel</a>
                <?php endif; ?>
            </form>

        </div>

        <!-- Races Table -->
        <div class="table-container">
            <table class="table">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Race Name</th>
                        <th>Track</th>
                        <th>Location</th>
                        <th>Date & Time</th>
                        <th>Total Bookings</th>
                        <th>Revenue</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($races as $race): ?>
                        <tr>
                            <td><?php echo $race['id']; ?></td>
                            <td><?php echo htmlspecialchars($race['race_name']); ?></td>
                            <td><?php echo htmlspecialchars($race['track_name']); ?></td>
                            <td><?php echo htmlspecialchars($race['location']); ?></td>
                            <td>
                                <span
                                    class="<?php echo strtotime($race['race_date']) > time() ? 'race-date-future' : 'race-date-past'; ?>">
                                    <?php echo date('M j, Y', strtotime($race['race_date'])); ?>
                                </span><br>
                                <small><?php echo date('g:i A', strtotime($race['race_time'])); ?></small>
                            </td>
                            <td><?php echo $race['total_bookings']; ?></td>
                            <td>$<?php echo number_format($race['total_revenue'], 2); ?></td>
                            <td>
                                <a href="?edit=<?php echo $race['id']; ?>" class="btn btn-warning">Edit</a>
                                <a href="?delete=<?php echo $race['id']; ?>" class="btn btn-danger"
                                    onclick="return confirm('Are you sure you want to delete this race?')">
                                    Delete
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>

        <div style="margin-top: 20px; padding: 15px; background: white; border-radius: 8px;">
            <h3>Summary</h3>
            <p>Total Races: <?php echo count($races); ?></p>
            <p>Future Races:
                <?php echo count(array_filter($races, function ($race) {
                    return strtotime($race['race_date']) > time();
                })); ?>
            </p>
            <p>Past Races:
                <?php echo count(array_filter($races, function ($race) {
                    return strtotime($race['race_date']) <= time();
                })); ?>
            </p>
            <p>Total Revenue from All Races:
                $<?php echo number_format(array_sum(array_column($races, 'total_revenue')), 2); ?></p>
        </div>
    </div>
</body>

</html>