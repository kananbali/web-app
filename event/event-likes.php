<?php
// echo "<script>console.log(" . $_POST . ")</script>"

use function Safe\mysql_query;

require_once "../config.php";
$user_id = $_POST['user_id'];
$event_id = $_POST['event_id'];
$res1 = mysqli_query($conn, "SELECT * FROM event_likes WHERE event_id = $event_id");
$likecnt = $res1->num_rows;
$retarr = array();
if ($user_id == 0) {
    return;
} else {
    $a = $mysqli->query("SELECT * FROM event_likes WHERE user_id=$user_id AND event_id=$event_id");
    if ($a->num_rows > 0) {
        $mysqli->query("DELETE FROM event_likes WHERE user_id=$user_id AND event_id=$event_id");
        $likecnt--;
        $retarr['likecnt'] = $likecnt;
        $retarr['is_liked'] = 0;
    } else {
        $mysqli->query("INSERT INTO event_likes(user_id, event_id) VALUES($user_id, $event_id)");
        $likecnt += 1;
        $retarr['likecnt'] = $likecnt;
        $retarr['is_liked'] = 1;
    }
}

echo json_encode($retarr);
