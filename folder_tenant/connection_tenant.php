<?php 
    //Php database connection
    $localhost = 'localhost:3307';
    $dbname = 'project';
    $username = 'root';
    $password = '';

    header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
    header("Cache-Control: post-check=0, pre-check=0", false);
    header("Pragma: no-cache");

    // Redirect to login if not logged in
    if(!isset($_SESSION['userID'])) {
       header("location: ../login.php");
    }

     try {
     $pdo = new PDO("mysql:host=$localhost;dbname=$dbname", $username, $password); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
         } 
        catch (PDOException $e) { 
        echo "Connection failed: " . $e->getMessage(); 
        } 
        if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Tenant') {
        header("Location: ../login.php");
        } $error = '';
?>