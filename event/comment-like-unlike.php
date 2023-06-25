<?php
require_once ("../config.php");
//session_start();
$memberId = $_COOKIE['user_id'];
if(!isset($_COOKIE['user_id'])){
    die("You are not logged in");
}
$commentId = $_POST['comment_id'];
$likeOrUnlike = 0;
if($_POST['like_unlike'] == 1)
{
$likeOrUnlike = $_POST['like_unlike'];
}

$sql = "SELECT * FROM tbl_like_unlike WHERE comment_id=" . $commentId . " and member_id=" . $memberId;
$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_array($result, MYSQLI_ASSOC);

if (! empty($row)) 
{
    $query = "UPDATE tbl_like_unlike SET like_unlike = " . $likeOrUnlike . " WHERE  comment_id=" . $commentId . " and member_id=" . $memberId;
} else
{
    $query = "INSERT INTO tbl_like_unlike(member_id,comment_id,like_unlike) VALUES ('" . $memberId . "','" . $commentId . "','" . $likeOrUnlike . "')";
}
mysqli_query($conn, $query);

$totalLikes = "No ";
$likeQuery = "SELECT sum(like_unlike) AS likesCount FROM tbl_like_unlike WHERE comment_id=".$commentId;
$resultLikeQuery = mysqli_query($conn,$likeQuery);
$fetchLikes = mysqli_fetch_array($resultLikeQuery,MYSQLI_ASSOC);
if(isset($fetchLikes['likesCount'])) {
    $totalLikes = $fetchLikes['likesCount'];
}

echo $totalLikes;
