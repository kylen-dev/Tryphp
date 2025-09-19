<?php
    session_start();
    $page = 'admins';
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
    <title>Administrators</title>
</head>

<body>
    <div class="container">
      <div class="d-flex justify-content-between align-items-center mt-3">
        <h2 class="m-0">List of Administrators</h2>
        <a class="btn btn-primary" href="add_new_admin.php"> <i class="fa fa-plus" aria-hidden="true"></i> Admins </a>
        </div>
        <table class="table table-sm table-dark mt-4 text-center">
          <tr>
            <th class="text-warning">USER ID</th>
            <th class="text-warning">Last Name</th>
            <th class="text-warning">First Name</th>
            <th class="text-warning">Email</th>
            <th>ACTIONS</th>
         </tr>
        
        <?php
        $stmt = $pdo->query('SELECT * FROM users WHERE role = "Admin"');
        $users = $stmt->fetchAll(); 

        if($stmt->rowCount() > 0){
          foreach ($users as $row) {
              echo "<tr>";
              echo "<td>{$row['userID']}</td>";
              echo "<td>{$row['firstName']}</td>";
              echo "<td>{$row['lastName']}</td>";
              echo "<td>{$row['email']}</td>";
              echo "<td>
              <a class='border border-warning rounded p-1 bg-warning text-dark mt-2 delete' href='delete.php?id={$row['userID']}' onclick=\"return confirm('Do you want to delete this record?')\"><i class='fa fa-trash' aria-hidden='true'></i></a>
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
    > </script>
</body>
</html>