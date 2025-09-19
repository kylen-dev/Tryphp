<?php
// Start session if needed
session_start();

// You can redirect to a default page or show links
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>My PHP Site</title>
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <h1>Welcome to My PHP Site</h1>

    <nav>
        <ul>
            <li><a href="login.php">Login</a></li>
            <li><a href="register.php">Register</a></li>
        </ul>
    </nav>

    <script src="js/script.js"></script>
</body>
</html>
