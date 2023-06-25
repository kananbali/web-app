<?php
// opcache_reset();
// session_start();
include('../config.php');

// require_once 'checkaccess.php';

// echo json_encode($_POST);
// $target_dir = "event_images/";
// $target_file = $target_dir . basename($_FILES["image_path"]["name"]);
// $file_name = $_FILES["image_path"]['name'];
// $file_size = $_FILES["image_path"]['size'];
// $file_type = $_FILES["image_path"]['type'];
// $file_tmp = $_FILES["image_path"]['tmp_name'];

// move_uploaded_file($file_tmp, $target_dir . $file_name);
date_default_timezone_set("Asia/Calcutta");

if (isset($_SESSION['file_name'])) {
	$link = "event_images/" . $_SESSION['file_name'];
	unset($_SESSION['file_name']);
} else {
	$link = $_POST['default_link'];
}

$event_extended_desc = $_SESSION['fname'];
unset($_SESSION['fname']);
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
$event_cancellation_time = $_POST['event_cancellation_time'];

// $event_approved = 0;

// Performing insert query execution
// here our table name is college
$sql = "INSERT INTO event_master(event_manager_id, event_price, discounted_price,discount_price,discount_type,
						subscription_status, event_name, event_description, event_mode, event_venue, 
						event_link, event_image_url, category_id, event_date, event_start_time, event_end_time, 
						total_seats, filled_seats, instagram_link, facebook_link,
						event_approved, approval_message, created_date, effective_end_date, event_extended_desc, event_cancellation_time)
						VALUES
						('$manager_id', '$event_price', '$discounted_price','$discount_price', '$discount_type', $subscription_status,'$event_name', '$textarea', '$event_mode', '$event_venue',
						'$event_link', '$link', '$event_category', '$event_date', '$event_start_time',
						'$event_end_time', '$event_seats', '0', '$instagram_link', 
						'$facebook_link', NULL, NULL, '$today_date', NULL, '$event_extended_desc', '$event_cancellation_time')";
// var_dump($sql);
$mysqli->query($sql);
// echo json_encode($mysqli->error);
if ($mysqli->error) {
	echo json_encode(array('status' => 'error', 'message' => $mysqli->error));
} else {
	echo json_encode(array('status' => 'success', 'message' => 'Event Updated Successfully'));
}
?>