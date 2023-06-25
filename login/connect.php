<?php
$db_host = 'localhost';
$db_user = 'root';
$db_password = 'root';
$db_db = "eventmanager";


// $db_host = "db4free.net";
// $db_user = 'eventmanager';
// $db_password = 'password';
// $db_db = 'eventmanager';


$mysqli = @new mysqli(
  $db_host,
  $db_user,
  $db_password,
  $db_db
);

if ($mysqli->connect_error) {
  echo 'Errno: ' . $mysqli->connect_errno;
  echo '<br>';
  echo 'Error: ' . $mysqli->connect_error;
  exit();
}

echo 'Success: A proper connection to MySQL was made.';
echo '<br>';
echo 'Host information: ' . $mysqli->host_info;
echo '<br>';
echo 'Protocol version: ' . $mysqli->protocol_version;

// $sql = "SELECT event_id,event_name,event_manager_id,user_master.name,user_master.email_id,event_date,effective_end_date,event_approved
// FROM event_master
// INNER JOIN user_master
// ON event_master.event_manager_id = user_master.user_id
// WHERE effective_end_date is null
// ORDER BY event_date ASC";

// $sql = "SELECT * FROM user_master where password is null";
$event_id = 1;
$user_id = 28;
$sql3 = "SELECT * from event_transaction where event_id = $event_id and user_id=$user_id and in_event = '1' ";
// $res3 = mysqli_query($conn, $sql3);
$result = $mysqli->query($sql3);
$error = $mysqli->error;
// $row = $result->fetch_assoc();
// var_dump($result);
echo($result->num_rows);
$mysqli->close();
