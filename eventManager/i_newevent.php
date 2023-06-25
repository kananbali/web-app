<?php
// opcache_reset();
// session_start();
include('../config.php');

// require_once 'checkaccess.php';

// echo json_encode($_POST);
date_default_timezone_set("Asia/Calcutta");
// echo $_SESSION;
$link = "event_images/" . $_SESSION['file_name'];
// $event_extended_desc = $_COOKIE['fname'];
// unset($_COOKIE['fname']);
// Taking all 5 values from the form data(input)
// $manager_phone = $_POST['manager_phone'];
$event_name = $_POST['event_name'];
$event_mode = $_POST['event_mode'];
$event_date = $_POST['event_date'];
$manager_id = $_POST['manager_id'];
$event_start_time = $_POST['event_start_time'];
$textarea = $_POST['textarea'];
$subscription_status = $_POST['paid_promotion'];
// if($flexSwitchCheckDefault!=1){
// 	$flexSwitchCheckDefault = 0;
// }
$event_category = $_POST['event_category'];
$event_venue = $_POST['event_venue'];
$event_link = $_POST['event_link'];
$event_price = $_POST['event_price'];
$discounted_price = $_POST['discounted_price'];
$discount_price = $_POST['discount_price'];
$discount_type = $_POST['discount_type'];
$event_end_time = $_POST['event_end_time'];
$event_seats = $_POST['event_seats'];
$facebook_link = "";
$instagram_link = "";
$today_date = date("Y/m/d");
$event_extended_desc = $_SESSION['fname'];
$event_cancellation_time = $_POST['event_cancellation_time'];
// unset($_SESSION['fname']);
// $event_approved = 0;

// Performing insert query execution
// here our table name is college
$sql = "INSERT INTO event_master(event_manager_id, event_price, discounted_price,discount_price,discount_type,
						subscription_status, event_name, event_description, event_mode, event_venue, 
						event_link, event_image_url, category_id, event_date, event_start_time, event_end_time, 
						total_seats, filled_seats, instagram_link, facebook_link,
						event_approved, approval_message, created_date, effective_end_date, event_extended_desc,event_cancellation_time)
						VALUES
						('$manager_id', '$event_price', '$discounted_price','$discount_price', '$discount_type', $subscription_status,'$event_name', '$textarea', '$event_mode', '$event_venue',
						'$event_link', '$link', '$event_category', '$event_date', '$event_start_time',
						'$event_end_time', '$event_seats', '0', '$instagram_link', 
						'$facebook_link', NULL, NULL, '$today_date', NULL, '$event_extended_desc','$event_cancellation_time')";
// var_dump($sql);
$ret_arr = array();
// echo $sql;
if($mysqli->query($sql)){
	$ret_arr['status'] = 1;
	echo json_encode($ret_arr);
}
else{
	$ret_arr['status'] = 0;
	echo json_encode($ret_arr);
	// echo $mysqli->error;
	// echo json_encode($_SESSION);
}

?>