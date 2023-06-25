<?php
// var_dump($_SESSION);
echo("<div></div>");
// session_start();
// function display_message(){
    if(isset($_SESSION['message'])) {
    
        $msg = $_SESSION['message'];
        $status = $_SESSION['status'];
        $title = $_SESSION['title'];
      
        echo " <script src='//cdn.jsdelivr.net/npm/sweetalert2@11'></script>
        <script>
        Swal.fire({
           icon: '$status',
           title: '$title',
           text: '$msg',
           showConfirmButton: false,
           showCancelButton:false,
           timer:2000
       })
      </script>";
  
      unset($_SESSION['message']);
      unset($_SESSION['status']);
      unset($_SESSION['title']);
  }
// }


?>
