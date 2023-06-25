<?php
require_once "pdo.php";
require_once 'checkaccess.php';
date_default_timezone_set("Asia/Calcutta");
// session_start();

//IF THE SHOW INACTIVE RECORDS BUTTON IS CLICKED
if(isset($_POST['inactive_records_selection'])){
    $_SESSION['inactive_records_selection'] = "yes";
    header('Location: category.php');
    return;
  }

//If make category inactive button is clicked
if(isset($_POST['set_inactive'])){
  if(isset($_POST['delete'])){
    $date = date("yy-m-d");

    foreach($_POST['delete'] as $deleteid){

      $sql = "SELECT COUNT(*) FROM event_master WHERE category_id = $deleteid AND effective_end_date IS NULL";
      $res = $pdo->query($sql);
      $count = $res->fetchColumn();

      if($count > 0){
        $_SESSION['message']='Cannot set category inactive. Category has active events.';
        $_SESSION['status'] = "warning";
        $_SESSION['title'] = "Warning!";
        header('Location: ./category.php');
        return;
      }

      $sql = "UPDATE category_master
              SET effective_end_dt = :effective_end_dt
              WHERE category_id = ".$deleteid;
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':effective_end_dt' =>$date ));
      }
        $_SESSION['message']='Selected Categories Set Inactive.';
        $_SESSION['status'] = "success";
        $_SESSION['title'] = "Success!";
        //$_SESSION['inactive_records_selection'] = "yes";
        header('Location: ./category.php');
        return;
    } else{
      $_SESSION['message']='No Categories are Chosen to Set Inactive.';
      $_SESSION['status'] = "warning";
      $_SESSION['title'] = "Warning!";
      header('Location: ./category.php');
      return;
    }
}

//IF THE MAKE CHANGES BUTTON IS CLICKED
if(isset($_POST['edit'])) {
  if(isset($_POST['delete'])) {
    foreach($_POST['delete'] as $deleteid){
      $category_name = $_POST['category_name'.$deleteid.''];
      $category_description = $_POST['category_description'.$deleteid.''];

      $target_dir = "images/";
      $target_file = $target_dir . basename($_FILES["image_path".$deleteid.'']["name"]);
      $file_name = $_FILES['image_path'.$deleteid.'']['name'];
    
      if(file_exists($_FILES['image_path'.$deleteid.'']['tmp_name']) || is_uploaded_file($_FILES['image_path'.$deleteid.'']['tmp_name'])){
    
      $file_size =$_FILES['image_path'.$deleteid.'']['size'];
      $file_type=$_FILES['image_path'.$deleteid.'']['type'];
      $file_tmp =$_FILES['image_path'.$deleteid.'']['tmp_name'];

      $file_ext = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));
      $ext = "png";
      $ext2 = "jpg";
      $ext3 = "jpeg";
      if(strcmp($file_ext,$ext) != 0 && strcmp($file_ext,$ext2) != 0 && strcmp($file_ext,$ext3) != 0){
         $_SESSION['message'] = "Extension not allowed, please choose an image file ";
         $_SESSION['status'] = "warning";
         $_SESSION['title'] = "Warning!";
         header('Location: category.php');
         return;
      }
      move_uploaded_file($file_tmp,$target_dir.$file_name);


    $link = "images/".$file_name;
    }
    else{
        $link = $_POST['default_link'.$deleteid.''];
    }  
    

      $sql = "UPDATE category_master
              SET category_name = :category_name,
                  category_description = :category_description,
                  category_image = :category_image
              WHERE category_id = ".$deleteid;
      $stmt = $pdo->prepare($sql);
      $stmt->execute(array(
        ':category_name' => $category_name,
        ':category_description' => $category_description,
        ':category_image' => $link));
    }
    $_SESSION['message'] = "Changes are saved successfully!";
    $_SESSION['status'] = "success";
    $_SESSION['title'] = "Success!";
    header('Location: category.php');
    return;
  }
  else {
    $_SESSION['message']='No categories are chosen to make changes.';
    $_SESSION['status'] = "warning";
    $_SESSION['title'] = "Warning!";
    header('Location: category.php');
    return;
  }
}
