<?php 
session_start();
$target_dir = "event_images/";
$target_file = $target_dir . basename($_FILES["image_path"]["name"]);
$file_name = $_FILES["image_path"]['name'];
$file_size =$_FILES["image_path"]['size'];
$file_type=$_FILES["image_path"]['type'];
$file_tmp =$_FILES["image_path"]['tmp_name'];

move_uploaded_file($file_tmp,$target_dir.$file_name);
// die(print_r($_FILES));
$_SESSION['file_name'] = $file_name;
// echo json_encode($_SESSION);
echo $file_name;
?>