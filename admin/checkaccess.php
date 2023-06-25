<?php
session_start();
$roles = $_SESSION['roles'];
if(!in_array(3,$roles)){
   header("Location: ../");
}
echo("<div></div>");
?>