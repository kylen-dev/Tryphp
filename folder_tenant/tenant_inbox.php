<?php
    session_start();
    $page = 'inbox';
    include 'connection_tenant.php';
    include '../head.php';
    include 'navbar_tenant.php';

    $tenantID = $_SESSION['userID'];

    // Get distinct conversations per landlord-property
    $stmt = $pdo->prepare("
        SELECT m.propertyID, p.propertyName, u.firstName AS landlordFirst, u.lastName AS landlordLast, m.senderID, m.receiverID
        FROM messages m
        JOIN properties p ON m.propertyID = p.propertyID
        JOIN users u ON p.landlordID = u.userID
        WHERE (m.senderID = :tenantID OR m.receiverID = :tenantID)
          AND (m.senderID = p.landlordID OR m.receiverID = p.landlordID)
        GROUP BY m.propertyID, p.landlordID
        ORDER BY MAX(m.messageID) DESC
    ");
    $stmt->execute(['tenantID' => $tenantID]);
    $conversations = $stmt->fetchAll();
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>" />
    <title>Inbox</title>
</head>

<body>
    <div class="container">
      <div class="container-fluid">
        <h3 class="mt-3">Your Conversations</h3>
        <?php if (count($conversations) > 0): ?>
          <ul class="list-group mt-4">
            <?php foreach ($conversations as $conv): ?>
              <li class="list-group-item d-flex justify-content-between align-items-center">
                <div>
                  <strong><?php echo htmlspecialchars($conv['propertyName']); ?></strong><br>
                  With: <?php echo htmlspecialchars($conv['landlordFirst'] . ' ' . $conv['landlordLast']); ?>
                </div>
                <a class="btn btn-sm btn-outline-primary" href="tenant_view_conversation.php?landlordID=<?= $conv['senderID'] == $tenantID ? $conv['receiverID'] : $conv['senderID'] ?>&propertyID=<?= $conv['propertyID'] ?>">
                  View Conversation
                </a>
              </li>
            <?php endforeach; ?>
          </ul>
        <?php else: ?>
          <p class="text-muted">No conversations yet.</p>
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
