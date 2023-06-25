<?php
require_once './config.php';
// var_dump($_SESSION);
$user_id = $_SESSION['user_id'];
$roles = $_SESSION['roles'];
$ret_array = array();
$ret_array['status'] = 1;
if(in_array(2,$roles)){
    echo json_encode($ret_array);
    
}
else{
    array_push($roles, 2);
    $_SESSION['roles'] = $roles;
    $assigned_roles = json_encode(array('roles'=>$roles));
    // echo $assigned_roles;
    $sql = "UPDATE user_master SET assigned_roles = '$assigned_roles' WHERE user_id = $user_id;";
    // var_dump($sql);
    // echo json_encode($sql);
    if (mysqli_query($conn, $sql)) {
        $ret_array['status'] = 1;
        echo json_encode($ret_array);
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}


// echo json_encode($);

?>