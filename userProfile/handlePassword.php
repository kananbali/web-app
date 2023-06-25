<?php
$retarr = array();
include('../config.php');
$user_id = $_COOKIE['user_id'];

$oldPassword = hash('sha256', $_POST["oldPassword"]);
$newPassword1 = hash('sha256', $_POST["newPassword1"]);

$sql = "SELECT * FROM user_master WHERE user_id = '$user_id'";
$result = mysqli_query($conn, $sql);

$result = $result->fetch_assoc();
$oldhash = $result['password'];

if ($oldhash == $oldPassword) {
   $sql2 = "UPDATE user_master SET password = '$newPassword1' WHERE user_id = '$user_id'";
   $res3 = mysqli_query($conn, $sql2);
   $retarr['success'] = 1;
}
else{
    $retarr['success'] = 0;
}

echo json_encode($retarr);
?>