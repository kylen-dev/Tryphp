<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <!-- Font Awesome -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css"
      rel="stylesheet"
    />
    <!-- MDB -->
    <link
      href="https://cdnjs.cloudflare.com/ajax/libs/mdb-ui-kit/7.2.0/mdb.min.css"
      rel="stylesheet"
    />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>" />
    <script src="script.js"></script>
</head>

<body>

    <?php
    session_start();
     $localhost = 'localhost:3307';
     $dbname = 'project';
     $username = 'root';
     $password = '';
 
     try {
     $pdo = new PDO("mysql:host=$localhost;dbname=$dbname", $username, $password); 
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION); 
        
         } 
        catch (PDOException $e) { 
        echo "Connection failed: " . $e->getMessage(); 
        } 
        if(!isset($_SESSION['username'])){
            header("location: login.php");
        }

    ?>
    <nav class="navbar navbar-expand-lg bg-body-tertiary">
      <div class="container-fluid">
        <a class="navbar-brand" href="index.php"
          ><img
            src="images\NBA-removebg-preview.png"
            width="50"
            height="50"
            alt="..."
        /></a>
        <button
          class="navbar-toggler"
          type="button"
          data-bs-toggle="collapse"
          data-bs-target="#navbarNav"
          aria-controls="navbarNav"
          aria-expanded="false"
          aria-label="Toggle navigation"
        >
        <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
          <ul class="navbar-nav ms-auto">
            <li class="nav-item">
            <a class="nav-link" href="index.php"><i class="fa-solid fa-table-list icon"></i>Rankings</a>
            </li>
            <li class="nav-item">
              <a class="nav-link active" aria-current="page" href="profile.php"><i class="fa-solid fa-user icon"></i>Profile</a>
            </li>
            <li class="nav-item">
              <a class="nav-link" href="logout.php" onclick="return confirm('Do you want to logout?')"><i class="fa fa-sign-out icon" aria-hidden="true"></i>Logout</a>
            </li>
          </ul>
        </div>
      </div>
    </nav>

    <div class="container-fluid">
      <h2 class="mt-3" >Hello <span class="text-danger"><?php echo $_SESSION['username'];?></span>, this is your profile!</h2>
      <div class="scroll">
        <table class="table table-sm table-dark mt-4 text-center">
          <tr>
            <th class="text-warning">Last Name</th>
            <th class="text-warning">First Name</th>
            <th class="text-warning">Date of Birth</th>
            <th class="text-warning">Username</th>
            <th class="text-warning">Email</th>
         </tr>
          </tr>
            <td><?php echo $_SESSION['lastname'];?></td>
            <td><?php echo $_SESSION['firstname'];?></td>
            <td><?php echo $_SESSION['dob'];?></td>
            <td><?php echo $_SESSION['username'];?></td>
            <td><?php echo $_SESSION['email'];?></td>
        </table>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>

  </body>

</html>