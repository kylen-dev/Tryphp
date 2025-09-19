<?php
session_start();

// Prevent caching
header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");

// Redirect to login if not logged in
if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Admin') {
    header("Location: ../login.php");
    exit();
}

// PostgreSQL connection
$host = "dpg-d36gje7fte5s73bf098g-a.singapore-postgres.render.com";
$dbname = "tryphpdb";
$username = "tryphpdb_user";
$password = "NUIHpl2WRo2VBQZleyO6LmLiwnrQhFcc";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
    exit();
}

$error = '';
?>
