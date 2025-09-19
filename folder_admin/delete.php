<?php 
    include 'connection_admin.php';

    if (isset($_GET['id'])) { 
        $userID = $_GET['id'];
        $stmt = $pdo->prepare('DELETE FROM users WHERE userID = ?');
        if ($stmt->execute([$userID])) {
            echo "Record deleted successfully";
        } else {
            echo "Record deleted unsuccessfully";
        }
    }
    
    header("location: admin_main.php");

?>