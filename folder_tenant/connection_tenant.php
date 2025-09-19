<?php
session_start();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect to login if not logged in or not a tenant
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Tenant') {
    header("Location: ../login.php");
    exit();
}

// ✅ Use centralized DB connection
require_once __DIR__ . '/../inc/db.php';

try {
    $pdo = get_db_pdo();
} catch (Exception $e) {
    echo "Database connection failed: " . $e->getMessage();
    exit();
}

$error = '';
?>
