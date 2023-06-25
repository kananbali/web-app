<?php
// $user_id = $_GET['user_id'];
require_once "config.php";
if(!isset($_COOKIE['user_id'])){
  echo "Login to add to cart";
  return;
}
$nav_user_id = $_COOKIE['user_id'];
//
$sql = "SELECT cart.event_id,event_name,no_of_tickets
         FROM cart
         INNER JOIN event_master ON cart.event_id = event_master.event_id
         WHERE user_id = $nav_user_id AND no_of_tickets > 0";
$events = mysqli_query($mysqli,$sql);

$cartCount  = mysqli_num_rows($events);
?>
<input type="hidden" id="cartCount" value="<?=$cartCount?>">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  <?php while ($eventobj = $events->fetch_object()) {?>
    <li>
      <a href="/event/index.php?eventid=<?=$eventobj->event_id?>">
 <?= $eventobj->event_name?>
 &nbsp;
 <i class="bi bi-ticket-perforated">&nbsp;<?=$eventobj->no_of_tickets?></i>
      </a>
    </li>
  <?php }?>
<b>
  <li><a href="/cart_items.php" style="color: #012970;"><b>View Cart<b></a></li>
</b>
