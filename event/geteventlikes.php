<?php
require_once "../config.php";
$user_id = $_POST['user_id'];
$event_id = $_POST['event_id'];
// if($user_id == 0){
//     return;
// }
$res1 = mysqli_query($conn, "SELECT * FROM event_likes WHERE event_id = $event_id");
$likecnt = $res1->num_rows;
$res2 = mysqli_query($conn, "SELECT * FROM event_likes WHERE user_id = $user_id AND event_id = $event_id");
$retarr = array();
if($res2->num_rows > 0 ){
    $retarr['is_liked'] = 1;
} else {
    $retarr['is_liked'] = 0;
}

$retarr['likecnt'] = $likecnt;
echo json_encode($retarr);
?>