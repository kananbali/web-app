<?php

include('../config.php');
require_once '../util.php';

if (isset($_COOKIE['user_id'])) {
  $user_id = $_COOKIE['user_id'];
}

$sql5 = "SELECT 
event_id, event_name,event_description,event_image_url, 
(SELECT COUNT(*)
        FROM event_likes 
        WHERE event_likes.event_id = event_master.event_id) like_count
FROM event_master 
WHERE 
effective_end_date IS NULL AND event_approved = 1
ORDER BY like_count DESC,event_name ASC";
$events = mysqli_query($conn, $sql5);

?>