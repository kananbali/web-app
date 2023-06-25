<?php
session_start();
include('./google/glogin.php');
if (isset($_SESSION['login_error'])) {
    $login_error = $_SESSION['login_error'];
    unset($_SESSION['login_error']);
}
$_SESSION['redrurl'] = $_GET['redrurl'];
if ($_GET['popup'] == 1) {
    $_SESSION['redrurl'] = './loginsuccess.php';
}

if (!isset($_SESSION['access_token'])) {
    //Create a URL to obtain user authorization
    $google_login_btn = '<a href="' . $google_client->createAuthUrl() . '" class="btn btn-icon-only btn-pill btn-outline-gray-500 me-2" aria-label="google login button" title="google login button">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 30 30">    <path fill="currentColor" d="M 15.003906 3 C 8.3749062 3 3 8.373 3 15 C 3 21.627 8.3749062 27 15.003906 27 C 25.013906 27 27.269078 17.707 26.330078 13 L 25 13 L 22.732422 13 L 15 13 L 15 17 L 22.738281 17 C 21.848702 20.448251 18.725955 23 15 23 C 10.582 23 7 19.418 7 15 C 7 10.582 10.582 7 15 7 C 17.009 7 18.839141 7.74575 20.244141 8.96875 L 23.085938 6.1289062 C 20.951937 4.1849063 18.116906 3 15.003906 3 z"></path></svg>
    </a>';
} else {

    // header("Location: dashboard.php");
}
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

    <!-- Volt CSS -->
    <link type="text/css" href="../css/volt.css" rel="stylesheet">
</head>

<body>
    <main>
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <p class="text-center">
                    <a href="../../index.php" class="d-flex align-items-center justify-content-center">
                        <svg class="icon icon-xs me-2" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M7.707 14.707a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414l4-4a1 1 0 011.414 1.414L5.414 9H17a1 1 0 110 2H5.414l2.293 2.293a1 1 0 010 1.414z" clip-rule="evenodd"></path>
                        </svg>
                        Back to homepage
                    </a>
                </p>
                <div class="row justify-content-center form-bg-image" data-background-lg="../assets/illustrations/signin.svg">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h1 class="mb-0 h3">Sign in to our platform</h1>
                            </div>
                            <form action="handlesignin-nonmodal.php" class="mt-4" method="post">
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
                                        <!-- <div class="form-check">
                                            <input class="form-check-input" type="checkbox" value="" id="remember">
                                            <label class="form-check-label mb-0" for="remember">
                                                Remember me
                                            </label>
                                        </div> -->
                                        <div>
                                            <a href="./forgot-password.php" class="small text-right">Forgot password?</a>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" id="" class="btn btn-gray-800">Sign in</button>
                                </div>
                            </form>
                            <div class="mt-3 mb-4 text-center">
                                <span class="fw-normal">or login with</span>
                            </div>
                            <div class="d-flex justify-content-center my-4">
                                <a href="#" class="btn btn-icon-only btn-pill btn-outline-gray-500 me-2" id="fblogin" aria-label="facebook button" title="facebook button">
                                    <svg class="icon icon-xxs" aria-hidden="true" focusable="false" data-prefix="fab" data-icon="facebook-f" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 320 512">
                                        <path fill="currentColor" d="M279.14 288l14.22-92.66h-88.91v-60.13c0-25.35 12.42-50.06 52.24-50.06h40.42V6.26S260.43 0 225.36 0c-73.22 0-121.08 44.38-121.08 124.72v70.62H22.89V288h81.39v224h100.17V288z"></path>
                                    </svg>
                                </a>
                                <?= $google_login_btn ?>
                                <a class="btn btn-icon-only btn-pill btn-outline-gray-500 me-2" id="githublogin" aria-label="github button" title="github button">
                                    <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" role="img" viewBox="0 0 24 24">
                                        <path fill="currentColor" d="M10.9,2.1c-4.6,0.5-8.3,4.2-8.8,8.7c-0.5,4.7,2.2,8.9,6.3,10.5C8.7,21.4,9,21.2,9,20.8v-1.6c0,0-0.4,0.1-0.9,0.1 c-1.4,0-2-1.2-2.1-1.9c-0.1-0.4-0.3-0.7-0.6-1C5.1,16.3,5,16.3,5,16.2C5,16,5.3,16,5.4,16c0.6,0,1.1,0.7,1.3,1c0.5,0.8,1.1,1,1.4,1 c0.4,0,0.7-0.1,0.9-0.2c0.1-0.7,0.4-1.4,1-1.8c-2.3-0.5-4-1.8-4-4c0-1.1,0.5-2.2,1.2-3C7.1,8.8,7,8.3,7,7.6C7,7.2,7,6.6,7.3,6 c0,0,1.4,0,2.8,1.3C10.6,7.1,11.3,7,12,7s1.4,0.1,2,0.3C15.3,6,16.8,6,16.8,6C17,6.6,17,7.2,17,7.6c0,0.8-0.1,1.2-0.2,1.4 c0.7,0.8,1.2,1.8,1.2,3c0,2.2-1.7,3.5-4,4c0.6,0.5,1,1.4,1,2.3v2.6c0,0.3,0.3,0.6,0.7,0.5c3.7-1.5,6.3-5.1,6.3-9.3 C22,6.1,16.9,1.4,10.9,2.1z"></path>
                                    </svg>
                                </a>
                                <!-- <a href="#" class="btn btn-icon-only btn-pill btn-outline-gray-500 me-2" id="twtlogin" aria-label="twittwe button" title="twitter button">
                                    <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px"  role="img" viewBox="0 0 32 32" >
                                        <path fill="currentColor" d="M 28 8.558594 C 27.117188 8.949219 26.167969 9.214844 25.171875 9.332031 C 26.1875 8.722656 26.96875 7.757813 27.335938 6.609375 C 26.386719 7.171875 25.332031 7.582031 24.210938 7.804688 C 23.3125 6.847656 22.03125 6.246094 20.617188 6.246094 C 17.898438 6.246094 15.691406 8.453125 15.691406 11.171875 C 15.691406 11.558594 15.734375 11.933594 15.820313 12.292969 C 11.726563 12.089844 8.097656 10.128906 5.671875 7.148438 C 5.246094 7.875 5.003906 8.722656 5.003906 9.625 C 5.003906 11.332031 5.871094 12.839844 7.195313 13.722656 C 6.386719 13.695313 5.628906 13.476563 4.964844 13.105469 C 4.964844 13.128906 4.964844 13.148438 4.964844 13.167969 C 4.964844 15.554688 6.660156 17.546875 8.914063 17.996094 C 8.5 18.109375 8.066406 18.171875 7.617188 18.171875 C 7.300781 18.171875 6.988281 18.140625 6.691406 18.082031 C 7.316406 20.039063 9.136719 21.460938 11.289063 21.503906 C 9.605469 22.824219 7.480469 23.609375 5.175781 23.609375 C 4.777344 23.609375 4.386719 23.585938 4 23.539063 C 6.179688 24.9375 8.765625 25.753906 11.546875 25.753906 C 20.605469 25.753906 25.558594 18.25 25.558594 11.742188 C 25.558594 11.53125 25.550781 11.316406 25.542969 11.105469 C 26.503906 10.410156 27.339844 9.542969 28 8.558594 Z"></path>
                                    </svg>
                                </a> -->

                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-4">
                                <span class="fw-normal">
                                    Not registered?
                                    <a href="./sign-up.php" class="fw-bold">Create account</a>
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
    <!-- <script src="../vendor/nouislider/distribute/nouislider.min.js"></script> -->

    <!-- Smooth scroll -->
    <!-- <script src="../vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script> -->

    <!-- Charts -->
    <!-- <script src="../vendor/chartist/dist/chartist.min.js" type="text/javascript"></script>
    <script src="../vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js" type="text/javascript"></script> -->

    <!-- Datepicker -->
    <!-- <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js" type="text/javascript"></script> -->

    <!-- Sweet Alerts 2 -->
    <script src="../vendor/sweetalert2/dist/sweetalert2.all.min.js" type="text/javascript"></script>

    <!-- Moment JS -->
    <!-- <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" type="text/javascript"></script> -->

    <!-- Vanilla JS Datepicker -->
    <!-- <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js" type="text/javascript"></script> -->

    <!-- Notyf -->
    <!-- <script src="../vendor/notyf/notyf.min.js" type="text/javascript"></script> -->

    <!-- Simplebar -->
    <!-- <script src="../vendor/simplebar/dist/simplebar.min.js" type="text/javascript"></script> -->

    <!-- Github buttons -->
    <!-- <script async defer src="https://buttons.github.io/buttons.js" type="text/javascript"></script> -->

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
        if ("<?php echo $login_error ?>" == 1 && "<?php echo $_SERVER['REQUEST_METHOD'] ?>" == 'GET') {
            document.getElementById('errorAlert').click();
        }
    </script>
</body>

</html>