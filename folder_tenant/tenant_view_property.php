<?php
    session_start();
    include 'connection_tenant.php'; 
    include '../head.php';
    include 'navbar_tenant.php';

    if (!isset($_GET['id'])) {
        echo "No property selected.";
        exit();
    }

    $propertyID = $_GET['id'];

    // Fetch property and landlord info
    $stmt = $pdo->prepare("
        SELECT p.*, u.firstName, u.lastName
        FROM properties p
        JOIN users u ON p.landlordID = u.userID
        WHERE p.propertyID = ?
    ");
    $stmt->execute([$propertyID]);
    $property = $stmt->fetch();

    if (!$property) {
        echo "Property not found.";
        exit();
    }

    // Fetch all images
    $imageStmt = $pdo->prepare("SELECT image FROM propertyImages WHERE propertyID = ?");
    $imageStmt->execute([$propertyID]);
    $images = $imageStmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>" />
    <title><?php echo htmlspecialchars($property['propertyName']); ?> - Property Details</title>
</head>

<body>
    <div class="container">
        <a href="tenant_view_all_properties.php" class="btn btn-outline-secondary m-3">Back to Listings</a>

        <div class="card shadow-lg">
            <div class="card-header bg-primary text-white">
                <h3 class="mb-0"><?php echo htmlspecialchars($property['propertyName']); ?></h3>
            </div>
            <div class="card-body">
                <!-- Image Gallery -->
                <?php if (count($images) > 0): ?>
                    <div class="row mb-4">
                        <?php foreach ($images as $img): ?>
                            <div class="col-md-4 mb-3">
                                <div class="border rounded p-2 bg-white">
                                    <img src="../folder_landlord/<?php echo htmlspecialchars($img['image']); ?>" 
                                        alt="Property Image" class="img-fluid"
                                        style="height: 200px; width: 100%; object-fit: contain;">
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="text-muted mb-4">No images uploaded.</div>
                <?php endif; ?>

                <!-- Property Details -->
                <p><strong>Address:</strong> <?php echo htmlspecialchars($property['address']); ?></p>
                <p><strong>Description:</strong><br><?php echo nl2br(htmlspecialchars($property['description'])); ?></p>
                <p><strong>Number of Rooms:</strong> <?php echo $property['numberofRooms']; ?></p>
                <p><strong>Price:</strong> ₱<?php echo number_format($property['price'], 2); ?></p>
                <p class="text-muted"><strong>Posted by:</strong> <?php echo htmlspecialchars($property['firstName'] . ' ' . $property['lastName']); ?></p>
            </div>

            
        <form action="tenant_booking_request.php" method="POST">
            <input type="hidden" name="propertyID" value="<?php echo $propertyID; ?>">
            <button type="submit" name="book_request" class="btn btn-primary m-3">
                Request to Book
            </button>
        </form>

        </div>

        <?php
            if (isset($_GET['sent']) || isset($_GET['error'])) {
                $alertType = isset($_GET['sent']) ? 'success' : 'danger';
                $alertMessage = isset($_GET['sent']) 
                    ? 'Message sent to the landlord!' 
                    : 'Please enter a message before sending.';

                echo "<div class='alert alert-$alertType'>$alertMessage</div>";
            }
        ?>

        <hr>
        <h5>Contact the Landlord</h5>
        <form action="tenant_send_message.php" method="POST">
            <input type="hidden" name="receiverID" value="<?php echo $property['landlordID']; ?>">
            <input type="hidden" name="propertyID" value="<?php echo $propertyID; ?>">
            <div class="mb-3">
                <textarea name="message" class="form-control" rows="2" placeholder="Write your message here..." required></textarea>
            </div>
            <button type="submit" name="send" class="btn btn-primary">Send Message</button>
        </form>

    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>

</body>
</html>
