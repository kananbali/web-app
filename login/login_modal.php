<?php
session_start();
include('./google/glogin.php');
if(isset($_SESSION['login_error'])){
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
$_SESSION['redrurl'] = $_GET['redrurl'];
if($_GET['popup'] == 1){
    $_SESSION['redrurl'] = './loginsuccess.php';
    $_SESSION['popup'] = 1;
}
// var_dump($_SESSION);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <script src="https://kit.fontawesome.com/0dbfcd8819.js" crossorigin="anonymous"></script>
    <!-- Primary Meta Tags -->
    <title>Sign in to Bajaj Finserv Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">

    <!-- Sweet Alert -->
    <link type="text/css" href="../vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Notyf -->
    <link type="text/css" href="../vendor/notyf/notyf.min.css" rel="stylesheet">

    <!-- Volt CSS -->
    <link type="text/css" href="../css/volt.css" rel="stylesheet">
</head>

<body>
    <main>
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <div class="row justify-content-center form-bg-image">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h1 class="mb-0 h3">Sign in to our platform</h1>
                            </div>
                            <form action="handlesignin.php" class="mt-4" method="post">
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="email">Your Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                            </svg>
                                        </span>
                                        <input type="email" class="form-control" placeholder="example@company.com" name="email" autofocus required>
                                    </div>
                                </div>
                                <!-- End of Form -->
                                <div class="form-group">
                                    <!-- Form -->
                                    <div class="form-group mb-4">
                                        <label for="password">Your Password</label>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2">
                                                <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                            <input type="password" placeholder="Password" class="form-control" name="password" required>
                                        </div>
                                    </div>
                                    <!-- End of Form -->
                                    <div class="d-flex justify-content-between align-items-top mb-4">
                                        <div>
                                            <a href="./forgot-password-modal.php" class="small text-right">Forgot password?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit"  id=""  class="btn btn-gray-800">Sign in</button>
                                </div>
                            </form>
                            <div class="d-flex justify-content-center align-items-center mt-4">
                                <span class="fw-normal">
                                    Not registered?
                                    <a href="./sign-up-modal.php" class="fw-bold">Create account</a>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <button class="btn btn-danger" id="errorAlert" hidden>Error alert</button>
    </main>

    <!-- Core -->
    <script src="../vendor/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="../vendor/bootstrap/dist/js/bootstrap.min.js"></script>

    <!-- Vendor JS -->
    <script src="../vendor/onscreen/dist/on-screen.umd.min.js"></script>

    <!-- Slider -->
    <script src="../vendor/nouislider/distribute/nouislider.min.js"></script>

    <!-- Smooth scroll -->
    <script src="../vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

    <!-- Charts -->
    <script src="../vendor/chartist/dist/chartist.min.js" type="text/javascript"></script>
    <script src="../vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js" type="text/javascript"></script>

    <!-- Datepicker -->
    <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js" type="text/javascript"></script>

    <!-- Sweet Alerts 2 -->
    <script src="../vendor/sweetalert2/dist/sweetalert2.all.min.js" type="text/javascript"></script>

    <!-- Moment JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" type="text/javascript"></script>

    <!-- Vanilla JS Datepicker -->
    <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js" type="text/javascript"></script>

    <!-- Notyf -->
    <script src="../vendor/notyf/notyf.min.js" type="text/javascript"></script>

    <!-- Simplebar -->
    <script src="../vendor/simplebar/dist/simplebar.min.js" type="text/javascript"></script>

    <!-- Github buttons -->
    <script async defer src="https://buttons.github.io/buttons.js" type="text/javascript"></script>

    <!-- Volt JS -->
    <script src="../assets/js/volt.js" type="text/javascript"></script>

    <!-- Facebook Button Link -->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js" type="text/javascript"></script>
    <script src="./facebook/fblogin.js" type="text/javascript"></script>
    
    <!-- Github Login Button -->
    <script src="./github/gitlogin.js" type="text/javascript"></script>

    <script>
        document.getElementById('errorAlert').addEventListener('click', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Check your email and password and try again!',
            })
        });
        if("<?php echo $login_error?>" == 1 && "<?php echo $_SERVER['REQUEST_METHOD']?>" == 'GET') {
            document.getElementById('errorAlert').click();
        }
    
    </script>
</body>

</html>