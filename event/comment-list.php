<?php
require_once ("../config.php");
// session_start();
if(isset( $_COOKIE['user_id'])){
    $memberId = $_COOKIE['user_id'];
} else {
    $memberId = '0';
}
$event_id = $_SESSION['eventid'];
$sql = "SELECT tbl_comment.*,tbl_like_unlike.like_unlike FROM tbl_comment LEFT JOIN tbl_like_unlike ON tbl_comment.comment_id = tbl_like_unlike.comment_id AND member_id = '$memberId' WHERE event_id = $event_id  ORDER BY parent_comment_id asc, comment_id asc ";
$result = mysqli_query($conn, $sql);
$record_set = array();
while ($row = mysqli_fetch_assoc($result)) {
    array_push($record_set, $row);
}
mysqli_free_result($result);
					
mysqli_close($conn);
echo json_encode($record_set);
?>