<?php
    session_start();
    $page = 'profile';
    include '../head.php';
    include 'navbar_tenant.php';
    include 'connection_tenant.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>" />
    <title>Profile</title>
</head>

<body>
    <div class="container">
      <div class="container-fluid">
        <h2 class="mt-3" >Hello <span class="text-danger"><?php echo $_SESSION['firstName'];?></span>, this is your profile!</h2>
        <div class="scroll">
          <table class="table table-sm table-dark mt-4 text-center">
            <tr>
              <th class="text-warning">User ID</th>
              <th class="text-warning">Last Name</th>
              <th class="text-warning">First Name</th>
              <th class="text-warning">Email</th>
          </tr>
            </tr>
              <td><?php echo $_SESSION['userID'];?></td>
              <td><?php echo $_SESSION['lastName'];?></td>
              <td><?php echo $_SESSION['firstName'];?></td>
              <td><?php echo $_SESSION['email'];?></td>
          </table>
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>

</body>
</html>