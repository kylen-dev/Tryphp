<?php
session_start();
include 'connection_landlord.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $propertyID = $_POST['propertyID'];
    $tenantID = $_POST['tenantID'];

    $stmt = $pdo->prepare("UPDATE booking_requests SET status = 'rejected' WHERE propertyID = ? AND tenantID = ?");
    $stmt->execute([$propertyID, $tenantID]);

    // Optional: Add success flag
    header("Location: landlord_main.php?rejected=1");
    exit();
} else {
    header("Location: landlord_main.php");
    exit();
}
