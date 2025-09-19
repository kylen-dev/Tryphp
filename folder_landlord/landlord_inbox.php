<?php
    session_start();
    $page = 'inbox';
    include '../head.php';
    include 'navbar_landlord.php';
    include 'connection_landlord.php';

    $landlordID = $_SESSION['userID'];
    $stmt = $pdo->prepare("
      SELECT m.*, t.firstName AS tenantFirstName, t.lastName AS tenantLastName, p.propertyName
      FROM (
        SELECT senderID, propertyID, MAX(sentAt) AS lastMsgTime
        FROM messages
        WHERE receiverID = ?
        GROUP BY senderID, propertyID
      ) AS conv
      JOIN messages m 
        ON m.senderID = conv.senderID 
      AND m.propertyID = conv.propertyID 
      AND m.sentAt = conv.lastMsgTime
      JOIN users t ON m.senderID = t.userID
      JOIN properties p ON m.propertyID = p.propertyID
      ORDER BY m.sentAt DESC
    ");
    $stmt->execute([$landlordID]);
    $messages = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>" />
    <title>Landlord Inbox</title>
</head>

<body>
    <div class="container">
      <div class="container-fluid">
        <h3 class="mt-3" >Inbox</h3>
        <?php if (count($messages) > 0): ?>
          <ul class="list-group">
            <?php foreach ($messages as $msg): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <strong><?= htmlspecialchars($msg['tenantFirstName'] . ' ' . $msg['tenantLastName']) ?></strong><br>
                  <small><em><?= htmlspecialchars($msg['propertyName']) ?></em></small><br>
                  <small class="text-muted"><?= date("M d, Y H:i", strtotime($msg['sentAt'])) ?></small>
                </div>
                <a href="landlord_view_conversation.php?tenantID=<?= $msg['senderID'] ?>&propertyID=<?= $msg['propertyID'] ?>" class="btn btn-outline-primary btn-sm">
                  View Conversation
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <div class="alert alert-info mt-4">No conversations yet.</div>
        <?php endif; ?>
        </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>

</body>
</html>
