<?php
// session_start();
include('../config.php');
// var_dump($_POST);

$name = $_POST['name'];
$gender = $_POST['gender'];
$birthday = $_POST['birthday'];
$email_id = $_POST['email_id'];
$mobile_no = $_POST['mobile_no'];
$user_id = $_COOKIE['user_id'];
$_SESSION['name'] = $_POST['name'];
// $_SESSION['role_id'] = $_POST['role_preference'];
// unset($_COOKIE['role_id']);
// setcookie('role_id', $role_preference, time() + (86400 * 30), "/");
// echo $birthday;

$sql2 = "UPDATE user_master
		SET 
		name = '$name',
		mobile_no = '$mobile_no',
		email_id = '$email_id',
		gender = '$gender',
		birthday = '$birthday'
        WHERE
        user_id = $user_id;
	";
echo $sql2;
// $res2 = mysqli_query($conn, $sql2);
if ($mysqli->query($sql2)) {
	header('Location: index.php');
	$_SESSION['added'] = 1;
}
else {
	$_SESSION['added'] = 0;
	var_dump($mysqli->error);
	header('Location: index.php');
}
?>
