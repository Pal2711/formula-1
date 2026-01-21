<?php
session_start();
require_once '../user/config.php';

// ✅ Check if admin is logged in
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$pdo = getDBConnection();

// ✅ Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM reachout WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_feedback.php");
    exit;
}

// ✅ Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $updatedMessage = trim($_POST['updated_message']);
    $stmt = $pdo->prepare("UPDATE reachout SET message = ? WHERE id = ?");
    $stmt->execute([$updatedMessage, $id]);
    header("Location: manage_feedback.php");
    exit;
}

// ✅ Fetch all messages
$stmt = $pdo->query("SELECT * FROM reachout ORDER BY created_at DESC");
$messages = $stmt->fetchAll();
?>


<!DOCTYPE html>
<html>

<head>
    
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
        h2 {
            text-align: center;
            background: #2c3e50;
            color: white;
            padding: 1rem;
            border-radius: 8px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 8px;
            overflow: hidden;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        th,
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
            text-align: left;
        }

        th {
            background: #34495e;
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .actions a,
        .actions button {
            padding: 6px 12px;
            margin-right: 4px;
            text-decoration: none;
            color: #fff;
            border-radius: 4px;
            font-size: 0.9rem;
            border: none;
            cursor: pointer;
        }

        .edit-btn {
            background: #28a745;
        }

        td.actions {
            display: flex;
            gap: 5px;
        }

        .delete-btn {
            background: #dc3545;
        }

        .edit-form textarea {
            width: 100%;
            height: 80px;
            padding: 8px;
            border-radius: 4px;
            resize: vertical;
            border: 1px solid #ccc;
        }

        .edit-form input[type="submit"] {
            background: #007bff;
            color: white;
            border: none;
            padding: 8px 16px;
            margin-top: 8px;
            border-radius: 4px;
            cursor: pointer;
        }
    </style>
</head>

<body>
    <div class="admin-container">
        <div class="admin-header">
            <div class="admin-title-img">
                <img src="image/main_logo.png" alt="F1 Hero" height="70px" width="80px" object-fit="cover">
                <h1> Ticket Booking - Manage feedback </h1>
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
        <table>
            <tr>
                <th>ID</th>
                <th>Name</th>
                <th>Message</th>
                <th>Submitted At</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($messages as $msg): ?>
                <tr>
                    <td><?= $msg['id'] ?></td>
                    <td><?= htmlspecialchars($msg['name']) ?></td>
                    <td>
                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $msg['id']): ?>
                            <form method="POST" class="edit-form">
                                <textarea name="updated_message"><?= htmlspecialchars($msg['message']) ?></textarea>
                                <input type="hidden" name="update_id" value="<?= $msg['id'] ?>">
                                <input type="submit" value="Update">
                            </form>
                        <?php else: ?>
                            <?= nl2br(htmlspecialchars($msg['message'])) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $msg['created_at'] ?></td>
                    <td class="actions">
                        <a href="manage_feedback.php?edit=<?= $msg['id'] ?>" class="edit-btn">Edit</a>
                        <a href="manage_feedback.php?delete=<?= $msg['id'] ?>" class="delete-btn"
                            onclick="return confirm('Are you sure you want to delete this message?')">Delete</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>