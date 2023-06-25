<?php
// $servername = "db4free.net";
// $username = "eventmanager";
// $password = "password";
// $db_name = "eventmanager";

$servername = "localhost";
$username = "root";
$password = "root";
$db_name = "eventmanager";

try {
  $pdo = new PDO("mysql:host=$servername;dbname=$db_name", $username, $password);
  // set the PDO error mode to exception
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
//   echo "Connected successfully";
} catch(PDOException $e) {
  echo "Connection failed: " . $e->getMessage();
}
?>