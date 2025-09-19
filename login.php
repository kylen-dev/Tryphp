<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['userID'])) {
    switch ($_SESSION['role']) {
        case 'Landlord':
            header("Location: folder_landlord/landlord_main.php");
            exit();
        case 'Tenant':
            header("Location: folder_tenant/tenant_main.php");
            exit();
        default:
            header("Location: folder_admin/admin_main.php");
            exit();
    }
}

// PostgreSQL connection
$host = "dpg-d36gje7fte5s73bf098g-a.singapore-postgres.render.com";
$dbname = "tryphpdb";
$username = "tryphpdb_user";
$password = "NUIHpl2WRo2VBQZleyO6LmLiwnrQhFcc";

try {
    $pdo = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Connection failed: " . $e->getMessage());
}

$error = '';

if (isset($_POST['login'])) {
    $userID = $_POST['userID'] ?? '';
    $password = $_POST['password'] ?? '';

    if (!$userID || !$password) {
        $error = "<span class='text-danger'>Please fill in both fields.</span>";
    } else {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE userID = ?");
        $stmt->execute([$userID]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($user) {
            if (!isset($user['password'], $user['status'], $user['role'])) {
                $error = "<span class='text-danger'>User record is invalid!</span>";
            } elseif ($user['status'] !== 'approved') {
                $error = "<span class='text-danger'>Your account is still pending for approval.</span>";
            } elseif (password_verify($password, $user['password'])) {
                // Safe: only set session after verifying password
                $_SESSION['userID'] = $user['userID'];
                $_SESSION['lastName'] = $user['lastName'] ?? '';
                $_SESSION['firstName'] = $user['firstName'] ?? '';
                $_SESSION['email'] = $user['email'] ?? '';
                $_SESSION['role'] = $user['role'];

                // Redirect based on role
                switch ($user['role']) {
                    case 'Landlord':
                        header("Location: folder_landlord/landlord_main.php");
                        break;
                    case 'Tenant':
                        header("Location: folder_tenant/tenant_main.php");
                        break;
                    default:
                        header("Location: folder_admin/admin_main.php");
                }
                exit();
            } else {
                $error = "<span class='text-danger'>Invalid password!</span>";
            }
        } else {
            $error = "<span class='text-danger'>User not found!</span>";
        }
    }
}
?>
