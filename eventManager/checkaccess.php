<?php
// session_start();
$roles = $_SESSION['roles'];
// var_dump($roles);
if(!in_array(2,$roles)){
   header("Location: ../");
}
// else
?>