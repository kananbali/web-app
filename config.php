<?php
  session_start();
  $connected_successfully = false; // Flag for successfull connection.
  $database_name = 'eventmanager';        // Name of the database.
  $hostname = 'localhost';         // IP Adddress of server in our case just localhost as the server is hosted on a local machine.
  $username = 'root';              // username for the database user.
  $password = 'root';// password for the user.
  $currency = 'Rs: ';

  // ini_set('display_startup_errors', 1);
  // ini_set('display_errors', 1);
  // error_reporting(-1);
  // mysqli_report(MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT);

  // Connect to the database and bind the connection to a aribale called 'mysqli'.
  $mysqli = new mysqli($hostname, $username, $password, $database_name);

  // Error Handelling.
  if(!$mysqli->connect_error)
  {
    $connected_successfully = true; // Set the connection flag to True.
  }


$db_host = "localhost";
$db_user = 'root';
$db_password = 'root';
$db_name = 'eventmanager';

$conn = mysqli_connect($db_host, $db_user, $db_password, $db_name);

?>