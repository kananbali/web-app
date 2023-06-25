<?php
$name = $_COOKIE['name'];
$role_id = $_COOKIE['role_id'];
?>
<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0 container">
  <div class="container-fluid px-0">
    <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
      <div class="d-flex align-items-center">
        <!-- Search form -->
        <form class="navbar-search form-inline" id="navbar-search-main">
        </form>
        <!-- / Search form -->
        <a class="navbar-brand" href="/"><img src="images/Logo.png" style="height: 50px;"></a>
      </div>
      <!-- Navbar links -->
      <ul class="navbar-nav align-items-center">
        <li class="nav-item dropdown ms-lg-3">
          <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
            <div class="media d-flex align-items-center">
              <?php if (isset($_COOKIE['user_id'])) {
                echo "
                  <img class='avatar rounded-circle' alt='Image placeholder' src='../assets/img/team/profile-picture-3.jpg'>
                  <div class='media-body ms-2 text-dark align-items-center d-lg-block'>
                    <span class='mb-0 font-small fw-bold text-gray-900'>$name</span>
                  </div>";
              } else {
                echo '<a href="./login/sign-up.php?orgs=1" class="btn  btn-pill btn-outline-gray-500 me-2" aria-label="github button" title="github button">Organise your event
                </a>';
                echo '<a href="./login/login.php" class="btn  btn-pill btn-outline-gray-500 me-2" id="githublogin" aria-label="github button" title="github button">Login
                </a>';
                
              }
              ?>


            </div>
          </a>
          <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
            <?php
            if ($role_id == 2) {
              echo '
                <a class="dropdown-item d-flex align-items-center" href="/eventManager/">
                  <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M 14.970703 2.9726562 A 2.0002 2.0002 0 0 0 13 5 L 13 13 L 5 13 A 2.0002 2.0002 0 1 0 5 17 L 13 17 L 13 25 A 2.0002 2.0002 0 1 0 17 25 L 17 17 L 25 17 A 2.0002 2.0002 0 1 0 25 13 L 17 13 L 17 5 A 2.0002 2.0002 0 0 0 14.970703 2.9726562 z"></path>
                  </svg>
                  Create Event
                </a>';
            } elseif ($role_id == 3) {
              echo '<a class="dropdown-item d-flex align-items-center" href="/eventManager/">
                <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 30 30" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M 14.970703 2.9726562 A 2.0002 2.0002 0 0 0 13 5 L 13 13 L 5 13 A 2.0002 2.0002 0 1 0 5 17 L 13 17 L 13 25 A 2.0002 2.0002 0 1 0 17 25 L 17 17 L 25 17 A 2.0002 2.0002 0 1 0 25 13 L 17 13 L 17 5 A 2.0002 2.0002 0 0 0 14.970703 2.9726562 z"></path>
                </svg>
                Create Event
              </a>
                <a class="dropdown-item d-flex align-items-center" href="/admin/">
                  <svg class="dropdown-icon text-gray-400 me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                    <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
                  </svg>
                  Admin Dashboard
                </a>';
            }
            echo '
                <div role="separator"></div>
                <a class="dropdown-item d-flex align-items-center" href="login/logout.php">
                  <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                  Logout
                </a>
              </div>
              ';
            ?>
        </li>
      </ul>
    </div>
  </div>
</nav>