<?php

// include("../admin/pdo.php");
require_once "../config.php";
require_once "../functions.php";

$user_id = $_GET['user_id'];
$discount_price = $_GET['discount_price'];
$original_price = $_GET['original_price'];

if($user_id == 0){
    return "notLoggedIn";
}
$event_id = $_GET['event_id'];
$no_of_items = $_GET['no_of_items'];

$remaining_seats = getRemainingSeats($mysqli,$event_id);

if($no_of_items > $remaining_seats){
  echo "noSeats";
  return;
}
else{
  //add entry to cart master
  $date = date("yy-m-d");
  $sql = "SELECT * FROM cart WHERE user_id = $user_id AND event_id = $event_id";
  $result = $mysqli->query($sql);
  $count  = mysqli_num_rows($result);
  if ($count == 0) {
      //insert a new cart entry to cart
      $sql = "INSERT INTO cart (user_id,event_id,no_of_tickets,original_price,discount_price) VALUES ($user_id,$event_id,$no_of_items,$original_price,$discount_price)";
      $result = $mysqli->query($sql);

      echo "$no_of_items";
  }
  else{
    //Update the cart
    $sql =
      "UPDATE cart
      SET
      no_of_tickets = '$no_of_items'
      WHERE
      user_id = '$user_id'
      AND event_id = '$event_id'";
    $mysqli->query($sql);

    echo "$no_of_items";
    // echo($result);
  }
}
?>
