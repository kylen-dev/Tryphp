<?php
    session_start();
    $page = 'view_properties';
    include 'connection_tenant.php'; 
    include '../head.php';
    include 'navbar_tenant.php';

    if (!isset($_SESSION['userID']) || $_SESSION['role'] !== 'Tenant') {
    header("Location: ../login.php");
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>" />
    <title>Available Properties</title>
</head>

<body>
  <div class="container">
    <div class="container-fluid">
      <h2 class="m-3">All Available Properties</h2>

      <div class="row">
        <?php
          $stmt = $pdo->query("
          SELECT p.*, u.firstName, u.lastName 
          FROM properties p 
          JOIN users u ON p.landlordID = u.userID
          ");

          if ($stmt->rowCount() > 0) {
            foreach ($stmt->fetchAll() as $row) {
            // Fetch one image associated with the property
            $imageStmt = $pdo->prepare("SELECT image FROM propertyImages WHERE propertyID = ? 
            LIMIT 1");
            $imageStmt->execute([$row['propertyID']]);
            $image = $imageStmt->fetch();

            // Prepend folder if image is stored inside landlord/uploads/
            $imagePath = $image ? "../folder_landlord/" . $image['image'] : "../folder_landlord/uploads/default.jpg";
        ?>

          <div class="col-md-4 mb-4">
            <div class="card shadow-sm h-100">
              <div class="image-container" style="height: 250px; overflow: hidden; display: flex; justify-content: center; align-items: center; background: #f9f9f9;">
                <img src="<?php echo htmlspecialchars($imagePath); ?>" 
                      alt="No Uploaded Image"
                      style="max-height: 100%; max-width: 100%; object-fit: contain;">
              </div>
              <div class="card-body d-flex flex-column">
                <h5 class="card-title text-primary">
                  <?php echo htmlspecialchars($row['propertyName']); ?>
                </h5>
                <p class="card-text mb-1"><?php echo nl2br(htmlspecialchars($row['description'])); ?></p>
                <p class="card-text mb-1"><strong>Rooms:</strong> <?php echo $row['numberofRooms']; ?></p>
                <p class="card-text mb-1"><strong>Price:</strong> ₱<?php echo $row['price']; ?></p>
                <p class="card-text text-muted small mt-auto">
                  Posted by <?php echo htmlspecialchars($row['firstName'] . ' ' . $row['lastName']); ?>
                </p>
                <a href="tenant_view_property.php?id=<?php echo $row['propertyID']; ?>" class="btn btn-primary btn-sm mt-2">View Details</a>
              </div>
            </div>
          </div>

        <?php
          }
        } else {
          echo "<p>No properties available at the moment.</p>";
        }
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
