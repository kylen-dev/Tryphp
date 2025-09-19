<?php
session_start();
include 'connection_tenant.php';

if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Tenant') {
    header("Location: ../login.php");
    exit();
}

if (isset($_POST['book_request'])) {
    $tenantID = $_SESSION['userID'];
    $propertyID = $_POST['propertyID'];

    // Optional: Check if a request already exists
    $stmtCheck = $pdo->prepare("SELECT * FROM booking_requests WHERE tenantID = ? AND propertyID = ? AND status = 'Pending'");
    $stmtCheck->execute([$tenantID, $propertyID]);

    if ($stmtCheck->rowCount() > 0) {
        header("Location: tenant_view_property.php?id=$propertyID&already_requested=1");
        exit();
    }

    $stmt = $pdo->prepare("INSERT INTO booking_requests (tenantID, propertyID) VALUES (?, ?)");
    if ($stmt->execute([$tenantID, $propertyID])) {
        header("Location: tenant_view_property.php?id=$propertyID&requested=1");
        exit();
    } else {
        header("Location: tenant_view_property.php?id=$propertyID&error=1");
        exit();
    }
}
?>
