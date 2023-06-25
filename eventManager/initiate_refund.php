<?php
  require_once "../config.php";
  require_once "../functions.php";

  if(isset($_GET['order_transaction_id'])){
    $id = $_GET['order_transaction_id'];
  }
  else{
      die('Access Denied');
  }

  $sql = "SELECT * FROM order_transaction WHERE order_transaction_id = $id";
  $res2 = mysqli_query($mysqli, $sql);

  $order = $res2->fetch_assoc();
  $no_of_tickets = $order['no_of_tickets'];
  $event_id = $order['event_id'];

  $date = date("yy-m-d");
  $sql =
  "UPDATE order_transaction 
  SET refund_status = 1
  WHERE order_transaction_id = $id";
  $mysqli->query($sql);

  $sql =
  "UPDATE event_master SET filled_seats = filled_seats - $no_of_tickets WHERE event_id = '$event_id'";
  $mysqli->query($sql);


  header('Location: manage_refund.php');
  return;

?>
