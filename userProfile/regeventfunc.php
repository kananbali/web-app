<?php
session_start();
include('../admin/pdo.php');

//require_once 'checkaccess.php';
if (isset(($_COOKIE['user_id']))) {
  $user_id = $_COOKIE['user_id'];
}

// var_dump($_SESSION);

$sql =
"SELECT order_transaction.event_id,event_name,no_of_tickets,event_link,event_date,event_start_time,event_end_time,event_image_url,event_description
FROM order_master
INNER JOIN order_transaction ON order_master.order_id = order_transaction.order_id
INNER JOIN event_master ON event_master.event_id = order_transaction.event_id
WHERE user_id = $user_id AND (order_transaction.refund_status IS NULL OR order_transaction.refund_status = 0)";
// $event = mysqli_query($conn, $sql);
$statement = $pdo->query($sql);
$events = $statement->fetchAll(PDO::FETCH_ASSOC);

?>
