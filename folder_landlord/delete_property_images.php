<?php
    include 'connection_landlord.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['imageID'])) {
        $imageID = $_POST['imageID'];

        // Get the image path first to delete the file (optional)
        $stmt = $pdo->prepare("SELECT image FROM propertyImages WHERE propertyImageID = ?");
        $stmt->execute([$imageID]);
        $image = $stmt->fetch();

        if ($image) {
            // Delete the image file from server (optional)
            $filePath = $image['image'];
            if (file_exists($filePath)) {
                unlink($filePath);
            }

            // Delete from database
            $delete = $pdo->prepare("DELETE FROM propertyImages WHERE propertyImageID = ?");
            $delete->execute([$imageID]);
        }
    }

    header("Location: landlord_main.php");
    exit();
?>
