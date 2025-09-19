<?php
    include 'connection_landlord.php';

    if (isset($_POST['upload']) && isset($_FILES['image'])) {
        $propertyID = $_POST['propertyID'];
        $imageName = $_FILES['image']['name'];
        $tempPath = $_FILES['image']['tmp_name'];
        $uploadFolder = 'uploads/';

        if (!is_dir($uploadFolder)) {
            mkdir($uploadFolder, 0777, true);
        }

        $imagePath = $uploadFolder . uniqid() . "_" . basename($imageName);
        if (move_uploaded_file($tempPath, $imagePath)) {
            $stmt = $pdo->prepare("INSERT INTO propertyimages (propertyID, image) VALUES (?, ?)");
            if ($stmt->execute([$propertyID, $imagePath])) {
                header("location: landlord_main.php");
            } else {
                echo "Database insert failed!";
            }
        } else {
            echo "Failed to move uploaded file.";
        }
    }
?>
