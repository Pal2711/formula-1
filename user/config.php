<?php
// Start session only if not already active
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_NAME', 'f1_ticket_booking');

// Create database connection
function getDBConnection() {
    try {
        $pdo = new PDO("mysql:host=" . DB_HOST . ";dbname=" . DB_NAME, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        return $pdo;
    } catch(PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }
}

// Check if user is logged in
function isLoggedIn() {
    return isset($_SESSION['user_id']);
}

// Get current user info
function getCurrentUser() {
    if (isLoggedIn()) {
        $pdo = getDBConnection();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$_SESSION['user_id']]);
        return $stmt->fetch();
    }
    return null;
}

// Save contact message to DB
function saveContactMessage($name, $message) {
    $pdo = getDBConnection();
    $stmt = $pdo->prepare("INSERT INTO reachout (name, message) VALUES (?, ?)");
    return $stmt->execute([$name, $message]);
}

// Fetch all contact messages
function fetchAllMessages() {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT name, message FROM reachout ORDER BY created_at DESC LIMIT 6");
    return $stmt->fetchAll();
}

// ✅ Get total feedback count
function getFeedbackCount() {
    $pdo = getDBConnection();
    $stmt = $pdo->query("SELECT COUNT(*) FROM reachout");
    return $stmt->fetchColumn();
}
?>
