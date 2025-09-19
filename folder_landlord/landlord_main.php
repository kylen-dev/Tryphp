<?php
    session_start();
    $page = 'profile';
    include '../head.php';
    include 'navbar_landlord.php';
    include 'connection_landlord.php';
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

        <?php
          $landlordID = $_SESSION['userID'];
          $stmt = $pdo->prepare("
              SELECT br.*, p.propertyName, u.firstName, u.lastName
              FROM booking_requests br
              JOIN properties p ON br.propertyID = p.propertyID
              JOIN users u ON br.tenantID = u.userID
              WHERE p.landlordID = ? AND br.status = 'Pending'
              ORDER BY br.requestDate DESC
          ");
          $stmt->execute([$landlordID]);
          $requests = $stmt->fetchAll();
        ?>
      
<?php if ($requests): ?>
    <h4>Booking Requests</h4>
    <ul class="list-group mb-4">
       <?php foreach ($requests as $req): ?>
    <li class="list-group-item d-flex justify-content-between align-items-center">
        <div>
            <strong><?php echo htmlspecialchars($req['firstName'] . ' ' . $req['lastName']); ?></strong> wants to book 
            <em><?php echo htmlspecialchars($req['propertyName']); ?></em>
        </div>
        <div class="btn-group">
            <a href="create_contract.php?propertyID=<?php echo $req['propertyID']; ?>&tenantID=<?php echo $req['tenantID']; ?>" class="btn btn-success btn-sm">
                Create Contract
            </a>
            <form action="landlord_reject_request.php" method="POST" onsubmit="return confirm('Reject this booking request?');">
                <input type="hidden" name="propertyID" value="<?php echo $req['propertyID']; ?>">
                <input type="hidden" name="tenantID" value="<?php echo $req['tenantID']; ?>">
                <button type="submit" class="btn btn-danger btn-sm">Reject</button>
            </form>
        </div>
    </li>
<?php endforeach; ?>
       </ul>
<?php else: ?>
    <p class="text-muted">No booking requests at the moment.</p>
<?php endif; ?>

      </div>
    </div>
    
    <div class="container">
      <div class="container mt-4">
        <div class="container-fluid">
          <div class="d-flex justify-content-between align-items-center mt-3">
            <h2 class="m-0">List of Properties</h2>
            <a class="btn btn-primary" href="landlord_add_property.php"> <i class="fa fa-plus" aria-hidden="true"></i> Add Property </a>
          </div>

          <!-- Property Cards -->
          <div class="row">
            <?php
            $landlordID = $_SESSION['userID'];
            $stmt = $pdo->prepare("SELECT * FROM properties WHERE landlordID = ?");
            $stmt->execute([$landlordID]);
            $properties = $stmt->fetchAll();

            if ($stmt->rowCount() > 0):
              foreach ($properties as $row):
                $propertyID = $row['propertyID'];

                // Fetch images
                $stmtImg = $pdo->prepare("SELECT * FROM propertyImages WHERE propertyID = ?");
                $stmtImg->execute([$propertyID]);
                $images = $stmtImg->fetchAll();
            ?>
      
            <div class="col-md-6 col-lg-6 mb-4">
              <div class="card h-100 shadow">
                <div class="card-body">
                  <div class="card-header d-flex justify-content-between align-items-center">
                    <h5 class="card-title text-primary mb-0">
                      <?php echo htmlspecialchars($row['propertyName']); ?>
                    </h5>
                    <div class="d-flex gap-2">
                      <a href="landlord_edit_property.php?id=<?php echo $row['propertyID']; ?>" class="btn btn-sm btn-outline-primary"> Edit </a>
                      <a href="delete_property.php?id=<?php echo $row['propertyID']; ?>" class="btn btn-sm btn-outline-danger" onclick="return confirm('Are you sure you want to delete this property?')"> Delete </a>
                    </div>
                  </div>
                  <p class="card-text"><strong>Address:</strong> <?php echo htmlspecialchars($row['address']); ?></p>
                  <p class="card-text"><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                  <p class="card-text"><strong>Rooms:</strong> <?php echo $row['numberofRooms']; ?></p>
                  <p class="card-text"><strong>Price:</strong> ₱<?php echo number_format($row['price']); ?></p>
                  <p class="card-text"><strong>Images:</strong></p>
                </div>

                  <?php if (count($images) > 0): ?>
                    <div class="p-3 d-flex flex-wrap gap-3">
                      <?php foreach ($images as $img): ?>
                        <div class="position-relative border rounded overflow-hidden" style="width: 150px;">
                          <img src="<?php echo $img['image']; ?>" alt="Property Image" class="img-fluid" style="height: 120px; object-fit: contain;">
                          <form action="delete_property_images.php" method="POST" onsubmit="return confirm('Are you sure you want to delete this image?');" class="position-absolute top-0 end-0 m-1">
                            <input type="hidden" name="imageID" value="<?php echo $img['propertyImageID']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger" title="Delete Image">&times;</button>
                          </form>
                        </div>
                      <?php endforeach; ?>
                    </div>
                  <?php else: ?>
                    <div class="p-3 text-muted text-center">No images uploaded.</div>
                  <?php endif; ?>

                  <div class="card-footer bg-light">
                    <form action="upload_image.php" method="POST" enctype="multipart/form-data" class="d-flex gap-2 align-items-center">
                      <input type="hidden" name="propertyID" value="<?php echo $propertyID; ?>">
                      <div class="flex-grow-1">
                        <input type="file" name="image" class="form-control" accept="image/*" required>
                      </div>
                      <button type="submit" name="upload" class="btn btn-sm btn-outline-primary">Upload Image</button>
                    </form>
                  </div>
              </div>
            </div>

          <?php
            endforeach;
          else:
            echo "<div class='col-12'><p class='text-center text-muted'>No properties found.</p></div>";
          endif;
          ?>
          
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