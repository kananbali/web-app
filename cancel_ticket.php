<?php
  require_once "config.php";
  require_once "functions.php";
  date_default_timezone_set("Asia/Calcutta");
  if(!isset($_COOKIE['user_id'])){
    die('Please login');
  }
  else{
    $user_id = $_COOKIE['user_id'];
  }
  if(isset($_GET['event_id']) && isset($_GET['order_id'])){
    $event_id = $_GET['event_id'];
    $order_id = $_GET['order_id'];
  }
  else{
      die('Access Denied');
  }

  $date = date("yy-m-d");
  $sql =
  "UPDATE order_transaction 
  SET effective_end_dt = '$date',refund_status = 0
  WHERE event_id = $event_id AND order_id = $order_id";
  $mysqli->query($sql);


  header('Location: invoice.php?order_id='.$order_id);
  return;

?>
