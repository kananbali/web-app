<?php
// opcache_reset();
include('../config.php');
require_once 'checkaccess.php';
// session_start();

// $all = "active";
$exp = "";

if(isset($_SESSION['message'])){
  $message = $_SESSION['message'];
  echo "<script type='text/javascript'>alert('$message')</script>";
  unset($_SESSION['message']);
}

if (isset($_POST['approved'])) {
  $_SESSION['approved'] = "yes";
  header('Location: event-list.php');
  return;
}
if (isset($_POST['all'])) {
  $_SESSION['all'] = "yes";
  header('Location: event-list.php');
  return;
}
if (isset($_POST['rejected'])) {
  $_SESSION['rejected'] = "yes";
  header('Location: event-list.php');
  return;
}
if (isset($_POST['deleted'])) {
  $_SESSION['deleted'] = "yes";
  header('Location: event-list.php');
  return;
}
if (isset($_POST['pending'])) {
  $_SESSION['pending'] = "yes";
  header('Location: event-list.php');
  return;
}
if (isset($_POST['expired'])) {
  $_SESSION['expired'] = "yes";
  header('Location: event-list.php');
  return;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.3.0/font/bootstrap-icons.css">
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!-- Primary Meta Tags -->
  <title>Events</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="120x120" href="../../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../../assets/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="../../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">

  <!-- Sweet Alert -->
  <link type="text/css" href="../vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- Notyf -->
  <link type="text/css" href="../vendor/notyf/notyf.min.css" rel="stylesheet">

  <!-- Volt CSS -->
  <link type="text/css" href="../css/volt.css" rel="stylesheet">

  <link rel="stylesheet" href="./event-list-card.css">
</head>

<!-- sidenav -->
<?php require_once "./sidenav.php"; ?>

<body>
  <main class="content">

    <!-- topnav -->
    <?php require_once "./topnav.php"; ?>

    
      <!-- <div class="col-12 mb-4">
        <div class="card bg-yellow-100 border-0 shadow">
        </div>
      </div> -->
      <?php

      $user_id = $_COOKIE['user_id'];

      if (isset($_SESSION['approved'])) {
        $rej = "";
        $pen = "";
        $del = "";
        $all = "";
        $app = "active";
        $exp = " ";
        $result = $mysqli->query(
          "SELECT * FROM event_master
          WHERE effective_end_date IS NULL AND event_approved = 1 AND event_manager_id = $user_id AND event_status is NULL
          ORDER BY event_date ASC"
        );
        unset($_SESSION['approved']);
      }
      else if (isset($_SESSION['all'])) {
        $app = "";
        $rej = "";
        $pen = "";
        $del = "";
        $all = "active";
        $exp = " ";
        $result = $mysqli->query(
          "SELECT * FROM event_master
          WHERE event_manager_id = $user_id
          ORDER BY event_date ASC"
        );
        unset($_SESSION['all']);
      }
      else if (isset($_SESSION['rejected'])) {
        $app = "";
        $rej = "active";
        $pen = "";
        $del = "";
        $all = "";
        $exp = " ";
        $result = $mysqli->query(
          "SELECT * FROM event_master
          WHERE effective_end_date IS NULL AND event_approved = 0 AND event_manager_id = $user_id
          ORDER BY event_date ASC"
        );
        unset($_SESSION['rejected']);
      }
      else if (isset($_SESSION['deleted'])) {
        $app = "";
        $rej = "";
        $pen = "";
        $del = "active";
        $all = "";
        $exp = " ";
        $result = $mysqli->query(
          "SELECT * FROM event_master 
          WHERE event_manager_id = $user_id AND event_status = 0
          ORDER BY event_date ASC"
        );
        unset($_SESSION['deleted']);
      }
      else if (isset($_SESSION['pending'])) {
        $app = "";
        $rej = "";
        $pen = "active";
        $del = "";
        $all = "";
        $exp = " ";
        $result = $mysqli->query(
          "SELECT * FROM event_master 
          WHERE effective_end_date IS NULL AND event_approved IS NULL AND event_manager_id = $user_id
          ORDER BY event_date ASC"
        );
        unset($_SESSION['pending']);
      }
      else if (isset($_SESSION['expired'])) {
        $app = "";
        $rej = "";
        $pen = "";
        $del = "";
        $all = "";
        $exp = "active";
        $current_datetime = date('Y-m-d');
        // echo $current_datetime;
        $result = $mysqli->query(
          "SELECT * FROM event_master 
          WHERE event_approved = 1 AND event_manager_id = $user_id AND event_status = 1
          ORDER BY event_date ASC"
        );
        unset($_SESSION['expired']);
      }
      else {
        $app = "";
        $rej = "";
        $pen = "";
        $del = "";
        $all = "active";
        $result = $mysqli->query(
          "SELECT * FROM event_master
          WHERE event_manager_id = $user_id AND effective_end_date IS NULL
          ORDER BY event_date ASC"
        );
      }
?>
<div class="py-4">
    </div>
    <div class="row">
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group ms-2 ms-lg-3">
          <form method="post" action="event-list.php">
            <button type="submit" name="approved" class="btn btn-sm btn-outline-gray-600 <?=$app?> ">Approved</button>
            <button type="submit" name="rejected" class="btn btn-sm btn-outline-gray-600 <?=$rej?>">Rejected</button>
            <button type="submit" name="pending" class="btn btn-sm btn-outline-gray-600 <?=$pen?> ">Pending</button>
            <button type="submit" name="deleted" class="btn btn-sm btn-outline-gray-600 <?=$del?>">Deleted</button>
            <button type="submit" name="expired" class="btn btn-sm btn-outline-gray-600 <?=$exp?>">Expired</button>
            <button type="submit" name="all" class="btn btn-sm btn-outline-gray-600 <?=$all?>">All</button>
          </form>
        </div>
      </div>
    <?php
      // echo '<form action="some_event.php" method="POST">';
      if($result->num_rows > 0){
      while ($obj = $result->fetch_object()) {
        $i = 0;
        echo "<div class='col-xs-12 col-sm-6 col-md-6 col-xl-4 pt-0' style='padding: 3%'>
        <div class='roundcard'>
            <img class='roundimage' src='$obj->event_image_url'>
            <div class=''>
            <h5 class='cardtitle  mt-3 wrapping mb-0'>$obj->event_name</h5>
            <p class='cardsubtitle mb-0'> &#8377;$obj->event_price | $obj->event_venue</p>
            <p class='cardsubsubtitle mb-0'>" .date_format(date_create($obj->event_date), 'M d') . "  ". date_format(date_create($obj->event_start_time), 'H:i') ." to ". date_format(date_create($obj->event_end_time), 'H:i')."</p>";
          echo "<p class='cardsubsubtitle mb-0'>Filled Seats: ";
          echo "$obj->filled_seats</p>"; 
          ?>
          <i class="bi bi-heart-fill" style="float: right; top:0; color: red; margin-right:5px;">
                        <sub style="font-size: small;color: black;"><?= getLikeCount($mysqli, $obj->event_id) ?></sub>
                    </i>
          <?php
          echo "<p class='cardsubsubtitle wrapping'>Reason: ";
            if ($obj->approval_message != NULL) {
          echo "$obj->approval_message";
        }
        else{
          echo "-";
        }
        echo "</p><div class='mb-3 d-flex'>";
        if($obj->event_status == NULL && $obj->effective_end_date == NULL){ //Event is still going on
          echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='edit_event.php?event_id=$obj->event_id'><button class='btn btn-primary ml-2 px-2' value='$obj->event_id' name='event_id'>Edit</button></a> &nbsp;";
          echo "<a href='delete_event.php?event_id=$obj->event_id'><button class='btn btn-danger px-2' value='$obj->event_id' name='event_id'>Delete</button></a> &nbsp;";
          if($obj->event_approved == 1){
            echo "<a href='end_event.php?event_id=$obj->event_id'><button class='btn btn-warning px-2' value='$obj->event_id' name='event_id'>End</button></a> &nbsp;";
          }
        }
        else if ($obj->effective_end_date != NULL || $obj->event_status != NULL ) { //Event is Done/Deleted
          echo "&nbsp;&nbsp;&nbsp;&nbsp;<a href='clone_event.php?event_id=$obj->event_id'><button class='btn btn-success px-2' value='$obj->event_id' name='event_id'>Clone</button></a> &nbsp;";
        } 
        if($obj->event_approved == 1){
          echo "<a href='participant.php?event_id=$obj->event_id'><button class='btn btn-primary px-2' value='$obj->event_id' name='event_id'>Participants</button></a>";
        }
        echo "
        </div>
          </div>
        </div>
    </div>";
        $i = $i + 1;
      }
    } else{
      echo "<p class='m-3 p-3'>No Events Found</p>";
    }
      ?>

    </div>

    <!-- footer -->
    <footer class="bg-white rounded shadow p-5 mb-4 mt-4">
  <div class="row">
    <div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
      <p class="mb-0 text-center text-lg-start">© <span class="current-year"></span> <a class="text-primary fw-normal" href="../" target="_blank">Finserv EVENTS</a></p>
    </div>
    <div class="col-12 col-md-8 col-xl-6 text-center text-lg-start">
      <!-- List -->
      <ul class="list-inline list-group-flush list-group-borderless text-md-end mb-0">
        <li class="list-inline-item px-0 px-sm-2">
          <a href="../">Home</a>
        </li>
        <li class="list-inline-item px-0 px-sm-2">
          <a href="../index.php#contact">Contact</a>
        </li>
        <li class="list-inline-item px-0 px-sm-2">
          <a href="../index.php#categories">Categories</a>
        </li>
        <li class="list-inline-item px-0 px-sm-2">
          <a href="../userProfile/">Profile</a>
        </li>
      </ul>
    </div>
  </div>
</footer>

  </main>

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

</body>

</html>