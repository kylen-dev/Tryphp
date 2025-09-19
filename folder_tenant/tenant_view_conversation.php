<?php
    session_start();
    include '../head.php';
    include 'navbar_tenant.php';
    include 'connection_tenant.php';

    $tenantID = $_SESSION['userID'];
    $landlordID = $_GET['landlordID'] ?? null;
    $propertyID = $_GET['propertyID'] ?? null;

    if (!$landlordID || !$propertyID) {
        echo "Invalid conversation.";
        exit();
    }

    // Fetch property and landlord details
    $propertyStmt = $pdo->prepare("SELECT propertyName FROM properties WHERE propertyID = ?");
    $propertyStmt->execute([$propertyID]);
    $property = $propertyStmt->fetch();

    $landlordStmt = $pdo->prepare("SELECT firstName, lastName FROM users WHERE userID = ?");
    $landlordStmt->execute([$landlordID]);
    $landlord = $landlordStmt->fetch();

    // Fetch conversation messages
    $msgStmt = $pdo->prepare("
        SELECT m.*, 
            s.firstName AS senderFirstName, 
            s.role AS senderRole
        FROM messages m
        JOIN users s ON m.senderID = s.userID
        WHERE ((m.senderID = ? AND m.receiverID = ?) OR (m.senderID = ? AND m.receiverID = ?))
        AND m.propertyID = ?
        ORDER BY m.sentAt ASC
    ");
    $msgStmt->execute([$landlordID, $tenantID, $tenantID, $landlordID, $propertyID]);
    $messages = $msgStmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>" />
    <title>Conversation</title>
</head>

<body>
    <div class="container">
        <a href="tenant_inbox.php" class="btn btn-secondary btn-sm mt-3 mb-3" name="message_landlord">Back to Inbox</a>
        <h4>Conversation with <?= htmlspecialchars($landlord['firstName'] . ' ' . $landlord ['lastName']) ?> about 
            <span class="text-primary"><?= htmlspecialchars($property['propertyName']) ?></span>
        </h4>

        <div class="mb-4" style="max-height: 400px; overflow-y: auto;">
            <?php if (count($messages) > 0): ?>
                <?php foreach ($messages as $msg): ?>
                    <div class="mb-3 p-3 rounded <?= $msg['senderID'] == $tenantID ? 'bg-light' : 'bg-primary text-white' ?>">
                        <div class="d-flex justify-content-between mb-1">
                            <strong><?= htmlspecialchars($msg['senderFirstName']) ?></strong>
                            <small><?= date("M d, Y H:i", strtotime($msg['sentAt'])) ?></small>
                        </div>
                        <div><?= nl2br(htmlspecialchars($msg['message'])) ?></div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div class="alert alert-info">No messages yet.</div>
            <?php endif; ?>
        </div>

        <!-- Message reply form -->
        <form action="tenant_send_message.php" method="POST">
            <input type="hidden" name="receiverID" value="<?= $landlordID ?>">
            <input type="hidden" name="propertyID" value="<?= $propertyID ?>">
            <textarea name="message" class="form-control mb-2" required></textarea>
            <button type="submit" name="send" class="btn btn-primary btn-sm">Send</button>
        </form>
    </div>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
        integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
        crossorigin="anonymous"
        ></script>
        
</body>
</html>
