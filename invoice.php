<?php
require_once "style.php";
require_once 'navbar.php';

date_default_timezone_set("Asia/Calcutta");

if(!isset($_GET['order_id'])){
  die('No order id found');
}
else{
  $order_id = $_GET['order_id'];
}
if(!isset($_COOKIE['user_id'])){
  die('Plesae login to view cart items');
}
else{
  $user_id = $_COOKIE['user_id'];
}
$sql2 = "SELECT order_id,order_time,payment_status,payment_mode.payment_mode,name,mobile_no,email_id
          FROM order_master
          INNER JOIN user_master ON user_master.user_id = order_master.user_id
          INNER JOIN payment_mode ON payment_mode.payment_mode_id = order_master.payment_mode
         WHERE order_master.order_id = $order_id";
$res = mysqli_query($mysqli,$sql2);
$order = $res->fetch_assoc();

$dt = new DateTime($order['order_time']);

            $date = $dt->format('M d Y');
            $time = $dt->format('H:i A');


$sql = "SELECT user_id,event_name,no_of_tickets,event_price,event_image_url,order_transaction.order_id,event_master.event_id,original_price,purchased_price,event_cancellation_time,event_date,event_start_time,effective_end_dt,refund_status
FROM order_transaction
INNER JOIN order_master ON order_master.order_id = order_transaction.order_id
INNER JOIN payment_mode ON payment_mode.payment_mode_id = order_master.payment_mode
INNER JOIN event_master ON order_transaction.event_id = event_master.event_id
WHERE order_transaction.order_id = $order_id
ORDER BY event_name";
$events = mysqli_query($mysqli,$sql);
?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width">
  <style>
    #all_cart{
      padding: 4%;
      /* min-width: 100%; */

    }
    .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
    padding: 15px;
    }
    footer{
      margin-top: 5%;
    }

    @media(max-width:575px) {
        #all_cart{
        margin-top: 12%;
        /* padding-right: 10%; */
        
      }

    @media print {
      .noPrint{
        display: none;
      }
      #print_button{
        display: none;
      }
      header{
        display: none;
      }
      #all_cart{
        margin-top: 0;
        /* padding-right: 10%; */
        
      }
    }
}
  </style>
</head>
<body onload="updateCartNav()">
  <div class="container-fluid" style="padding-top: 5%;">
  
  <div id="all_cart">
  <div class="d-flex justify-content-between">

    <div class="p-2 col-6">
    <h2 style="padding-bottom: 5px; color: #012970; font-weight: bold;">Your Order Details
    </h2>
      <h6>Order ID: <b><?=$order['order_id']?></b> </h6>
      <h6><i class="bi bi-calendar"></i> <?= $date?> <i class="bi bi-dot"></i> <i class="bi bi-alarm"></i> <?=$time?></h6>
    </div>
    
    <div class="p-2 col-6">
    <h2 style="padding-bottom: 5px; color: #012970; font-weight: bold;">Invoice To
    </h2>
      <h6><?=$order['name']?></h6>
      <h6><?=$order['email_id']?></h6>
    </div>

  </div>

    <br>
    <table class="table mytable table-hover">
    <thead>
      <tr>

        <th scope="col" class="text-center">Event Name</th>
        <!-- <th scope="col">Image</th> -->
        <th scope="col" class="text-center">No Of Tickets</th>
        <th scope="col" class="text-center">Ticket Price</th>
        <th scope="col" class="text-center">Sub Total</th>
        <th scope="col" class="text-center noPrint">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      $max = -1;
      $grandTotal = 0;
      while ($eventobj = $events->fetch_object()) {
        $p = intval($eventobj->event_price);
        $n = intval($eventobj->no_of_tickets);

        if($eventobj->refund_status != 1){
          $grandTotal += ($p*$n);
        }
        

        date_default_timezone_set("Asia/Calcutta");
//         $timezone = date_default_timezone_get();
// echo "The current server timezone is: " . $timezone;

        $combinedDT = date('Y-m-d H:i:s', strtotime("$eventobj->event_date $eventobj->event_start_time"));
        $curDate = date('Y-m-d H:i:s', time());
        $hourdiff = round((strtotime($combinedDT) - strtotime($curDate))/3600, 1);

        $color = "light";
        $class = "";
        if($hourdiff <= 0){
          $hourdiff = 0;
          $status = "disabled";
        }
        else{
          $status="";
        }
        if($eventobj->refund_status == NULL){
          $button_text = "Cancel Tickets";
        }
        else if($eventobj->refund_status == 0){
          $button_text = "Refund In Progress";
          $status = "disabled";
        }
        else{
          $button_text = "Refunded";
          $status = "disabled";
          $class = "noPrint";
          // $color = "secondary";
        }
        ?>
      <tr id="<?=$eventobj->event_id?>" class="<?=$class?>">

        <td class="align-middle text-center">
          <a style="color: #012970; font-weight: bold;" href="/event/index.php?eventid=<?=$eventobj->event_id?>">
          <img src="eventManager/<?=$eventobj->event_image_url?>" width="150" height="100"><br>
          <br>
            <?= $eventobj->event_name?>
          </a>

        </td>
        <!-- <td class="align-middle">
          <img src="eventManager/<?=$eventobj->event_image_url?>" width="150" height="100">
        </td> -->
        <td class="align-middle text-center">
          <div class="btn-group mx-sm-3 mb-2">
            <!-- <i style="font-size: 1.5rem;" class="bi bi-dash-square btn btn-primary" onclick="decrement(<?=$eventobj->event_id?>)"></i> -->
            <input type="hidden" class="text-center form-control form-control-plaintext" id="no_of_items<?=$eventobj->event_id?>" name="no_of_items" value="<?=$eventobj->no_of_tickets?>">
            <?=$eventobj->no_of_tickets?>
            <!-- <i style="font-size: 1.5rem;" class="bi bi-plus-square btn btn-primary" onclick="increment(<?=$eventobj->event_id?>)"></i> -->
          </div>

        </td>
        <td class="align-middle text-center">
        ₹ <?=$p?>
          <input type="hidden" id="event_price<?=$eventobj->event_id?>" value="<?=$eventobj->discounted_price?>">
        </td>
        <td class="align-middle text-center" id="sub_total<?=$eventobj->event_id?>">₹ <?= $button_text == "Refunded"? "0":$p*$n?></td>

        <td class="align-middle text-center noPrint">
        <span class="d-inline-block" tabindex="0" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $hourdiff == 0? "You cannot cancel this booking" : 'You can cancel this booking until '.$hourdiff.' hours from now'?>">
        <button type="button" onclick="window.location.href='cancel_ticket.php?order_id=<?=$order['order_id']?>&event_id=<?=$eventobj->event_id?>'" <?=$status?> class="btn btn-danger m-1">
        <?=$button_text?>
          </button>
          </span>
        </td>
      </tr>
      <?php
      if($eventobj->event_id > $max){
        $max = $eventobj->event_id;
      }
    }
    echo "<script>var count = $max</script>";
      ?>
      <tr>
        <td colspan="1" class="text-center"><b>Total</b></td>
        <td colspan="2"></td>

        <td class="text-center" id="grandTotal"><b>₹ <?=$grandTotal?></b></td>
        <td></td>
      </tr>

    </tbody>
  </table>
  <!-- <a class="btn btn-primary">Check Out</a> -->
  </div>

  <div class="row">
  <div style="padding-left: 5%;" class="col-10"> 
      <h5 class="card-title"></h5>
      <h5 class="card-text">Payment Status: 
        <?php 
          if($order['payment_status'] == 1){ echo '<span class="text-success">Paid using '.$order['payment_mode'].'</span>';}
        ?></h5>
      </div>
      <div class="col-2">
        <button style="background:#012970;" id="print_button" class="btn btn-primary" onclick="window.print()"><i class="bi bi-printer"></i> Print Invoice</button>
      </div>
  </div>
</div>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>

<!-- <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script> -->
    <!-- Vendor JS Files -->
    <script src="assets/vendor/purecounter/purecounter.js"></script>
    <script src="assets/vendor/aos/aos.js"></script>
    <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="assets/js/main.js"></script>

<script>
var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
var tooltipList = tooltipTriggerList.map(function (tooltipTriggerEl) {
  return new bootstrap.Tooltip(tooltipTriggerEl)
})

if(performance.navigation.type == 2){
   location.reload(true);
}
dt1 = new Date("October 13, 2014 08:11:00");
dt2 = new Date("October 13, 2014 11:13:00");
// console.log(diff_hours(dt1, dt2));
function diff_hours(dt2, dt1) 
 {

  var diff =(dt2.getTime() - dt1.getTime()) / 1000;
  diff /= (60 * 60);
  return Math.abs(Math.round(diff));
  
 }
</script>

</body>
<?php //require_once "footer.php"?>
</html>
