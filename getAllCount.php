<?php
    require_once "config.php";
    $category_id = $_GET['category_id']; 
    $mode = $_GET['mode'];
    if ($mode != 2) {
        //either online or offline
        $sql =
            "SELECT COUNT(*) as count
            FROM event_master
            WHERE
            filled_seats < total_seats AND
            event_approved = 1 AND
            event_status IS NULL AND
            category_id = $category_id AND
            event_mode = $mode AND
            effective_end_date IS NULL";
    } else if ($mode == 2) {
        //both online and offline(all)
        $sql =
            "SELECT COUNT(*) as count
            FROM event_master
            WHERE
            filled_seats < total_seats AND
            event_approved = 1 AND
            event_status IS NULL AND
            category_id = $category_id AND
            effective_end_date IS NULL";
    }
    $result = $mysqli->query($sql);
    $count = $result->fetch_assoc();
    echo($count['count']);
?>