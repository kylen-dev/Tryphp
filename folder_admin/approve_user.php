<?php
    //Php database connection
    $localhost = 'localhost:3307';
    $dbname = 'project';
    $username = 'root';
    $password = '';

    try {
    $pdo = new PDO("mysql:host=$localhost;dbname=$dbname", $username, $password); 
       $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
       echo "Connected successfully!";
        } 
       catch (PDOException $e) { 
       echo "Connection failed: " . $e->getMessage(); 
       } 

       if (isset($_GET['id'])) { 
        $userID = $_GET['id'];
        $stmt = $pdo->prepare('UPDATE users SET status = "approved" WHERE userID = ?');
        if ($stmt->execute([$userID])) {
            echo "User approved successfully";
        } else {
            echo "User approved unsuccessfully";
        }
    }
    
    header("location: admin_main.php");

?>