<?php
    session_start();
    include 'connection_landlord.php';

    if (isset($_POST['send'])) {
        $senderID = $_SESSION['userID'];
        $receiverID = $_POST['receiverID'] ?? null;
        $propertyID = $_POST['propertyID'] ?? null;
        $message = trim($_POST['message']);

        if ($receiverID && $propertyID && !empty($message)) {
            $stmt = $pdo->prepare("INSERT INTO messages (senderID, receiverID, propertyID, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$senderID, $receiverID, $propertyID, $message]);

            header("Location: landlord_view_conversation.php?tenantID=$receiverID&propertyID=$propertyID&sent=1");
            exit();
        } else {
            header("Location: landlord_view_conversation.php?tenantID=$receiverID&propertyID=$propertyID&error=1");
            exit();
        }
    }
?>
