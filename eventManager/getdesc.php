<?php
$a = file_get_contents("../eventManager/event_desc/" . $_GET['fname']);
// echo json_encode($a);
echo $a;
?>