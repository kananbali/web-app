<?php


require_once('../config.php');

$event_id = $_GET['event_id'];
$registered = $_GET['registered'];
$trans_id = $_GET['transaction_id'];
$user_id = $_COOKIE['user_id'];

// var_dump($_GET);

$sql = "DELETE FROM event_transaction WHERE event_transaction_id = $trans_id";
$res = mysqli_query($conn, $sql);
$sql5 = "UPDATE event_master SET filled_seats = filled_seats - 1 WHERE event_id = $event_id";
$res5 = mysqli_query($conn, $sql5);
// var_dump($sql);
// var_dump($res);
// $sql2 ="SELECT * FROM event_transaction";
$sql2 ="SELECT * FROM event_transaction WHERE in_event = 0 AND event_id = $event_id ORDER by registered_time";

$res2 = mysqli_query($conn, $sql2);

if($res2->num_rows > 0){
    $row  = $res2->fetch_assoc();
    $uuid = $row['user_id'];
    $utid = $row['event_transaction_id'];
    $sql3 = "UPDATE event_transaction SET in_event = 1 WHERE event_transaction_id = $utid";
    $res3 = mysqli_query($conn, $sql3);
    $sql4 = "UPDATE event_master SET filled_seats = filled_seats + 1 WHERE event_id = $event_id";
    $res4 = mysqli_query($conn, $sql4);
}


// var_dump($row);


// header("Location ./event.php?registered=0&eventid=$event_id");
echo "<script>location.href = '../event/index.php?eventid=$event_id'</script>";
?>