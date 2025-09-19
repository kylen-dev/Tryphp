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
          <a class="nav-link <?php echo ($page === 'profile') ? 'active' : ''; ?>" href="landlord_main.php"><i class="fa-solid fa-user icon"></i>Profile</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php echo ($page === 'inbox') ? 'active' : ''; ?>" href="landlord_inbox.php"><i class="fa-solid fa-user icon"></i>Inbox</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="../logout.php" onclick="return confirm('Do you want to logout?')"> <i class="fa fa-sign-out icon" aria-hidden="true"></i>Logout</a>
        </li>
      </ul>
    </div>
  </div>
</nav>