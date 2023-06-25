<?php
// opcache_reset();
include('../config.php');
require_once 'checkaccess.php';
// session_start();

// echo json_encode($_POST);
if (isset($_SESSION['file_name'])) {
	$link = "event_images/" . $_SESSION['file_name'];
	unset($_SESSION['file_name']);
} else {
	$link = $_POST['default_link'];
}

$event_id = $_COOKIE['editevent_id'];
// Taking all 5 values from the form data(input)
// $manager_phone = $_POST['manager_phone'];
$event_name = $_POST['event_name'];
$event_mode = $_POST['event_mode'];
$event_date = $_POST['event_date'];
$manager_id = $_POST['manager_id'];
$event_start_time = $_POST['event_start_time'];

$textarea = $_POST['textarea'];
$flexSwitchCheckDefault = $_POST['paid_promotion'];
// if($flexSwitchCheckDefault!=1){
// 	$flexSwitchCheckDefault = 0;
// }
$event_category = $_POST['event_category'];
$event_venue = $_POST['event_venue'];
$event_link = $_POST['event_link'];
$event_price = $_POST['event_price'];
$discounted_price = $_POST['discounted_price'];
$event_end_time = $_POST['event_end_time'];
$event_seats = $_POST['event_seats'];
$today_date = date("Y/m/d");
$event_approved = 0;
$discount_price = $_POST['discount_price'];
$discount_type = $_POST['discount_type'];
$event_cancellation_time = $_POST['event_cancellation_time'];

// Performing insert query execution
// here our table name is college
$sql = "UPDATE event_master
		SET 
		event_manager_id = '$manager_id',
		event_price = '$event_price',
		discounted_price = '$discounted_price',
		subscription_status = '$flexSwitchCheckDefault',
		event_name = '$event_name',
		event_description = '$textarea',
		event_mode = '$event_mode',
		event_venue = '$event_venue',
		event_link = '$event_link',
		event_image_url = '$link',
		category_id = '$event_category',
		event_date = '$event_date',
		event_start_time = '$event_start_time',
		event_end_time = '$event_end_time',
		total_seats = '$event_seats',
		event_approved = NULL,
		discount_price = '$discount_price',
		discount_type = '$discount_type',
		event_cancellation_time = '$event_cancellation_time'
		WHERE event_id = '$event_id'";

$mysqli->query($sql);
// var_dump($sql);
// $mysqli->query($sql);
// echo("<br>");
// var_dump($_POST);
// echo("<br>");

// var_dump($mysqli->error);
if ($mysqli->error) {
	echo json_encode(array('status' => 'error', 'message' => $mysqli->error));
} else {
	echo json_encode(array('status' => 'success', 'message' => 'Event Updated Successfully'));
}
?>