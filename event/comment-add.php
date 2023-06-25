<?php
require_once ("../config.php");
//session_start();
// var_dump($_POST);
$commentId = isset($_POST['comment_id']) ? $_POST['comment_id'] : "";
$comment = isset($_POST['comment']) ? $_POST['comment'] : "";
$commentSenderName = isset($_COOKIE['name']) ? $_COOKIE['name'] : "";
$event_id = $_SESSION['eventid'];
$date = date('Y-m-d H:i:s');


if($_POST['comment_id']!=''){
    $sql = "INSERT INTO tbl_comment(parent_comment_id,comment,comment_sender_name,date,event_id) VALUES ('" . $commentId . "','" . $comment . "','" . $commentSenderName . "','" . $date . "','". $event_id ."')";
}
else{
    $sql = "INSERT INTO tbl_comment(comment,comment_sender_name,date,event_id) VALUES ('$comment','$commentSenderName','$date','$event_id')";

}
// echo "<script>console.log($sql)</script>";
$result = mysqli_query($conn, $sql);

if (! $result) {
    $result = mysqli_error($conn);
}
echo $result;
?>