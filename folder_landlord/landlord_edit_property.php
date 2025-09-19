<?php
    session_start();
    include '../head.php';
    include 'connection_landlord.php';
    include 'navbar_landlord.php';
    
    $propertyID = $_GET['id'];

    // Fetch property data
    $stmt = $pdo->prepare("SELECT * FROM properties WHERE propertyID = ?");
    $stmt->execute([$propertyID]);
    $property = $stmt->fetch();

    if (!$property) {
        echo "Property not found.";
        exit();
    }

    // Handle form submission
    if (isset($_POST['update'])) {
        $propertyName = $_POST['propertyName'];
        $address = $_POST['address'];
        $description = $_POST['description'];
        $rooms = $_POST['numberofRooms'];
        $price = $_POST['price'];

        $stmt_check = $pdo->prepare("SELECT * FROM properties WHERE propertyName = ? AND propertyID != ?");
        $stmt_check->execute([$propertyName, $propertyID]);

        if ($stmt_check->rowCount() > 0) {
          $error = "PROPERTY NAME already exists!";
        } else {
          $sql = "UPDATE properties SET propertyName = ?, address = ?, description = ?, numberofRooms = ?, price = ? WHERE propertyID = ?";
          $stmt = $pdo->prepare($sql);
          if ($stmt->execute([$propertyName, $address, $description, $rooms, $price, $propertyID])) {
            echo "Registration successful!";
            header("location: landlord_main.php");
          } else {
              echo "Registration unsuccessful!";
          };
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>" />
    <title>Add Property</title>
</head>

<body>
  <div class="container">
    <div class="row mt-8 justify-content-center">
      <div class="col-lg-8 col-md-12">
        <div class="card border-secondary p-0 m-4">
          <div class="card-body text-secondary">
          <h2>Edit Property</h2>

            <form action="" method="POST" class="needs-validation" novalidate>
              <div class="mb-3">
                <?php if (!empty($error)) : ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <label class="form-label">Property Name</label>
                <input type="text" name="propertyName" class="form-control" value="<?php echo htmlspecialchars($property['propertyName']); ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Address</label>
                <input type="text" name="address" class="form-control" value="<?php echo htmlspecialchars($property['address']); ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Description</label>
                <textarea name="description" class="form-control" rows="4"><?php echo htmlspecialchars($property['description']); ?></textarea>
              </div>

              <div class="mb-3">
                <label class="form-label">Number of Rooms</label>
                <input type="number" name="numberofRooms" class="form-control" value="<?php echo htmlspecialchars($property['numberofRooms']); ?>" required>
              </div>

              <div class="mb-3">
                <label class="form-label">Price</label>
                <input type="number" name="price" class="form-control" value="<?php echo htmlspecialchars($property['price']); ?>" required>
              </div>

              <button type="submit" class="btn btn-success" name="update">Update Property</button>

              <a href="landlord_main.php" class="btn btn-secondary">Cancel</a>

            </form>
          </div>
        </div>
      </div>
    </div>
  </div>
</body>
</html>
