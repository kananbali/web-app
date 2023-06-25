<?php
// session_start();
// var_dump($_SESSION);
require_once '../config.php';
unset($_SESSION['access_token']);
if ($_SERVER["REQUEST_METHOD"] == "POST" && ($conn)) {
    $email = $_POST["email"];
    $password = hash('sha256', $_POST["password"]);
    // echo $password;
    $sql = "SELECT * FROM `user_master` WHERE email_id = '$email' AND password = '$password' AND effective_end_dt IS NULL";
    $result = mysqli_query($conn, $sql);
    // var_dump($result);
    // echo $sql;
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $name = $row['name'];
        $mobile_no = $row['mobile_no'];
        $role_id = $row['role_preference'];
        $user_id = $row['user_id'];
        // session_start();
        $_SESSION['name'] = $name;
        $_SESSION['role_id'] = $role_id;
        setcookie("name", $name, time() + (86400 * 30), "/");
        setcookie("user_id", $user_id, time() + (86400 * 30), "/");
        $_SESSION['user_id'] = $user_id;
        setcookie("role_id", $role_id, time() + (86400 * 30), "/");
        $_SESSION['roles'] = json_decode($row['assigned_roles'])->roles;
        $_SESSION['email_id'] = $row['email_id'];
        var_dump($_SESSION);
        if (isset($_SESSION['redrurl'])) {
            $redurl = $_SESSION['redrurl'];
            unset($_SESSION['redrurl']);
        } else {
            $redurl = "../index.php";
        }

        if (!isset($_SESSION['popup'])) {
            echo "here";
            if ($role_id == 1) {
                header("Location: " . $redurl);
            } elseif ($role_id == 2) {
                header("Location: ../eventManager/event-list.php");
            } elseif ($role_id == 3) {
                header("Location: ../admin/");
            } 
        } else {
            if($_SESSION['popup'] == 1) {
                unset($_SESSION['popup']);
                header("Location: ./loginsuccess.php");
            }
        }
    } else {
        $_SESSION['login_error'] = 1;
        header("Location: ./login.php");
        // echo "<script> window.location.href = './login.php' </script>";
    }
}
