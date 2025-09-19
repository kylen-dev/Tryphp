<?php 
  session_start();
  include 'connection_admin.php';
  include 'navbar_admin.php';
  include '../head.php';
       
    //Register new user
      if (isset($_POST['register'])) {

      $firstName = $_POST['firstName'];
      $lastName = $_POST['lastName'];
      $userID = $_POST['userID'];
      $email = $_POST['email'];
      $role = $_POST['role'];
      $password = password_hash($_POST['password'], PASSWORD_BCRYPT);
      
      $stmt_check = $pdo->prepare("SELECT * FROM users WHERE userID = ?");
      $stmt_check->execute([$userID]);

      if ($stmt_check->rowCount() > 0) {
        $error = "userID already exists!";
      } else {
        $sql = "INSERT INTO users (firstName, lastName, userID, email, role, password, status) VALUES (?, ?, ?, ?, ?, ?, 'approved')";
        $stmt = $pdo->prepare($sql);
        if ($stmt->execute([$firstName, $lastName, $userID, $email, $role, $password])) {
            echo "Registration successful!";
            header("location: admin_main.php");
        } else {
            echo "Registration unsuccessful!";
        }
      }
    }
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <link rel="stylesheet" href="../css/style.css?v=<?php echo time(); ?>" />
    <title>Registration Page</title>
  </head>

  <body>  
    <div class="container">
      <div class="row mt-4 justify-content-center">
        <div class="col-lg-5 col-md-12">
          <div class="card border-secondary p-0 m-4">
            <div class="card-header p-3 text-center text-danger register">REGISTER NEW ADMIN</div>
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
                        <option value="Admin">Admin</option>
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
