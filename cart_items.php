<?php
require_once "style.php";
require_once 'navbar.php';

date_default_timezone_set("Asia/Calcutta");

if(!isset($_COOKIE['user_id'])){
  die('Please login to view cart items');
}
else{
  $user_id = $_COOKIE['user_id'];
}
$sql = "SELECT cart.event_id,event_name,no_of_tickets,event_price,discounted_price,event_image_url,event_cancellation_time,event_date,event_start_time
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
  <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous"> -->


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
    <h1 style="color: #012970; font-weight: bold;"><i class="bi bi-cart"></i> Cart Items</h1>
    <br>

    <table class="table mytable" id="myTable">
    <thead>
      <tr>

        <th scope="col" class="text-center">Event Name</th>
        <!-- <th scope="col">Image</th> -->
        <th scope="col" class="text-center">Ticket Price</th>
        <th scope="col" class="text-center col-2">Number of Tickets</th>
       
        <th scope="col" class="text-center">Sub Total</th>
        <th scope="col" class="text-center">Action</th>
      </tr>
    </thead>
    <tbody>
      <?php
      if($count == 0){
        echo '<tr id="no_item_cart"><td colspan="5" class="align-middle text-center">No items added in cart</td></tr>';
      }
      else{
        echo '<tr style="display:none;" id="no_item_cart"><td colspan="5" class="align-middle text-center">No items added in cart</td></tr>';
      }
      $max = -1;
      $grandTotal = 0;
      while ($eventobj = $events->fetch_object()) {
        $p = intval($eventobj->discounted_price);
        $n = intval($eventobj->no_of_tickets);
        $grandTotal += ($p*$n);

        date_default_timezone_set("Asia/Calcutta");
        $combinedDT = date('Y-m-d H:i:s', strtotime("$eventobj->event_date $eventobj->event_start_time"));
        $curDate = date('Y-m-d H:i:s', time());
        $hourdiff = round((strtotime($combinedDT) - strtotime($curDate))/3600, 0);
        if($hourdiff <= 0){
          $hourdiff = 0;
          $button_text = "You cannot cancel this event after booking";
        }
        else{
          $button_text = "You can cancel the event before $hourdiff hours from now";
        }
        ?>
      <tr id="<?=$eventobj->event_id?>">

        <td class="align-middle text-center">
          <a  style="color: #012970; font-weight: bold;" href="/event/index.php?eventid=<?=$eventobj->event_id?>">
          <img src="eventManager/<?=$eventobj->event_image_url?>" width="150" height="100"><br>
<br>
            <?= $eventobj->event_name?>
          </a>

        </td>
        <!-- <td class="align-middle">
          <img src="eventManager/<?=$eventobj->event_image_url?>" width="150" height="100">
        </td> -->
        
        <td class="align-middle text-center">
        ₹ <?=$p?>
          <input type="hidden" value="<?=$eventobj->discounted_price?>" id="event_price<?=$eventobj->event_id?>" value="<?=$eventobj->discounted_price?>">
          <input type="hidden" value="<?=$eventobj->discounted_price?>" id="discounted_price<?=$eventobj->event_id?>" value="<?=$eventobj->discounted_price?>">
        </td>
        <td class="align-middle text-center">
          <div class="d-flex mx-sm-3 mb-2">
            <i style="background: #012970; font-size: 1.5rem;" class="bi bi-dash-square btn btn-primary" onclick="decrement(<?=$eventobj->event_id?>)"></i>
            <input readonly type="text" style="width: 60px;" class="text-center form-control form-control-sm" id="no_of_items<?=$eventobj->event_id?>" name="no_of_items" value="<?=$eventobj->no_of_tickets?>">
            <i style="font-size: 1.5rem; background: #012970;" class="bi bi-plus-square btn btn-primary" onclick="increment(<?=$eventobj->event_id?>)"></i>
          </div>

        </td>
        <td class="align-middle text-center" id="sub_total<?=$eventobj->event_id?>"><?=$p*$n?></td>

        <th scope="row" class="align-middle text-center">
          <a class="text-danger" style="cursor:pointer" onclick="removeFromCart(<?= $user_id?>,<?=$eventobj->event_id?>,0)"><span class="align-middle"></span> Remove </a>
          <br>
          <!-- <a type="button" class="" data-bs-toggle="tooltip" data-bs-placement="top" title="<?= $button_text?>">
            View Policy
      </a> -->
        </th>

      </tr>
      <?php
      if($eventobj->event_id > $max){
        $max = $eventobj->event_id;
      }
    }
    echo "<script>var count = $max</script>";
      ?>
      <?php if($count != 0):?>
      <tr id="total_div">
        <td class="align-middle text-center"><b>Total</b></td>
        <td colspan="2"></td>
        <td id="grandTotal" class="align-middle text-center"><?=$grandTotal?></td>
        <td></td>
      </tr>
      <?php endif;?>

    </tbody>
  </table>
  <button style="background: #012970;" <?php if($count == 0){ echo 'hidden';}?> id="checkout_button" class="btn btn-primary" onclick="window.location.href='checkout.php'"> Proceed To Check Out</button>
  <!-- <a class="btn btn-primary">Check Out</a> -->
  </div>

</div>
<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXl5PILFhosVNubq5LC7Qb9DXgDA9i+tQ8Zj3iwWAwPtgFTxbJ8NT4GN1R8p" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.min.js" integrity="sha384-cVKIPhGWiC2Al4u+LWgxfKTRIcfu0JTxR+EQDz/bgldoEyl4H0zUF0QKbrJ0EcQF" crossorigin="anonymous"></script>
<script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>

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
if(document.getElementById("myTable").rows.length == 0){
  // alert("Hello World");
  document.getElementById('checkout_button').disabled = true;
}
// console.log(count);
function increment(event_id){
  var number = document.getElementById('no_of_items'+event_id).value;
  document.getElementById('no_of_items'+event_id).value = Number(number) + 1;
  addToCart(<?= $user_id?>,event_id,document.getElementById('no_of_items'+event_id).value,document.getElementById('event_price'+event_id).value,document.getElementById('discounted_price'+event_id).value);

  if(document.getElementById("myTable").rows.length == 0){
    document.getElementById('checkout_button').disabled = true;
  }
}
function decrement(event_id){
  var number = document.getElementById('no_of_items'+event_id).value;
  if(number == 0){
    return;
  }
  document.getElementById('no_of_items'+event_id).value = Number(number) - 1;
  addToCart(<?= $user_id?>,event_id,document.getElementById('no_of_items'+event_id).value,document.getElementById('event_price'+event_id).value,document.getElementById('discounted_price'+event_id).value);

  if(document.getElementById("myTable").rows.length == 0){
    document.getElementById('checkout_button').disabled = true;
  }
}
function removeFromCart(user_id,event_id,no_of_items){
  addToCart(user_id,event_id,no_of_items);
  updateCartNav();

  document.getElementById(event_id).remove();

  if(document.getElementById("myTable").rows.length <=3){
    // alert(document.getElementById("myTable").rows.length);
    // document.getElementById('checkout_button').disabled = true;
    document.getElementById('no_item_cart').style.display = "";
    document.getElementById('checkout_button').remove();
    document.getElementById('total_div').remove();
  }
  else{
    addGrandTotal();
    updateCartNav();
  }
}
  function addToCart(user_id,event_id,no_of_items,original_price,discount_price){

        if (user_id == "0") {
            // document.getElementById("txtHint").innerHTML = "";
            Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please login to like this event!',
                        }).then(function() {
                            window.location.href = '../login/login.php?redrurl='+location.href;
                        })
            return;
        } else {
            if (window.XMLHttpRequest) {
                // code for IE7+, Firefox, Chrome, Opera, Safari
                xmlhttp = new XMLHttpRequest();
            } else {
                // code for IE6, IE5
                xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
            }
            xmlhttp.onreadystatechange = function() {
                if (this.readyState == 4 && this.status == 200) {
                    if(this.responseText == "noSeats"){
                      Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Not enough seats left!',
                        })
                      // document.getElementById('no_of_items').value = 0;
                      decrement(event_id);
                      updateCartNav();
                    }
                    else if(this.responseText == "notLoggedIn"){
                      Swal.fire({
                            icon: 'warning',
                            title: 'Oops...',
                            text: 'Please login to add to the cart!',
                        }).then(function() {
                            window.location.href = '../login/login.php?redrurl='+location.href;
                        })
                    }
                    else{
                      document.getElementById("no_of_items"+event_id).value = this.responseText;
                      var price = Number(document.getElementById("event_price"+event_id).value);
                      document.getElementById("sub_total"+event_id).innerHTML = Number(this.responseText)*price;

                      addGrandTotal();
                      updateCartNav();
                    }
                }
            };
            xmlhttp.open("GET", "event/add_to_cart_ajax.php?user_id=" + user_id + "&event_id=" + event_id + "&no_of_items=" + no_of_items + "&original_price=" + original_price + "&discount_price=" + discount_price);
            xmlhttp.send();

        }

  }
  function addGrandTotal(){
    var grandTotal = 0;
    for(i = 1; i<= count; i++){
      if(document.getElementById('sub_total'+i)){
        grandTotal += Number(document.getElementById('sub_total'+i).innerHTML);
      }
    }
    document.getElementById('grandTotal').innerHTML = grandTotal;
  }
  </script>

<?php require_once "footer.php"?>

</body>
</html>
