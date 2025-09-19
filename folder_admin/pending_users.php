<?php
    session_start();
    $page = 'pending_users';
    include '../head.php';
    include 'navbar_admin.php';
    include 'connection_admin.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>" />
    <title>Pending Users</title>
</head>

<body>
    <div class="container">
      <h2 class="mt-3" >List of Pending Users</h2>
      <div class="scroll">
        <table class="table table-sm table-dark mt-4 text-center">
          <tr>
            <th class="text-warning">User ID</th>
            <th class="text-warning">Last Name</th>
            <th class="text-warning">First Name</th>
            <th class="text-warning">Email</th>
            <th class="text-warning">Role</th>
            <th>ACTIONS</th>
         </tr>

          <?php
          $stmt = $pdo->query('SELECT * FROM users WHERE status = "pending"');
          $users = $stmt->fetchAll(); 

          if($stmt->rowCount() > 0){
            foreach ($users as $row) {
                echo "<tr>";
                echo "<td>{$row['userID']}</td>";
                echo "<td>{$row['firstName']}</td>";
                echo "<td>{$row['lastName']}</td>";
                echo "<td>{$row['email']}</td>";
                echo "<td>{$row['role']}</td>";
                echo "<td>
                <a class='border border-warning rounded p-1 bg-warning text-dark mt-2 delete' href='approve_user.php?id={$row['userID']}' onclick=\"return confirm('Do you want to approve this user?')\"><i class='fa fa-check' aria-hidden='true'></i></a>
                <a class='border border-warning rounded p-1 bg-warning text-dark mt-2 delete' href='deny_user.php?id={$row['userID']}' onclick=\"return confirm('Do you want to deny this user?')\"><i class='fa fa-trash' aria-hidden='true'></i></a>
              </td>";
                echo "</tr>";
            }
          } else{
            echo "<tr><td colspan='8'>No Data</td></tr>";
          }
          ?>

        </table>
      </div>
    </div>

 <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script src="js/script.js"></script>

</body>
</html>