<nav class="navbar navbar-expand-lg bg-body-tertiary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#"
      ><img
        src=""
        width="50"
        height="50"
        alt="Logo "
    /></a>
    <button
      class="navbar-toggler"
      type="button"
      data-bs-toggle="collapse"
      data-bs-target="#navbarNav"
      aria-controls="navbarNav"
      aria-expanded="false"
      aria-label="Toggle navigation"
    >
    <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?php echo ($page === 'admins') ? 'active' : ''; ?>" href="admin_main.php"><i class="fa-solid fa-user icon"></i>Admins</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($page === 'tenants') ? 'active' : ''; ?>" href="manage_tenants.php">
          <i class="fa-solid fa-table-list icon"></i>Tenants</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($page === 'landlords') ? 'active' : ''; ?>" href="manage_landlords.php"><i class="fa-solid fa-table-list icon"></i>Landlords</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($page === 'pending_users') ? 'active' : ''; ?>" href="pending_users.php">
          <i class="fa-solid fa-table-list icon"></i>Pending Users</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../logout.php" onclick="return confirm('Do you want to logout?')"> <i class="fa fa-sign-out icon" aria-hidden="true"></i>Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>