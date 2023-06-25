<?php 
session_start();
$target_dir = "event_images/";
$target_file = $target_dir . basename($_FILES["image"]["name"]);
$file_name = $_FILES["image"]['name'];
$file_size =$_FILES["image"]['size'];
$file_type=$_FILES["image"]['type'];
$file_tmp =$_FILES["image"]['tmp_name'];

move_uploaded_file($file_tmp,$target_dir.$file_name);
// die(print_r($_FILES));
// $_SESSION['file_name'] = $file_name;
$retarr = array();
$retarr['success'] = 1;
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];   

$retarr['file'] = array('url'=>$url.'/eventManager/event_images/'.$file_name);
echo json_encode($retarr);
?>