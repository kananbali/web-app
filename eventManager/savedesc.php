<?php
session_start();
$fname = $_POST['fname'];
// setcookie('fname', $fname, time() + (86400 * 30), "/");
$a = $_POST['content'];
file_put_contents('./event_desc/'. $fname, json_encode($a));
// echo json_encode($a);
$_SESSION['fname'] = $_POST['fname'];
echo json_encode($_SESSION);
?>
