<?php 
    session_start();
    include '../head.php';
    include 'connection_landlord.php';
    include 'navbar_landlord.php';

    //Register new property
    if (isset($_POST['register'])) {

    $landlordID = $_SESSION['userID'];
    $propertyName = $_POST['propertyName'];
    $address = $_POST['address'];
    $numberofRooms = $_POST['numberofRooms'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    
    $stmt_check = $pdo->prepare("SELECT * FROM properties WHERE propertyName = ?");
    $stmt_check->execute([$propertyName]);

    if ($stmt_check->rowCount() > 0) {
    $error = "PROPERTY NAME already exists!";
    } else {
      $sql = "INSERT INTO properties (landlordID, propertyName, address, numberofRooms, description, price) VALUES (?, ?, ?, ?, ?, ?)";
      $stmt = $pdo->prepare($sql);
      if ($stmt->execute([$landlordID, $propertyName, $address, $numberofRooms, $description, $price])) {
          echo "Registration successful!";
          header("location: landlord_main.php");
      } else {
          echo "Registration unsuccessful!";
      }
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
          <h2 class="text-center">Add Property</h2>
          <div class="card-body text-secondary">
            
            <form action="" method="POST" class="needs-validation" novalidate >
              <div class="mb-3">
                <?php if (!empty($error)) : ?>
                <div class="alert alert-danger"><?php echo $error; ?></div>
                <?php endif; ?>
                <label for="propertyName" class="form-label">PROPERTY NAME</label>
                <input type="text" class="form-control" id="propertyName" name = "propertyName" placeholder="Enter Property Name" required />
                <div class="invalid-feedback">Property Name is required</div>
              </div>
            
              <div class="mb-3">
                <label for="address" class="form-label">ADDRESS</label>
                <input type="text" class="form-control"id="address" name = "address" placeholder="Enter Address" required />
                <div class="invalid-feedback"> Address is required</div>
              </div>
            
              <div class="mb-3">
                <label for="numberofRooms" class="form-label">Number of Rooms</label>
                <input type="text" class="form-control" id="numberofRooms" name = "numberofRooms" placeholder="Enter Number of Rooms" required />
                <div class="invalid-feedback">Number of Rooms is required</div>
              </div>

              <div class="mb-3">
                <label for="description" class="form-label">Description</label>
                <textarea class="form-control" id="description"  rows="4" name = "description" placeholder="Enter description" required></textarea>
                <div class="invalid-feedback">Description is required</div>
              </div>

              <div class="mb-3">
                <label for="price" class="form-label">Price</label>
                <input type="text" class="form-control" id="price" name = "price" placeholder="Enter Price" required />
                <div class="invalid-feedback">Price is required</div>
              </div>

              <button class="btn btn-primary w-100" type="submit" name="register"> Add Property
              </button>
              
            </form>

          </div>
        </div>
      </div>
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
