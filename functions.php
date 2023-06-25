<?php
function getLikeCount($mysqli,$event_id){
    $result = $mysqli->query(
        "SELECT COUNT(*) as like_count
        FROM event_likes
        WHERE event_id = $event_id");
    $obj = $result->fetch_object();
    return $obj->like_count;
}
function getCategoryName($mysqli,$category_id){
    $result = $mysqli->query(
        "SELECT category_name
        FROM category_master
        WHERE category_id = $category_id");
    $obj = $result->fetch_object();
    return $obj->category_name;
}
function getUserImage($mysqli){
    $user_id = $_COOKIE['user_id'];
    $query1 = "SELECT user_image FROM user_master WHERE user_id = $user_id";
    $cats1 = mysqli_query($mysqli, $query1);
    $img_url = $cats1 ->fetch_object();
    return $img_url->user_image;
}
function getRemainingSeats($mysqli,$event_id){
    $result = $mysqli->query(
        "SELECT filled_seats,total_seats
        FROM event_master
        WHERE event_id = $event_id");
    $obj = $result->fetch_object();
    return $obj->total_seats - $obj->filled_seats;
}
