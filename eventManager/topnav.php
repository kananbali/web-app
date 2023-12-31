<?php
include("../functions.php");
// include("../config.php");
$connected_successfully = false; // Flag for successfull connection.
$database_name = 'eventmanager';        // Name of the database.
$hostname = 'localhost';         // IP Adddress of server in our case just localhost as the server is hosted on a local machine.
$username = 'root';              // username for the database user.
$password = 'root';// password for the user.
$currency = 'Rs: ';
$mysqli = new mysqli($hostname, $username, $password, $database_name);

$name = $_SESSION['name'];
?>
<nav class="navbar navbar-top navbar-expand navbar-dashboard navbar-dark ps-0 pe-2 pb-0">
      <div class="container-fluid px-0">
        <div class="d-flex justify-content-between w-100" id="navbarSupportedContent">
          <div class="d-flex align-items-center">
            
            <!-- Search form -->
            <form class="navbar-search form-inline" id="navbar-search-main">
              <div class="input-group input-group-merge search-bar"></div>
            </form>
          </div>

          <!-- Navbar links -->
              <a class="nav-link dropdown-toggle pt-1 px-0" href="#" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                <div class="media d-flex align-items-center">
                  <img class="avatar rounded-circle" alt="Image placeholder" src="../userProfile/<?=getUserImage($mysqli)?>">
                  <div class="media-body ms-2 text-dark align-items-center d-none d-lg-block">
                    <span class="mb-0 font-small fw-bold text-gray-900"><?=$name?></span>
                  </div>
                </div>
              </a>
              <div class="dropdown-menu dashboard-dropdown dropdown-menu-end mt-2 py-1">
                <a class="dropdown-item d-flex align-items-center" href="../login/logout.php">
                  <svg class="dropdown-icon text-danger me-2" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"></path>
                  </svg>
                  Logout
                </a>
              </div>
            </li>
          </ul>
        </div>
      </div>
    </nav>