<?php
session_start();

// Ensure only admin can access
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit();
}

// Include PostgreSQL connection
require_once '../inc/db.php';

try {
    $pdo = get_db_pdo();
} catch (Exception $e) {
    die("Database connection failed: " . $e->getMessage());
}

// Deny user if 'id' is provided in GET
if (isset($_GET['id'])) {
    $userID = $_GET['id'];

    $stmt = $pdo->prepare("DELETE FROM users WHERE userid = ?");
    if ($stmt->execute([$userID])) {
        $_SESSION['message'] = "User denied successfully!";
    } else {
        $_SESSION['message'] = "Failed to deny user.";
    }
}

// Redirect back to pending users page
header("Location: pending_users.php");
exit();
