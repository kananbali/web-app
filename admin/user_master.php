<?php
// session_start();

require_once "pdo.php";
require_once 'checkaccess.php';
require_once "util.php";

// // var_dump($_SESSION);
// $user_id = intval($_SESSION['user_id']);
// // display_message();

// // opcache_reset();
// //IF THE SHOW INACTIVE RECORDS BUTTON IS CLICKED
// if (isset($_POST['inactive_records_selection'])) {
//   $_SESSION['inactive_records_selection'] = "yes";
//   header('Location: user_master.php');
//   return;
// }

// if (isset($_POST['user_filter'])) {
//   $_SESSION['users'] = "yes";

//   header('Location: user_master.php');
//   return;
// }
// if (isset($_POST['event_manager_filter'])) {
//   $_SESSION['event_managers'] = "yes";
//   header('Location: user_master.php');
//   return;
// }
// if (isset($_POST['admin_filter'])) {
//   $_SESSION['admins'] = "yes";
//   header('Location: user_master.php');
//   return;
// }
// if (isset($_POST['all_filter'])) {
//   $_SESSION['all'] = "yes";
//   header('Location: user_master.php');
//   return;
// }

// // SELECT COMMAND
// if (isset($_SESSION['inactive_records_selection'])) {
//   $stmt = $pdo->query("SELECT `user_id`,`name`,email_id,mobile_no,signup_method,role_preference,effective_from_dt,effective_end_dt,assigned_roles
//                        FROM user_master
//                        ORDER BY effective_end_dt DESC");
//   $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//   unset($_SESSION['inactive_records_selection']);
// } else {
//   if (isset($_SESSION['users'])) {
//     $usr = "active";
//     $evm = "";
//     $adm = "";
//     $allfill = "";
//     $stmt = $pdo->query(
//       "SELECT `user_id`,`name`,email_id,mobile_no,signup_method,role_preference,effective_from_dt,effective_end_dt,assigned_roles
//          FROM user_master
//          WHERE effective_end_dt IS NULL AND role_preference = 1
//          ORDER BY name ASC"
//     );
//     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     unset($_SESSION['users']);
//   } else if (isset($_SESSION['event_managers'])) {
//     $usr = "";
//     $evm = "active";
//     $adm = "";
//     $allfill = "";
//     $stmt = $pdo->query(
//       "SELECT `user_id`,`name`,email_id,mobile_no,signup_method,role_preference,effective_from_dt,effective_end_dt,assigned_roles
//         FROM user_master
//          WHERE effective_end_dt IS NULL AND role_preference = 2
//          ORDER BY name ASC"
//     );
//     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     unset($_SESSION['event_managers']);
//   } else if (isset($_SESSION['admins'])) {
//     $usr = "";
//     $evm = "";
//     $adm = "active";
//     $allfill = "";
//     $stmt = $pdo->query(
//       "SELECT `user_id`,`name`,email_id,mobile_no,signup_method,role_preference,effective_from_dt,effective_end_dt,assigned_roles
//         FROM user_master
//          WHERE effective_end_dt IS NULL AND role_preference = 3
//          ORDER BY name ASC"
//     );
//     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     unset($_SESSION['admins']);
//   }
//   //show all users by default
//   else {
//     $usr = "";
//     $evm = "";
//     $adm = "";
//     $allfill = "active";
//     $stmt = $pdo->query(
//       "SELECT `user_id`,`name`,email_id,mobile_no,signup_method,role_preference,effective_from_dt,effective_end_dt,assigned_roles
//         FROM user_master
//          WHERE effective_end_dt IS NULL
//          ORDER BY name ASC LIMIT 5"
//     );
//     $users = $stmt->fetchAll(PDO::FETCH_ASSOC);
//     unset($_SESSION['all']);
//   }
// }

//If make user inactive button is clicked
if (isset($_POST['set_inactive'])) {
  if (isset($_POST['delete'])) {
    $date = date("yy-m-d");
    foreach ($_POST['delete'] as $deleteid) {

      if ($user_id == $deleteid) {
        $_SESSION['message'] = 'Cannot set yourself inactive.';
        $_SESSION['status'] = "error";
        $_SESSION['title'] = "Error";
        header('Location: user_master.php');
        return;
      }
      $sql = "UPDATE user_master
              SET effective_end_dt = :effective_end_dt
              WHERE user_id = " . $deleteid;
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':effective_end_dt' => $date
      ));
    }
    $_SESSION['message'] = 'Selected users Set Inactive.';
    $_SESSION['status'] = "success";
    $_SESSION['title'] = "Success!";

    header('Location: user_master.php');
    return;
  } else {
    $_SESSION['message'] = 'No users are Chosen to Set Inactive.';
    $_SESSION['status'] = "warning";
    $_SESSION['title'] = "Warning!";
    header('Location: user_master.php');
    return;
  }
}


if (isset($_POST['edit'])) {
  if (isset($_POST['delete'])) {
    foreach ($_POST['delete'] as $deleteid) {
      $name = $_POST['name' . $deleteid . ''];
      $email_id = $_POST['email_id' . $deleteid . ''];
      $mobile_no = $_POST['mobile_no' . $deleteid . ''];
      $signup_method = $_POST['signup_method' . $deleteid . ''];
      $role_preference = intval($_POST['role_preference' . $deleteid . '']);

      $role = $_POST['assigned_roles' . $deleteid . ''];

      var_dump($role_preference);

      // var_dump($role);


      $assigned_roles = json_decode($role)->roles;


      if (!in_array($role_preference, $assigned_roles)) {
        array_push($assigned_roles, $role_preference);

        var_dump($assigned_roles);


        $sql = "UPDATE user_master
              SET 
              name = :name,
              email_id = :email_id,
              mobile_no = :mobile_no,
              signup_method = :signup_method,
              role_preference = :role_preference,
              assigned_roles = :assigned_roles
              WHERE user_id = " . $deleteid;
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
          ':name' => $name,
          ':email_id' => $email_id,
          ':mobile_no' => $mobile_no,
          ':signup_method' => $signup_method,
          ':role_preference' => $role_preference,
          ':assigned_roles' => json_encode(array('roles' => $assigned_roles))
        ));
        // var_dump($stmt->debugDumpParams());
      } else {
        $sql = "UPDATE user_master
              SET 
              name = :name,
              email_id = :email_id,
              mobile_no = :mobile_no,
              signup_method = :signup_method,
              role_preference = :role_preference
              WHERE user_id = " . $deleteid;
        $stmt = $pdo->prepare($sql);
        $stmt->execute(array(
          ':name' => $name,
          ':email_id' => $email_id,
          ':mobile_no' => $mobile_no,
          ':signup_method' => $signup_method,
          ':role_preference' => $role_preference
        ));
      }
    }
    $_SESSION['message'] = "Changes are saved successfully!";
    $_SESSION['status'] = "success";
    $_SESSION['title'] = "Success!";
    header('Location: user_master.php');
    exit();
    die();
  } else {
    $_SESSION['message'] = 'No users are chosen to make changes!';
    $_SESSION['status'] = "warning";
    $_SESSION['title'] = "Warning!";
    header('Location: user_master.php');
    return;
  }
}

//IF THE ADD user BUTTON IS CLICKED
if (isset($_POST['add_user'])) {
  $assigned_roles = '{"roles":[1]}';
  $role_preference = '1';
  $date = date("yy-m-d");
  $password = hash('sha256', $_POST["password"]);
  $sql = "INSERT INTO user_master
             (`name`,email_id,mobile_no,password,role_preference,assigned_roles,signup_method,effective_from_dt)
             VALUES
             (:name,:email_id,:mobile_no,:password,:role_preference,:assigned_roles,:signup_method,:effective_from_dt)";
  $stmt = $pdo->prepare($sql);
  $stmt->execute(array(
    ':name' => $_POST['name'],
    ':email_id' => $_POST['email_id'],
    ':mobile_no' => $_POST['mobile_no'],
    ':password' => $password,
    ':role_preference' => $role_preference,
    ':assigned_roles' => $assigned_roles,
    ':signup_method' => $_POST['signup_method'],
    ':effective_from_dt' => $date
  ));

  $_SESSION['message'] = 'User Added Successfully!';
  $_SESSION['status'] = "success";
  $_SESSION['title'] = "Success!";
  header('Location: user_master.php');
  return;
}

?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Primary Meta Tags -->
  <title>Manage Users</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">

  <!-- Sweet Alert -->
  <link type="text/css" href="../vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- Notyf -->
  <link type="text/css" href="../vendor/notyf/notyf.min.css" rel="stylesheet">

  <!-- Volt CSS -->
  <link type="text/css" href="../css/volt.css" rel="stylesheet">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!--LINK TO CUSTOM JAVASCRIPT FUNCTIONS-->
  <script src="sa_javascript.js"></script>
  <!--AUTOCOMPLETE JQUERY LINK-->
  <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>

  <script src="https://kit.fontawesome.com/0dbfcd8819.js" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

</head>


<body onload="loadmore(1,4)">

  <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

  <main class="content">
    <?php
    require_once "sidenav.php";
    require_once "./topnav.php"; ?>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
      <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
          <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
              <a href="#">
                <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
              </a>
            </li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Users</li>
          </ol>
        </nav>
        <h2 class="h4">User Master</h2>
        <p class="mb-0">Manage all of the users here</p>
      </div>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group ms-2 ms-lg-3">
          <!-- <form method="post" action="user_master.php"> -->
          <button id="user_filter" onclick="loadmore(1,1)" class="btn btn-sm btn-outline-gray-600 ">Users</button>
          <button id="event_manager_filter" onclick="loadmore(1,2)" class="btn btn-sm btn-outline-gray-600 ">Event Managers</button>
          <button id="admin_filter" onclick="loadmore(1,3)" class="btn btn-sm btn-outline-gray-600 ">Admins</button>
          <button id="all_filter" onclick="loadmore(1,4)" class="btn btn-sm btn-outline-gray-600  ">All</button>
          <!-- </form> -->
        </div>
      </div>
    </div>
    <span class="fw-normal"></span>
    <div class="table-settings mb-4">
      <div class="row align-items-center justify-content-between">
        <div class="col col-md-6 col-lg-3 col-xl-4">
          <div class="input-group me-2 me-lg-3 fmxw-400">
            <span class="input-group-text">
              <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
              </svg>
            </span>
            <input type="text" id="myInput" class="form-control" placeholder="Search users">

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-default">Add New User</button>

          </div>

        </div>
        <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
          <div class="dropdown">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
              </svg>
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end pb-0">
              <span class="small ps-3 fw-bold text-dark">Show</span>
              <a class="dropdown-item d-flex align-items-center fw-bold" href="#">10 <svg class="icon icon-xxs ms-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg></a>
              <a class="dropdown-item fw-bold" href="#">20</a>
              <a class="dropdown-item fw-bold rounded-bottom" href="#">30</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add new user form -->
    <form method="post" action="user_master.php" enctype="multipart/form-data">
      <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="h6 modal-title">Add New User</h2>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <!-- <div class="mb-3">
          <label class="my-1 me-2" for="roles">Role Preference</label>
            <select class="form-select" name="role_preference" id="roles" aria-label="Default select example">
                <option value="1">User</option>
                <option value="2">Event Manager</option>
                <option value="3">Admin</option>
            </select>
          </div> -->

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Name</label>
                <input type="text" required class="form-control" name="name" id="exampleFormControlInput1" placeholder="Name">
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Email ID</label>
                <input type="text" required class="form-control" name="email_id" id="exampleFormControlInput1" placeholder="Email ID">
              </div>
              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Mobile Number</label>
                <input type="text" required class="form-control" name="mobile_no" id="exampleFormControlInput1" placeholder="Mobile Number">
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Password</label>
                <input type="password" required class="form-control" name="password" id="exampleFormControlInput1" placeholder="Password">
              </div>

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Sign Up Method</label>
                <select class="form-select" name="signup_method" aria-label="Default select example">
                  <option value="email">Email</option>
                  <option value="facebook">Facebook</option>
                  <option value="github">GitHub</option>
                  <option value="google">Google</option>
                </select>
              </div>

            </div>
            <div class="modal-footer">

              <button type="submit" class="btn btn-success" name="add_user">Add User</button>
              <!-- <button type="button" class="btn btn-danger">Reject</button> -->
              <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <form method="post" action="user_master.php" enctype="multipart/form-data">
      <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col" class="text-center"><i class="fa fa-check" aria-hidden="true"></i></th>
              <th class="border-gray-200">Role Preference</th>
              <th class="border-gray-200">Name</th>
              <th class="border-gray-200">Email ID</th>
              <th class="border-gray-200">Mobile Number</th>
              <th class="border-gray-200">SignUp Method</th>
              <!-- <th class="border-gray-200">Effective From Date</th>
            <th class="border-gray-200">Effective End Date</th> -->
            </tr>
          </thead>
          <tbody id="myTable" style="height: calc(300px + 5vh);">
            <!-- Item -->

            <!-- Item -->

          </tbody>
        </table>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
          <div id="paging"></div>
          <button type="submit" class="btn btn-success mb-1" name="edit">Make Changes To Selected Records</button>
          <button type="submit" onclick="confirmDelete()" class="btn btn-danger mb-1" name="set_inactive">Make Selected Records Inactive</button>
          <a id="inactive_records_selection" onclick="loadmore(1,5)" class="btn btn-warning mb-1"><i class="fa fa-eye" aria-hidden="true"></i> Show inactive records</a>
          <!-- <div class="fw-normal small mt-4 mt-lg-0">Showing <b>5</b> out of <b>25</b> entries</div> -->
        </div>
      </div>
    </form>
    <?php require_once "./footer.php"; ?>
  </main>

  <script id = "cnt"></script>
  <script>
    function getmore(limit) {
      // console.log(limit);
      localStorage.setItem('lim',limit);
      $.ajax({
        url: "user_master_func.php",
        type: "GET",
        data: {
          limit: limit,
        },
        success: function(data) {
          $('#myTable').html(data);

        }
      });
      $("#cnt").html("for (let i = 1; i <= parseInt(<?= $_SESSION['final_count'] ?>); i++) {if (i == " + localStorage.getItem('lim') + ") {$('#count' + i).addClass('active');} else {$('#count' + i).removeClass('active');}}")
      setTimeout($("#cnt").html(),100);
      // $.ajax({
      //   url: "pagination_count.php",
      //   type: "GET",
      //   data: {
      //     limit: limit,              
      //   },
      //   // dataType : 'JSON',
      //   success: function(data){
      //     $('#paging').html(data);
      //   }
      // })
    }

    function loadmore(limit, filt) {
     
      if (filt == 1) {
        $('#user_filter').addClass('active');
        $('#event_manager_filter').removeClass('active');
        $('#admin_filter').removeClass('active');
        $('#all_filter').removeClass('active');

      } else if (filt == 2) {
        $('#user_filter').removeClass('active');
        $('#event_manager_filter').addClass('active');
        $('#admin_filter').removeClass('active');
        $('#all_filter').removeClass('active');
      } else if (filt == 3) {
        $('#user_filter').removeClass('active');
        $('#event_manager_filter').removeClass('active');
        $('#admin_filter').addClass('active');
        $('#all_filter').removeClass('active');
      } else if (filt == 4) {
        $('#user_filter').removeClass('active');
        $('#event_manager_filter').removeClass('active');
        $('#admin_filter').removeClass('active');
        $('#all_filter').addClass('active');
      }

      // $('#two').removeClass('active');
      // $('#three').removeClass('active');

      // console.log(filt);
      

      $.ajax({
        url: "pagination_count.php",
        type: "GET",
        data: {
          limit: limit,
          filter_pref: filt
        },
        // dataType : 'JSON',
        success: function(data) {
          $('#paging').html(data);
          $('#count1').addClass('active');
          
          
        }
      })

      $.ajax({
        url: "user_master_func.php",
        type: "GET",
        data: {
          limit: limit,
          filter_pref: filt

        },
        // dataType : 'JSON',
        success: function(data) {

          $('#myTable').html(data);
          // document.getElementById('myTable').innerHTML = data;

        }
      })

    }
  </script>
  <script>
    $(document).ready(function() {
      $("#myInput").on("keyup", function() {
        var value = $(this).val().toLowerCase();
        // $("#myTable tr").filter(function() {
        //   $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        // });
        if(value){
          $.ajax({
          url: "user_master_search.php",
          type: "GET",
          data: {
            myInput: value
          },
          success: function(data) {
          $('#myTable').html(data);
          // document.getElementById('myTable').innerHTML = data;
          }
        })
        }
        else{
          $('#all_filter').click();
        }
      });
    });
  </script>
  <!-- Core -->
  <script src="../vendor/@popperjs/core/dist/umd/popper.min.js"></script>
  <script src="../vendor/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- Vendor JS -->
  <script src="../vendor/onscreen/dist/on-screen.umd.min.js"></script>

  <!-- Slider -->
  <script src="../vendor/nouislider/distribute/nouislider.min.js"></script>

  <!-- Smooth scroll -->
  <script src="../vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

  <!-- Charts -->
  <script src="../vendor/chartist/dist/chartist.min.js" type="text/javascript"></script>
  <script src="../vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js" type="text/javascript"></script>

  <!-- Datepicker -->
  <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js" type="text/javascript"></script>

  <!-- Sweet Alerts 2 -->
  <script src="../vendor/sweetalert2/dist/sweetalert2.all.min.js" type="text/javascript"></script>

  <!-- Moment JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" type="text/javascript"></script>

  <!-- Vanilla JS Datepicker -->
  <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js" type="text/javascript"></script>

  <!-- Notyf -->
  <script src="../vendor/notyf/notyf.min.js" type="text/javascript"></script>

  <!-- Simplebar -->
  <script src="../vendor/simplebar/dist/simplebar.min.js" type="text/javascript"></script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js" type="text/javascript"></script>

  <!-- Volt JS -->
  <script src="../assets/js/volt.js" type="text/javascript"></script>

  <script type="text/javascript">
    function confirmDelete() {
      // event.preventDefault();
      // var result = confirm("Are you sure you want to delete this user?");
      // if (result) {
      //   return true;
      // }
      // else{
      //   event.preventDefault();
      //   return false;
      // } 
    }
  </script>

  <?php //display_message();
  ?>
  <script src="javascript.js"></script>

</body>

</html>