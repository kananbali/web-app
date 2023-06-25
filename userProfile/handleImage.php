<?php
session_start();
echo ("Im in the form");
include('../config.php');
$user_id = $_COOKIE['user_id'];

$target_dir = "user_images/";
$target_file = $target_dir . basename($_FILES["image_path"]["name"]);
$file_name = $_FILES["image_path"]['name'];

echo (json_encode($_FILES));
if ($_FILES["image_path"]['error'] == 0) {
	if (file_exists($_FILES['image_path']['tmp_name']) || is_uploaded_file($_FILES['image_path']['tmp_name'])) {
		$file_size = $_FILES["image_path"]['size'];
		$file_type = $_FILES["image_path"]['type'];
		$file_tmp = $_FILES["image_path"]['tmp_name'];

		move_uploaded_file($file_tmp, $target_dir . $file_name);


		$link = "user_images/" . $file_name;
		// echo ($user_id);
	} else {
		$link = $_POST['default_link'];
	}
} else {
	$_SESSION['uploaded'] = 0;
	header('Location: index.php');
	exit();
}

$sql = "UPDATE user_master
		SET 
		user_image = '$link'
		WHERE
		user_id = '$user_id'";
// $mysqli->query($sql);
$res3 = mysqli_query($conn, $sql);
$_SESSION['uploaded'] = 1;

header('Location: index.php');
return;

?>