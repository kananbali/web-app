<?php
session_start();

// echo($_POST['name']);
if(isset($_POST['access_token']) && isset($_POST['name']) && isset($_POST['email'])){
// if($_REQUEST['POST'] === true){
// echo $_SESSION['access_token'];
$_SESSION['name'] = $_POST['name'];
$_SESSION['email'] = $_POST['email'];
$_SESSION['signup_method'] = "facebook";
header('Location: ../addmobile.php');
// echo "<script> window.location.href = '../addmobile.php' </script>";
// return;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body >
    <form action="fb.php" method="post" id="form">
        <input type="hidden" name="access_token" id="access_token" value="">
        <input type="hidden" name="name" id="name" value="">
        <input type="hidden" name="email" id="email" value="">
    </form>
</body>
</html>

<script>
    document.getElementById('access_token').value =localStorage.getItem('access_token');
    document.getElementById('name').value = localStorage.getItem('name');
    document.getElementById('email').value = localStorage.getItem('email');
    document.getElementById('form').submit();
</script>