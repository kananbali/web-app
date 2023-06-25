<!DOCTYPE html>
<html lang="en">

<head> 
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<!-- Primary Meta Tags -->
<title>Forgot password</title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Favicon -->
<link rel="apple-touch-icon" sizes="120x120" href="../assets/img/logo.png">
<link rel="icon" type="image/png" sizes="32x32" href="../assets/img/logo.png">
<link rel="icon" type="image/png" sizes="16x16" href="../assets/img/logo.png">

<meta name="msapplication-TileColor" content="#ffffff">
<meta name="theme-color" content="#ffffff">

<!-- Sweet Alert -->
<link type="text/css" href="../../vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

<!-- Notyf -->
<link type="text/css" href="../../vendor/notyf/notyf.min.css" rel="stylesheet">

<!-- Volt CSS -->
<link type="text/css" href="../../css/volt.css" rel="stylesheet">

<script src="../../vendor/sweetalert2/dist/sweetalert2.all.min.js"></script>

</head>

<body> 
<?php
    require_once '../config.php';
    if ($_SERVER["REQUEST_METHOD"] == "POST" && ($conn)) {
        $email = $_POST["email"];
        $sql = "SELECT * FROM user_master WHERE email_id = '$email'";
        $result = mysqli_query($conn, $sql);
        if (mysqli_num_rows($result) > 0) {
            $newpass = uniqid();
            $password = hash('sha256', $newpass);
            $sql = "UPDATE user_master SET password = '$password' WHERE email_id = '$email'";
            if(mysqli_query($conn, $sql)) {
                echo '<script src="https://smtpjs.com/v3/smtp.js"> </script>
            <script>
            Email.send({
                Host: "smtp.gmail.com",
                Username: "aakar.mutha18@gmail.com",
                Password: "asbqqgosscscnofb",
                Port: "587",
                To: "' . $email . '",
                From: "finservevents@gmail.com",
                Subject: "Bajaj Events Password Reset",
                Body: "Thank you for asking for a password reset. Your new password is ' . $newpass . ' . Go to http://ec2-65-2-11-171.ap-south-1.compute.amazonaws.com/ to login to your account",
                })
                .then(function () {
                   Swal.fire({
                    title: "Password Reset",
                    text: "Your new password has been sent to your email id",
                    icon: "success",
                    confirmButtonText: "OK"
                }).then(function() {
                    window.location.replace("./login.php");
                });
                    
                });
        </script>';
        }

    } else {
        echo '<script> Swal.fire({
            title: "Error",
            text: "Email id not found",
            icon: "error",
            confirmButtonText: "OK"
        }).then(function() {
            window.location.replace("./sign-up.php");
        }); </script>';
    }
}
?>

   
    <main>
        <!-- Section -->
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center form-bg-image">
                    <p class="text-center">
                        <a href="./login.php" class="d-flex align-items-center justify-content-center">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path></svg>
                        Back to log in
                        </a>
                    </p>
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="signin-inner my-3 my-lg-0 bg-white shadow border-0 rounded p-4 p-lg-5 w-100 fmxw-500">
                            <h1 class="h3">Forgot your password?</h1>
                            <p class="mb-4">Just type in your email and we will send you a code to reset your password if you have registered with us!</p>
                            <form action="" method="POST">
                                <!-- Form -->
                                <div class="mb-4">
                                    <label for="email">Your Email</label>
                                    <div class="input-group">
                                        <input type="email" class="form-control" name="email" placeholder="example@company.com" required autofocus>
                                    </div>  
                                </div>
                                <!-- End of Form -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-gray-800">Recover password</button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <!-- Core -->
<script src="../../vendor/@popperjs/core/dist/umd/popper.min.js"></script>
<script src="../../vendor/bootstrap/dist/js/bootstrap.min.js"></script>

<!-- Vendor JS -->
<!-- <script src="../../vendor/onscreen/dist/on-screen.umd.min.js"></script> -->

<!-- Slider -->
<!-- <script src="../../vendor/nouislider/distribute/nouislider.min.js"></script> -->

<!-- Smooth scroll -->
<!-- <script src="../../vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script> -->

<!-- Charts -->

<!-- Datepicker -->
<!-- <script src="../../vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script> -->

<!-- Sweet Alerts 2 -->

<!-- Moment JS -->
<!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js"></script> -->

<!-- Vanilla JS Datepicker -->
<!-- <script src="../../vendor/vanillajs-datepicker/dist/js/datepicker.min.js"></script> -->

<!-- Notyf -->
<!-- <script src="../../vendor/notyf/notyf.min.js"></script> -->

<!-- Simplebar -->
<!-- <script src="../../vendor/simplebar/dist/simplebar.min.js"></script> -->

<!-- Github buttons -->
<!-- <script async defer src="https://buttons.github.io/buttons.js"></script> -->

<!-- Volt JS -->
<!-- <script src="../../assets/js/volt.js"></script> -->

</body>

</html>
