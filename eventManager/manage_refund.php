<?php
  session_start();

  require_once "../admin/pdo.php";
  require_once 'checkaccess.php';
  // display_message();
  
  $user_id = $_COOKIE['user_id'];
  // opcache_reset();

  if(isset($_POST['pending_filter'])){
    $_SESSION['pending_events'] = "yes";
    header('Location: manage_refund.php');
    return;
  }
  if(isset($_POST['all_filter'])){
    $_SESSION['all_events'] = "yes";
    header('Location: manage_refund.php');
    return;
  }
  if(isset($_POST['refunded_filter'])){
    $_SESSION['refunded_events'] = "yes";
    header('Location: manage_refund.php');
    return;
  }
  // SELECT COMMAND
  if(isset($_SESSION['all_events'])){
    $allevt = "active";
    $refevt = "";
    $pendevt = "";
    $stmt = $pdo->query(
      "SELECT order_master.user_id,refund_status,order_transaction.event_id,order_transaction_id,event_master.event_name,name,email_id,mobile_no,purchased_price
      FROM order_transaction
      INNER JOIN event_master ON event_master.event_id = order_transaction.event_id
      INNER JOIN order_master ON order_transaction.order_id = order_master.order_id
      INNER JOIN user_master ON user_master.user_id = order_master.user_id
      WHERE (refund_status = 1 OR refund_status = 0) AND event_master.event_manager_id = ".$user_id);
  $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
  unset($_SESSION['all_events']);
  }
  else if(isset($_SESSION['refunded_events'])){
    $allevt = "";
    $refevt = "active";
    $pendevt = "";
    $stmt = $pdo->query(
      "SELECT order_master.user_id,refund_status,order_transaction.event_id,order_transaction_id,event_master.event_name,name,email_id,mobile_no,purchased_price
      FROM order_transaction
      INNER JOIN event_master ON event_master.event_id = order_transaction.event_id
      INNER JOIN order_master ON order_transaction.order_id = order_master.order_id
      INNER JOIN user_master ON user_master.user_id = order_master.user_id
      WHERE refund_status = 1 AND event_master.event_manager_id = ".$user_id);
  $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
  unset($_SESSION['refunded_events']);
  }
  //show the pending events by default
  else{
    $allevt = "";
    $refevt = "";
    $pendevt = "active";
    $stmt = $pdo->query(
      "SELECT order_master.user_id,refund_status,order_transaction.event_id,order_transaction_id,event_master.event_name,name,email_id,mobile_no,purchased_price
      FROM order_transaction
      INNER JOIN event_master ON event_master.event_id = order_transaction.event_id
      INNER JOIN order_master ON order_transaction.order_id = order_master.order_id
      INNER JOIN user_master ON user_master.user_id = order_master.user_id
      WHERE refund_status = 0 AND event_master.event_manager_id = ".$user_id);
  $events = $stmt->fetchAll(PDO::FETCH_ASSOC);
  unset($_SESSION['pending_events']);
  }

  if(isset($_POST['approve_event'])){
    $sql = "UPDATE event_master
              SET 
              event_approved = :event_approved,
              approval_message = :approval_message
              WHERE event_id = :event_id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':event_approved' => true,
        ':approval_message' =>$_POST['approval_message'],
        ':event_id' =>$_POST['event_id'] ));
        $_SESSION['message']='Event is approved';
        header('Location: manage_refund.php');
        return;
  }
  if(isset($_POST['reject_event'])){
    $sql = "UPDATE event_master
              SET 
              event_approved = :event_approved,
              approval_message = :approval_message
              WHERE event_id = :event_id";
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':event_approved' => 0,
        ':approval_message' =>$_POST['approval_message'],
        ':event_id' =>$_POST['event_id'] ));
        $_SESSION['message']='Event is rejected';
        header('Location: manage_refund.php');
        return;
  }


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Primary Meta Tags -->
  <title>Manage Event Request</title>
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

  <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->
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
            <!-- <li class="breadcrumb-item"><a href="#"></a></li> -->
            <li class="breadcrumb-item active" aria-current="page">Manage Requests</li>
          </ol>
        </nav>
        <h2 class="h4">All Refund Requests</h2>
        <p class="mb-0">Manage all of the refund requests here</p>
      </div>
      <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group ms-2 ms-lg-3">
          <form method="post" action="manage_refund.php">
          <button type="submit" name="pending_filter" class="btn btn-sm btn-outline-gray-600 <?=$pendevt?> ">Pending</button>
          <button type="submit" name="refunded_filter" class="btn btn-sm btn-outline-gray-600 <?=$refevt?> ">Refunded</button>
          <button type="submit" name="all_filter" class="btn btn-sm btn-outline-gray-600 <?=$allevt?>">All</button>
          </form>
        </div>
      </div>
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
            <input type="text" id="myInput" class="form-control" placeholder="Search here">

          </div>

        </div>
        <!-- <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
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
        </div> -->
      </div>
    </div>


    <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
      <div class="modal-dialog modal-dialog-centered" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h2 class="h6 modal-title">Event Details</h2>
            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          </div>
          <form method="post" action="requests.php">
          <div class="modal-body" id="modal_body">
            <!-- AJAX info goes here -->
          </div>
          
          <div class="modal-footer">
            <button type="submit" onclick="confirm('Are you sure you want to approve this event?')" class="btn btn-success" name="approve_event">Approve</button>
            <button type="submit" onclick="confirm('Are you sure you want to reject this event?')" class="btn btn-danger" name="reject_event">Reject</button>
            
            </form>
            <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div>
    <div class="card card-body border-0 shadow table-wrapper table-responsive">
      <table class="table table-hover">
        <thead>
          <tr>
            <th class="border-gray-200">Action</th>
            <th class="border-gray-200">Event</th>
            <th class="border-gray-200">Refund Amt</th>
            <th class="border-gray-200">Name </th>
            <th class="border-gray-200">Email</th>
            <th class="border-gray-200">Mobile No</th>
            
            <th class="border-gray-200">Status</th>
          </tr>
        </thead>
        <tbody id="myTable">
          <!-- Item -->

          <?php foreach($events as $event):?>
            <?php
                if($event['refund_status'] == 0){
                  $status = "Pending";
                  $color = "info";
                  $action = "";
                }
                else if($event['refund_status'] == 1){
                  $action = "disabled";
                  $status = "Refunded";
                  $color = "success";
                }
              ?>
          <tr>

            <td>
                <button <?=$action?> type="button" onclick="initiateRefund(<?= $event['order_transaction_id']?>)" class="btn btn-block btn-sm btn-info mb-3">Initiate Refund</button>
            </td>
            
            <td>
              <span class="fw-normal"><?= $event['event_name']?></span>
            </td>
            <td><span class="fw-bold">₹ <?= $event['purchased_price']?></span></td>
            <td><span class="fw-normal"><?= $event['name']?></span></td>
            
            <td><span class="fw-normal"><?= $event['email_id']?></span></td>
            <td><span class="fw-bold"><?= $event['mobile_no']?></span></td>
            
          
              <td>
              <p class="fw-bold text-<?=$color?>"><?= $status?></p>
            </td>

          </tr>
          <?php endforeach; ?>
          <!-- Item -->

        </tbody>
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
      </table>
      <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
        
      </div>
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
<?php   require_once "../admin/util.php";?>
<script>
  function getEventDetails(str) {
    // event.preventDefault();
    //hide_div("new_screen_div");
    // document.getElementById('modal-edit').style.display = "block";
    // console.log("hello ajax");
    if (str === "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("modal_body").innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "event_details.php?q=" + str, true);
        xmlhttp.send();
    }
}
</script>
<script src="sweetalert2.all.min.js"></script>
<script>
    function initiateRefund(order_transaction_id_param){
        Swal.fire({
  title: 'Are you sure?',
  text: "Do you want to initiate the refund process?",
  icon: 'warning',
  showCancelButton: true,
  confirmButtonColor: '#3085d6',
  cancelButtonColor: '#d33',
  confirmButtonText: 'Initiate Refund'
}).then((result) => {
  if (result.isConfirmed) {
    window.location.href = "initiate_refund.php?order_transaction_id="+order_transaction_id_param;
    // Swal.fire(
    //   'Deleted!',
    //   'Your file has been deleted.',
    //   'success'
    // )
  }
})   
    }
  function confirm(msg){
  const message = new String("Are you sure you want to "+ msg + "this event?");
  var result = confirm(message);
      if (result) {
        return true;
      }
      else{
        event.preventDefault();
        return false;
      } 
    }
</script>

</body>

</html>