<?php
require_once "style.php";
require_once 'navbar.php';

if(!isset($_COOKIE['user_id'])){
  die('Plesae login to view cart items');
}
else{
  $user_id = $_COOKIE['user_id'];
}
$sql = "SELECT cart.event_id,event_name,no_of_tickets,event_price,event_image_url,discounted_price
         FROM cart
         INNER JOIN event_master ON cart.event_id = event_master.event_id
         WHERE user_id = $user_id AND no_of_tickets > 0";
$events = mysqli_query($mysqli,$sql);

$count  = mysqli_num_rows($events);
?>
<html>
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <style>
    #all_cart{
      padding: 2%;
    }
    .mytable>tbody>tr>td, .mytable>tbody>tr>th, .mytable>tfoot>tr>td, .mytable>tfoot>tr>th, .mytable>thead>tr>td, .mytable>thead>tr>th {
    padding: 15px;
    }
    .mytable img{
  border: 2px solid black;
}
footer{
      margin-top: 5%;
    }
  </style>
</head>
<body onload="updateCartNav()">
  <div class="container" style="padding-top: 5%;">

  <div id="all_cart">
    <h1 style="font-weight: bold; color: #012970;">Check Out</h1>

    <?php
    if($count == 0){
      echo('<h3>No items added in cart to checkout</h3>');
      die('');
    }
    ?>
   
    <br>
    <table class="table mytable table-hover">
    <thead>
      <tr>

        <th scope="col" class="text-center">Event Name</th>
        <!-- <th scope="col">Image</th> -->
        <th scope="col" class="text-center">Ticket Price</th>
        <th scope="col" class="text-center">Number of Tickets</th>
        
        <th scope="col" class="text-center">Sub Total</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if($count == 0){
        echo '<tr><td colspan="5" class="align-middle text-center">No items added in cart</td></tr>';
        die("");
      }
      $max = -1;
      $grandTotal = 0;
      while ($eventobj = $events->fetch_object()) {
        $p = intval($eventobj->discounted_price);
        $n = intval($eventobj->no_of_tickets);
        $grandTotal += ($p*$n);
        ?>
      <tr id="<?=$eventobj->event_id?>">

        <td class="align-middle text-center">
          <a  style="color: #012970;" href="/event/index.php?eventid=<?=$eventobj->event_id?>">
          <img src="eventManager/<?=$eventobj->event_image_url?>" width="150" height="100"><br>
          <br>
            <b><?= $eventobj->event_name?></b>
          </a>

        </td>

        <td class="align-middle text-center">
        ₹ <?=$p?>
          <input type="hidden" id="event_price<?=$eventobj->event_id?>" value="<?=$eventobj->discounted_price?>">
        </td>

        <td class="align-middle text-center">
          <div class="btn-group mx-sm-3 mb-2">
           
            <input type="hidden" class="text-center form-control form-control-plaintext" id="no_of_items<?=$eventobj->event_id?>" name="no_of_items" value="<?=$eventobj->no_of_tickets?>">
            <?=$eventobj->no_of_tickets?>
            
          </div>

        </td>
        
        <td class="align-middle text-center" id="sub_total<?=$eventobj->event_id?>">₹ <?=$p*$n?></td>

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

        <td class="text-center" id="grandTotal">₹ <?=$grandTotal?></td>
      </tr>

    </tbody>
  </table>
  <div class="input-group" style="width:25vw; float:left">
      <span class="input-group-text">Payment Method</span>
      <select class="form-select" name="payment_mode">
        <option value="1">Cash</option>
      </select>
      
    </div>

    <a class="btn btn-primary" style="background: #012970;float:right; margin-right: 5%" href="order.php">Pay Now</a>

  </div>

</div>
<script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>
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
if(performance.navigation.type == 2){
   location.reload(true);
}
</script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php require_once "footer.php"?>
</body>
</html>
