<?php
session_start();
$page = 'inbox';

// Include Postgres PDO connection
include 'connection_tenant.php'; // Make sure this returns $pdo connected to Postgres

$tenantID = $_SESSION['userID'] ?? null;

if (!$tenantID || $_SESSION['role'] !== 'Tenant') {
    header("Location: ../login.php");
    exit();
}

// Get distinct conversations per landlord-property
$stmt = $pdo->prepare("
    SELECT 
        m.propertyid, 
        p.propertyname, 
        u.firstname AS landlordfirst, 
        u.lastname AS landlordlast,
        MAX(m.messageid) AS lastmessageid,
        m.senderid, 
        m.receiverid
    FROM messages m
    JOIN properties p ON m.propertyid = p.propertyid
    JOIN users u ON p.landlordid = u.userid
    WHERE (:tenantID = m.senderid OR :tenantID = m.receiverid)
      AND (p.landlordid = m.senderid OR p.landlordid = m.receiverid)
    GROUP BY m.propertyid, p.propertyname, u.firstname, u.lastname, m.senderid, m.receiverid
    ORDER BY lastmessageid DESC
");
$stmt->execute(['tenantID' => $tenantID]);
$conversations = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
            <?php if (!empty($conversations)): ?>
                <ul class="list-group mt-4">
                    <?php foreach ($conversations as $conv): ?>
                        <li class="list-group-item d-flex justify-content-between align-items-center">
                            <div>
                                <strong><?php echo htmlspecialchars($conv['propertyname']); ?></strong><br>
                                With: <?php echo htmlspecialchars($conv['landlordfirst'] . ' ' . $conv['landlordlast']); ?>
                            </div>
                            <a class="btn btn-sm btn-outline-primary" 
                               href="tenant_view_conversation.php?landlordID=<?= $conv['senderid'] == $tenantID ? $conv['receiverid'] : $conv['senderid'] ?>&propertyID=<?= $conv['propertyid'] ?>">
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
            integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
            crossorigin="anonymous"></script>
</body>
</html>
