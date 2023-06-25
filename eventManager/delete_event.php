<?php
// opcache_reset();
// session_start();
include('../config.php');
require_once 'checkaccess.php';
$event_id = $_GET['event_id'];
$today_date = date("yy-m-d");
$sql1 = $mysqli->query("SELECT * FROM event_master where event_id = $event_id");
$sql1 = $sql1->fetch_assoc();
// echo $sql1['filled_seats'];
// sql to delete a record

if($sql1['filled_seats']>0){
    $_SESSION['message'] = "Already Registered Participants, Cant Delete.";
    header('Location: event-list.php');
    return;
}
else{
    // delete = 0 :: expired/end = 1
    $mysqli->query("UPDATE event_master SET effective_end_date = '$today_date', event_status = 0 WHERE event_id = $event_id");
    header('Location: event-list.php');
    return;
}


?>