<?php
require_once '../config.php';
$email = $_POST['email'];
$sql = "SELECT * FROM user_master WHERE email_id = '$email' AND effective_end_dt IS NULL";
$result = mysqli_query($conn, $sql);
if($result->num_rows > 0){
    echo "exist";
}
// echo json_encode($_POST);

?>