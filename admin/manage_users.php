<?php
session_start();
require_once '../user/config.php';

// ✅ Check admin session
if (!isset($_SESSION['admin_logged_in'])) {
    header("Location: login.php");
    exit;
}

$pdo = getDBConnection();

// ✅ Handle delete
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $stmt = $pdo->prepare("DELETE FROM users WHERE id = ?");
    $stmt->execute([$id]);
    header("Location: manage_users.php");
    exit;
}

// ✅ Handle update
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['update_id'])) {
    $id = intval($_POST['update_id']);
    $username = trim($_POST['username']);
    $email = trim($_POST['email']);
    $full_name = trim($_POST['full_name']);
    $phone = trim($_POST['phone']);
    $status = trim($_POST['status']);

    $stmt = $pdo->prepare("UPDATE users SET username = ?, email = ?, full_name = ?, phone = ?, status = ? WHERE id = ?");
    $stmt->execute([$username, $email, $full_name, $phone, $status, $id]);
    header("Location: manage_users.php");
    exit;
}

// ✅ Fetch all users
$stmt = $pdo->query("SELECT * FROM users ORDER BY created_at DESC");
$users = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>

<head>
    <title>Manage Users - Admin Panel</title>
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

        .btn-green {
            background-color: #28a745;
            color: white;
        }

        h2 {
            margin-top: 25px;
            margin-bottom: 15px;
            background: #2c3e50;
            color: white;
            padding: 12px;
            border-radius: 8px;
            text-align: center;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            background: white;
            border-radius: 6px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.05);
        }

        th,
        td {
            padding: 12px 15px;
            border-bottom: 1px solid #ddd;
        }

        th {
            background-color: #34495e;
            color: white;
        }

        tr:hover {
            background-color: #f9f9f9;
        }

        .edit-form input,
        .edit-form select {
            width: 100%;
            padding: 6px;
            margin: 4px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .edit-form input[type="submit"] {
            background-color: #007bff;
            color: white;
            cursor: pointer;
        }

        td.actions a,
        td.actions button {
            padding: 6px 10px;
            border-radius: 4px;
            font-size: 0.85rem;
            text-decoration: none;
            margin-right: 4px;
        }

        .edit-btn {
            background: #28a745;
            color: white;
        }

        .delete-btn {
            background: #dc3545;
            color: white;
        }
    </style>
</head>

<body>
    <div class="admin-container">
                <div class="admin-header">
            <div class="admin-title-img">
                <img src="image/main_logo.png" alt="F1 Hero" height="70px" width="80px" object-fit="cover">
                <h1> Ticket Booking - Manage user</h1>
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
                <th>Username</th>
                <th>Email</th>
                <th>Full Name</th>
                <th>Phone</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
            <?php foreach ($users as $user): ?>
                <tr>
                    <td><?= $user['id'] ?></td>
                    <td>
                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $user['id']): ?>
                            <form method="POST" class="edit-form">
                                <input type="text" name="username" value="<?= htmlspecialchars($user['username']) ?>" required>
                            <?php else: ?>
                                <?= htmlspecialchars($user['username']) ?>
                            <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $user['id']): ?>
                            <input type="email" name="email" value="<?= htmlspecialchars($user['email']) ?>" required>
                        <?php else: ?>
                            <?= htmlspecialchars($user['email']) ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $user['id']): ?>
                            <input type="text" name="full_name" value="<?= htmlspecialchars($user['full_name']) ?>">
                        <?php else: ?>
                            <?= htmlspecialchars($user['full_name']) ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $user['id']): ?>
                            <input type="text" name="phone" value="<?= htmlspecialchars($user['phone']) ?>">
                        <?php else: ?>
                            <?= htmlspecialchars($user['phone']) ?>
                        <?php endif; ?>
                    </td>
                    <td><?= $user['created_at'] ?></td>
                    <td class="actions">
                        <?php if (isset($_GET['edit']) && $_GET['edit'] == $user['id']): ?>
                            <input type="hidden" name="update_id" value="<?= $user['id'] ?>">
                            <input type="submit" value="Save">
                            </form>
                        <?php else: ?>
                            
                            <a href="manage_users.php?delete=<?= $user['id'] ?>" class="delete-btn"
                                onclick="return confirm('Are you sure you want to delete this user?')">Delete</a>
                        <?php endif; ?>
                    </td>
                </tr>
            <?php endforeach; ?>
        </table>
    </div>
</body>

</html>