<?php

include("config.php");
require_once "functions.php";

$user_id = $_GET['user_id'];

if($user_id == 0){
    return;
}
$event_id = $_GET['event_id'];
$is_liked = $_GET['is_liked'];

if($is_liked == 0){
    //Insert a new row into event likes
    $mysqli->query("INSERT INTO event_likes(user_id, event_id) VALUES($user_id, $event_id)");
}
else{
    //Delete the row
    $mysqli->query("DELETE FROM event_likes WHERE user_id=$user_id AND event_id=$event_id");
}

?>

<?php if($is_liked == 0):?>
    <i class="bi bi-heart-fill" style="float: right; color: red;cursor:pointer;" onclick="like(<?=$user_id?>, <?=$event_id?>, 1);">
        <sub style="font-size: small;color: black;"><?= getLikeCount($mysqli,$event_id)?></sub>
    </i>
<?php endif; ?>

<?php if($is_liked == 1):?>
    <i class="bi bi-heart-fill" style="float: right; color: grey;cursor:pointer;" onclick="like(<?=$user_id?>, <?=$event_id?>, 0);">
        <sub style="font-size: small;color: black;"><?= getLikeCount($mysqli,$event_id)?></sub>
    </i>
<?php endif; ?>