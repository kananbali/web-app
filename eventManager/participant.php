<?php
// opcache_reset();
include('../config.php');
require_once 'checkaccess.php';
$event_id = $_GET['event_id'];

$result2 = "SELECT name,email_id,mobile_no,no_of_tickets,payment_status,payment_mode.payment_mode
  FROM order_transaction
  INNER JOIN order_master ON order_transaction.order_id = order_master.order_id
  INNER JOIN payment_mode ON payment_mode.payment_mode_id = order_master.payment_mode
  INNER JOIN user_master ON user_master.user_id = order_master.user_id
  WHERE event_id = $event_id AND (order_transaction.effective_end_dt IS NULL OR refund_status = 0)
  ORDER BY name ASC";
  $participants = mysqli_query($conn, $result2);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Primary Meta Tags -->
  <title>Participants</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">
  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<link rel="stylesheet" href="/resources/demos/style.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
  <!-- Sweet Alert -->
  <link type="text/css" href="../vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- Notyf -->
  <link type="text/css" href="../vendor/notyf/notyf.min.css" rel="stylesheet">

  <!-- Volt CSS -->
  <link type="text/css" href="../css/volt.css" rel="stylesheet">

  <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

</head>
<?php require_once "./sidenav.php"; ?>

<body>

  <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

  <main class="content">
    <?php require_once "./topnav.php"?>
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
            <li class="breadcrumb-item"><a href="#">Manager</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Participants</li>
          </ol>
        </nav>
        <h2 class="h4">All Participants</h2>
        <p class="mb-0">Manage all of the participants here</p>
      </div>
      <!-- <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group ms-2 ms-lg-3">
          <?php ?>
          <button type="button" class="btn btn-sm btn-outline-gray-600">Event 1</button>
          <button type="button" class="btn btn-sm btn-outline-gray-600">Event 2</button>
          <button type="button" class="btn btn-sm btn-outline-gray-600">Event 3</button>
          <button type="button" class="btn btn-sm btn-outline-gray-600">All Events</button>
        </div>
      </div> -->
    </div>
    <div class="table-settings mb-4">
      <div class="row align-items-center justify-content-between">
        <div class="col col-md-6 col-lg-3 col-xl-4">
          <div class="input-group me-2 me-lg-3 fmxw-400">
            <span class="input-group-text">
              <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
              </svg>
            </span>
            <input type="text" id="myInput" class="form-control" placeholder="Search name of the participant">
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-default"> Event Details </button>
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

    <?php
    $result = $mysqli->query(
    "SELECT event_id,event_name,event_manager_id,user_master.name,user_master.email_id, user_master.mobile_no,discounted_price,event_date,effective_end_date,event_approved,event_start_time,event_end_time, event_price, event_venue
    FROM event_master
    INNER JOIN user_master 
    ON event_master.event_manager_id = user_master.user_id
    WHERE event_id = $event_id
    ORDER BY event_date ASC"
    );
    $obj = $result->fetch_object();

    ?>

    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <?php 
            echo '<h2 class="h6 modal-title">'. $obj->name .'</h2>'; 
            ?>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <div class="modal-body">
            <?php 
            echo '<p><b>Event Name: </b>'.$obj->event_name. '</p>'; 
            echo '<p><b>Event Date: </b>'.$obj->event_date.'</p>';
            echo '<p><b>Start Time: </b> '.$obj->event_start_time.'</p>';
            echo '<p><b>End Time: </b>'.$obj->event_end_time.'</p>';
            echo '<p><b>Event Price: </b>'.$obj->event_price.'</p>';
            echo '<p><b>Discounted Price: </b>'.$obj->discounted_price.'</p>';
            echo '<p><b>Event Venue: </b>'.$obj->event_venue.'</p>';
            ?>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="border-gray-200">Name </th>
            <th class="border-gray-200">Email</th>
            <th class="border-gray-200">Phone Number</th>
            <th class="border-gray-200">Ticket Count</th>
            <th class="border-gray-200">Payment Status</th>
            <th class="border-gray-200">Payment Mode</th>
          </tr>
        </thead>
        <tbody id="myTable">
          <!-- Item -->
          <?php
            while($participant = $participants->fetch_object()){ ?>
          <tr>
            
            <td><span class="fw-normal"><?= $participant->name ?></span></td>
            <td><span class="fw-normal"><?= $participant->email_id?></span></td>
            <td><span class="fw-bold"><?= $participant->mobile_no?></span></td>
            <td><span class="fw-bold"><?= $participant->no_of_tickets?></span></td>
            <td><span class="fw-bold"><?= $participant->payment_status == 1? "Paid":"Not Paid" ?></span></td>
            <td><span class="fw-bold"><?= $participant->payment_mode?></span></td>
    
          </tr>
              <?php } ?>
          <!-- Item -->

        </tbody>
      </table>
      <script>
      $(document).ready(function(){
        $("#myInput").on("keyup", function() {
          var value = $(this).val().toLowerCase();
          $("#myTable tr").filter(function() {
            $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
          });
        });
      });
    </script>
      <!-- <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
        <nav aria-label="Page navigation example">
          <ul class="pagination mb-0">
            <li class="page-item">
              <a class="page-link" href="#">Previous</a>
            </li>
            <li class="page-item active">
              <a class="page-link" href="#">1</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">2</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">3</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">4</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">5</a>
            </li>
            <li class="page-item">
              <a class="page-link" href="#">Next</a>
            </li>
          </ul>
        </nav>
        <div class="fw-normal small mt-4 mt-lg-0">Showing <b>5</b> out of <b>5</b> entries</div>
      </div> -->
    </div>  
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