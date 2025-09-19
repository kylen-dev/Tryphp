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

// ✅ Use your shared Postgres connection
require_once __DIR__ . '/inc/db.php';

$error = '';

// Register new user
if (isset($_POST['register'])) {
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $userID = $_POST['userID'];
    $email = $_POST['email'];
    $role = $_POST['role'];
    $password = password_hash($_POST['password'], PASSWORD_BCRYPT);

    // Check for duplicate userID
    $stmt_check = $pdo->prepare("SELECT 1 FROM users WHERE userID = ?");
    $stmt_check->execute([$userID]);

    if ($stmt_check->rowCount() > 0) {
        $error = "userID already exists!";
    } else {
        $sql = "INSERT INTO users (firstName, lastName, userID, email, role, password, status) 
                VALUES (?, ?, ?, ?, ?, ?, 'pending')";
        $stmt = $pdo->prepare($sql);

        if ($stmt->execute([$firstName, $lastName, $userID, $email, $role, $password])) {
            echo '<script type="text/javascript">
                    alert("Your account is now pending for approval!");
                    window.location.href = "login.php";
                  </script>';
            exit();
        } else {
            $error = "Registration unsuccessful!";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Registration Page</title>
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css"
      rel="stylesheet"
      integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH"
      crossorigin="anonymous"
    />
    <link rel="stylesheet" href="css/style.css?v=<?php echo time(); ?>" />
    <link
      href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css"
      rel="stylesheet"
    />
  </head>
  
<body>
    <div class="container">
      <div class="row mt-4 justify-content-center">
        <div class="col-lg-5 col-md-12">
          <h2 class="text-center logo "><img src="" alt="Logo"></h2>
          <div class="card border-secondary p-0 m-4">
            <div class="card-header p-3 text-center text-danger register">REGISTRATION</div>
            <div class="card-body text-secondary">
              <form action="" method="POST" class="needs-validation" novalidate >
                <div class="row g-2">

                  <div class="col-6">
                    <div class="mb-3">
                      <label for="firstName" class="form-label">First name</label>
                      <input type="text" class="form-control" id="firstName" name = "firstName" placeholder="Enter First Name" required />
                      <div class="invalid-feedback">First Name is required</div>
                    </div>
                  </div>

                  <div class="col-6">
                    <div class="mb-3">
                      <label for="lastName" class="form-label">Last name</label>
                      <input type="text" class="form-control"id="lastName" name = "lastName" placeholder="Enter Last Name" required />
                      <div class="invalid-feedback"> Last Name is required</div>
                    </div>
                  </div>

                  <div class="mb-3">
                    <?php if (!empty($error)) : ?>
                    <div class="alert alert-danger"><?php echo $error; ?></div>
                    <?php endif; ?>
                    <label for="userID" class="form-label">User ID or Student Number</label>
                    <input type="text" class="form-control" id="userID" name = "userID" placeholder="Enter User ID or Student Number" required />
                    <div class="invalid-feedback">userID/Student Number is required</div>
                  </div>

                  <div class="mb-3">
                    <label for="email" class="form-label">Email address</label>
                    <input type="email" class="form-control" id="email" name = "email" placeholder="Enter email" required />
                    <div class="invalid-feedback">Enter valid email</div>
                  </div>

                  <div class="mb-3">
                    <label for="role" class="form-label">Role</label>
                    <select class="form-select" class="form-control" id="role" name="role" required>
                        <option value="">Choose...</option>
                        <option value="Tenant">Tenant</option>
                        <option value="Landlord">Landlord</option>
                    </select>
                  </div>

                  <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name = "password" placeholder="Enter password" required />
                    <div class="invalid-feedback">Password is required</div>
                  </div>
                  <div class="mb-3">
                  <button class="btn btn-primary w-100" type="submit" name="register"> Register
                  </button>
                </div>
                <div class="mb-3">
                  <span>Have an account? <a id="link" href="login.php">Login</a></span>
                </div>
              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    <script
      src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"
      integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz"
      crossorigin="anonymous"
    ></script>
    <script src="js/script.js"></script>

</body>
</html>
