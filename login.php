<?php
session_start();

// Redirect if already logged in
if (isset($_SESSION['userID'])) {
    switch ($_SESSION['role'] ?? '') {
        case 'Landlord':
            header("Location: folder_landlord/landlord_main.php");
            exit();
        case 'Tenant':
            header("Location: folder_tenant/tenant_main.php");
            exit();
        case 'Admin':
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
    // Stop execution if connection fails
    die("Database connection failed: " . $e->getMessage());
}

$error = '';

// Handle login
if (isset($_POST['login'])) {

    $userID = trim($_POST['userID'] ?? '');
    $password = $_POST['password'] ?? '';

    if ($userID && $password) {
        $stmt = $pdo->prepare("SELECT * FROM users WHERE userID = ?");
        $stmt->execute([$userID]);
        $user = $stmt->fetch();

        if ($user) {
            if (($user['status'] ?? '') !== 'approved') {
                $error = "<span class='text-danger'>Your account is still pending for approval.</span>";
            } elseif (password_verify($password, $user['password'] ?? '')) {
                // Set session safely
                $_SESSION['userID'] = $user['userID'] ?? '';
                $_SESSION['lastName'] = $user['lastName'] ?? '';
                $_SESSION['firstName'] = $user['firstName'] ?? '';
                $_SESSION['email'] = $user['email'] ?? '';
                $_SESSION['role'] = $user['role'] ?? '';

                // Redirect based on role
                switch ($_SESSION['role']) {
                    case 'Landlord':
                        header("Location: folder_landlord/landlord_main.php");
                        exit();
                    case 'Tenant':
                        header("Location: folder_tenant/tenant_main.php");
                        exit();
                    case 'Admin':
                        header("Location: folder_admin/admin_main.php");
                        exit();
                }
            } else {
                $error = "<span class='text-danger'>Invalid password!</span>";
            }
        } else {
            $error = "<span class='text-danger'>User not found!</span>";
        }
    } else {
        $error = "<span class='text-danger'>Please enter both User ID and Password.</span>";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login Page</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>">
</head>
<body>
<div class="container">
    <div class="row mt-4 justify-content-center">
        <div class="col-lg-5 col-md-12">
            <h2 class="text-center logo"><img src="" alt="LOGO"></h2>
            <div class="card border-danger p-2 m-2">
                <div class="card-body text-secondary">
                    <?php if(!empty($error)) echo $error; ?>
                    <form action="" method="post" class="needs-validation" novalidate>
                        <div class="mb-3">
                            <label for="userID" class="form-label">User ID or Student Number</label>
                            <input type="text" class="form-control" id="userID" name="userID" placeholder="Enter User ID or Student Number" required>
                        </div>
                        <div class="mb-3">
                            <label for="password" class="form-label">Password</label>
                            <input type="password" class="form-control" id="password" name="password" placeholder="Enter password" required>
                            <div class="invalid-feedback">Password is required</div>
                        </div>
                        <div class="mb-3">
                            <input class="btn btn-primary w-100" type="submit" name="login" value="Login">
                        </div>
                        <div class="mb-3">
                            <span>Don't have an account? <a href="register.php">Create one</a></span>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
