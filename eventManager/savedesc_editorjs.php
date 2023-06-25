<?php
session_start();
$fname = $_POST['fname'];
$a = $_POST['content'];
file_put_contents('./event_desc/'. $fname, json_encode($a));
echo json_encode($_SESSION);

?>