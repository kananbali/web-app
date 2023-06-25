<?php
//session_start();
// var_dump($_SESSION);
$role_id = $_SESSION['role_id']?$_SESSION['role_id'] : 1;

include_once '../config.php';
unset($_SESSION['access_token']);
if($_POST['signup_method']){
    $name = $_POST["name"];
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        $effective_from_dt = date('m.d.y');
        $effective_end_dt = date('m.d.y', strtotime('+2 year'));
        $signup_method = $_POST['signup_method'];
        $assigned_roles = json_encode(array('roles'=>array(1)));
        $sql = "INSERT INTO user_master(email_id,name,mobile_no,role_preference,effective_from_dt,assigned_roles)
    VALUES ('$email','$name','$mobile',$role_id,STR_TO_DATE('$effective_from_dt','%m.%d.%y'),'$assigned_roles');";

        
        if (mysqli_query($conn, $sql)) {
            echo '<script src="https://smtpjs.com/v3/smtp.js"> </script>
            <script>
            Email.send({
                Host: "smtp.gmail.com",
                Username: "aakar.mutha18@gmail.com",
                Password: "asbqqgosscscnofb",
                Port: "587",
                To: "' . $email . '",
                From: "finservevents@gmail.com",
                Subject: "Bajaj Events Registeration",
                Body: "Thank you ' . $name . ' for registering with Finserv EVENTS. Go to http://ec2-65-2-11-171.ap-south-1.compute.amazonaws.com/ to register to your favourite events",
                })
                .then(function () {
                    window.location.href = "./login.php";
                    
                });
    </script>';
            
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
}
else if ($_POST['psw'] !== $_POST['confirm_password']) {
    $_SESSION['pass_match'] = 1;
    echo "<script>
    window.location.href = './sign-up.php';
</script>";
} else {
    if ($_SERVER["REQUEST_METHOD"] == "POST" && ($conn)) {
        $name = $_POST["name"];
        $password = hash('sha256', $_POST["psw"]);
        $email = $_POST["email"];
        $mobile = $_POST["mobile"];
        $effective_from_dt = date('m.d.y');
        $assigned_roles = json_encode(array('roles'=>array(1)));
        $sql = "INSERT INTO user_master(email_id,name,mobile_no,role_preference,effective_from_dt,password,assigned_roles) 
    VALUES ('$email','$name','$mobile',$role_id,STR_TO_DATE('$effective_from_dt','%m.%d.%y'),'$password','$assigned_roles');";

        if (mysqli_query($conn, $sql)) {
            echo '<script src="https://smtpjs.com/v3/smtp.js"> </script>
            <script>
            Email.send({
                Host: "smtp.gmail.com",
                Username: "aakar.mutha18@gmail.com",
                Password: "asbqqgosscscnofb",
                Port: "587",
                To: "' . $email . '",
                From: "finservevents@gmail.com",
                Subject: "Bajaj Events Registeration",
                Body: "Thank you ' . $name . ' for registering with Finserv EVENTS. Go to http://ec2-65-2-11-171.ap-south-1.compute.amazonaws.com/ to register to your favourite events",
                })
                .then(function () {
                    window.location.href = "./login.php";
                    
                });
    </script>';
        } else {
            echo "Error: " . $sql . "<br>" . $conn->error;
        }
    }
}


?>