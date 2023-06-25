<?php
require_once('../config.php');
// echo json_encode($_POST);
// echo '<br>';
// echo json_encode($_SESSION);
$role_id = intval($_POST['pref']);
$sql = "UPDATE 
        user_master
        SET 
        role_preference =  '$role_id'
        WHERE
        user_id = $_SESSION[user_id];
        ";

$ret_arr = array();
if($mysqli->query($sql)) {
   $ret_arr['status'] = 1;
   echo json_encode($ret_arr);
}
else {
    $ret_arr['status'] = 0;
    // echo json_encode($ret_arr);
    // echo $mysqli->error;
    // echo $sql;
}
?>