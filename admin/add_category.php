<?php
// session_start();
require_once "pdo.php";
require_once 'checkaccess.php';
    $date = date("yy-m-d");
    $target_dir = "images/";
    $target_file = $target_dir . basename($_FILES["image_path"]["name"]);
    $file_name = $_FILES["image_path"]['name'];
      $file_size =$_FILES["image_path"]['size'];
      $file_type=$_FILES["image_path"]['type'];
      $file_tmp =$_FILES["image_path"]['tmp_name'];

      $file_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $ext = "png";
      $ext2 = "jpg";
      $ext3 = "jpeg";
      if(strcmp($file_ext,$ext) != 0 && strcmp($file_ext,$ext2) != 0 && strcmp($file_ext,$ext3) != 0){
         $_SESSION['message'] = "Extension not allowed, please choose an image file. ";
         $_SESSION['status'] = "warning";
         $_SESSION['title'] = "Warning!";         
         header('Location: category.php');
         return;
      }
      move_uploaded_file($file_tmp,$target_dir.$file_name);


    $link = "images/".$file_name;
    $sql = "INSERT INTO category_master
             (category_name,category_description,category_image,effective_from_dt)
             VALUES
             (:category_name,:category_description,:category_image,:effective_from_dt)";
    $stmt = $pdo->prepare($sql);
    $stmt->execute(array(
      ':category_name' =>$_POST['category_name'],
      ':category_description' =>$_POST['category_description'],
      ':category_image' =>$link,
      ':effective_from_dt' =>$date
      ));

  $_SESSION['message']='Category Added Successfully!';
  $_SESSION['status'] = "success";
  $_SESSION['title'] = "Success!";
  header('Location: category.php');
  return;
?>