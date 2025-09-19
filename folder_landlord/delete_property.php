<?php 
    include 'connection_landlord.php';

    if (isset($_GET['id'])) { 
    $propertyID = $_GET['id'];
    $stmt = $pdo->prepare('DELETE FROM properties WHERE propertyID = ?');
    if ($stmt->execute([$propertyID])) {
        echo "Record deleted successfully";
    } else {
        echo "Record deleted unsuccessfully";
    }
    }
    
    header("location: landlord_main.php");
    exit();
?>