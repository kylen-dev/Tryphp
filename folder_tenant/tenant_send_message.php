<?php
    session_start();
    include 'connection_tenant.php';

    if (isset($_POST['send'])) {
        $senderID = $_SESSION['userID'];
        $receiverID = $_POST['receiverID'] ?? null;
        $propertyID = $_POST['propertyID'] ?? null;
        $message = trim($_POST['message']);

        if ($receiverID && $propertyID && !empty($message)) {
            $stmt = $pdo->prepare("INSERT INTO messages (senderID, receiverID, propertyID, message) VALUES (?, ?, ?, ?)");
            $stmt->execute([$senderID, $receiverID, $propertyID, $message]);
            header("Location: tenant_view_conversation.php?landlordID=$receiverID&propertyID=$propertyID&sent=1");
            exit();
        } else {
            header("Location: tenant_view_conversation.php?landlordID=$receiverID&propertyID=$propertyID&error=1");
            exit();
        }
    }
?>
