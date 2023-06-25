<?php
// $appid = '456704782820807';
include('./google/glogin.php');
require_once('../config.php');
//session_start();
$pass_match = $_SESSION['pass_match'];
if (isset($_GET['orgs'])) {
    $_SESSION['role_id'] = 2;
} else {
    $_SESSION['role_id'] = 1;
}
if (!isset($_SESSION['access_token'])) {
    //Create a URL to obtain user authorization
    $google_login_btn = '<a href="' . $google_client->createAuthUrl() . '" class="btn btn-icon-only btn-pill btn-outline-gray-500 me-2" aria-label="google login button" title="google login button">
    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 30 30">    <path fill="currentColor" d="M 15.003906 3 C 8.3749062 3 3 8.373 3 15 C 3 21.627 8.3749062 27 15.003906 27 C 25.013906 27 27.269078 17.707 26.330078 13 L 25 13 L 22.732422 13 L 15 13 L 15 17 L 22.738281 17 C 21.848702 20.448251 18.725955 23 15 23 C 10.582 23 7 19.418 7 15 C 7 10.582 10.582 7 15 7 C 17.009 7 18.839141 7.74575 20.244141 8.96875 L 23.085938 6.1289062 C 20.951937 4.1849063 18.116906 3 15.003906 3 z"></path></svg>
    </a>';
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Sign up with Bajaj Finserv Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="../../assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../../assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="../../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="theme-color" content="#ffffff">


    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>


    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.3/umd/popper.min.js" integrity="sha384-vFJXuSJphROIrBnz7yo7oB41mKfc8JzQZiCq4NCceLEaO4IHwicKwpJf9c9IpFgh" crossorigin="anonymous"></script>


    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js" integrity="sha384-alpBpkh1PFOepccYVYDB4do5UnbKysX5WZXm3XxPqe5iKTfUKjNkCk9SaVuEZflJ" crossorigin="anonymous"></script>
    <!-- Sweet Alert -->
    <link type="text/css" href="../vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

    <!-- Notyf -->
    <link type="text/css" href="../vendor/notyf/notyf.min.css" rel="stylesheet">

    <!-- Volt CSS -->
    <link type="text/css" href="../css/volt.css" rel="stylesheet">
    <link type="text/css" href="../css/password.css" rel="stylesheet">
</head>

<body>
    <main>

        <!-- Section -->
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
                                <h1 class="mb-0 h3">Create Account </h1>
                            </div>
                            <form action="handlesignup.php" class="mt-4" method="post">
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="email">Enter Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 50 50">
                                                <path d="M 14 3.9902344 C 8.4886661 3.9902344 4 8.4789008 4 13.990234 L 4 35.990234 C 4 41.501568 8.4886661 45.990234 14 45.990234 L 36 45.990234 C 41.511334 45.990234 46 41.501568 46 35.990234 L 46 13.990234 C 46 8.4789008 41.511334 3.9902344 36 3.9902344 L 14 3.9902344 z M 18.005859 12.033203 C 18.633859 12.060203 19.210594 12.414031 19.558594 12.957031 C 19.954594 13.575031 20.569141 14.534156 21.369141 15.785156 C 22.099141 16.926156 22.150047 18.399844 21.498047 19.589844 L 20.033203 21.673828 C 19.637203 22.237828 19.558219 22.959703 19.824219 23.595703 C 20.238219 24.585703 21.040797 26.107203 22.466797 27.533203 C 23.892797 28.959203 25.414297 29.761781 26.404297 30.175781 C 27.040297 30.441781 27.762172 30.362797 28.326172 29.966797 L 30.410156 28.501953 C 31.600156 27.849953 33.073844 27.901859 34.214844 28.630859 C 35.465844 29.430859 36.424969 30.045406 37.042969 30.441406 C 37.585969 30.789406 37.939797 31.366141 37.966797 31.994141 C 38.120797 35.558141 35.359641 37.001953 34.556641 37.001953 C 34.000641 37.001953 27.316344 37.761656 19.777344 30.222656 C 12.238344 22.683656 12.998047 15.999359 12.998047 15.443359 C 12.998047 14.640359 14.441859 11.879203 18.005859 12.033203 z"></path>
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Full Name" name="name" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="email">Your Email</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M2.003 5.884L10 9.882l7.997-3.998A2 2 0 0016 4H4a2 2 0 00-1.997 1.884z"></path>
                                                <path d="M18 8.118l-8 4-8-4V14a2 2 0 002 2h12a2 2 0 002-2V8.118z"></path>
                                            </svg>
                                        </span>
                                        <input type="email" id="email" class="form-control" placeholder="example@company.com" name="email" value="" onfocusout="checkifexist()" autofocus required>
                                    </div>
                                </div>
                                <div class="form-group mb-4">
                                    <label for="email">Your Mobile Number</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                            <svg class="icon icon-xs text-gray-600" fill="currentColor" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" width="20" height="20" viewBox="0 0 50 50">
                                                <path d="M 14 3.9902344 C 8.4886661 3.9902344 4 8.4789008 4 13.990234 L 4 35.990234 C 4 41.501568 8.4886661 45.990234 14 45.990234 L 36 45.990234 C 41.511334 45.990234 46 41.501568 46 35.990234 L 46 13.990234 C 46 8.4789008 41.511334 3.9902344 36 3.9902344 L 14 3.9902344 z M 18.005859 12.033203 C 18.633859 12.060203 19.210594 12.414031 19.558594 12.957031 C 19.954594 13.575031 20.569141 14.534156 21.369141 15.785156 C 22.099141 16.926156 22.150047 18.399844 21.498047 19.589844 L 20.033203 21.673828 C 19.637203 22.237828 19.558219 22.959703 19.824219 23.595703 C 20.238219 24.585703 21.040797 26.107203 22.466797 27.533203 C 23.892797 28.959203 25.414297 29.761781 26.404297 30.175781 C 27.040297 30.441781 27.762172 30.362797 28.326172 29.966797 L 30.410156 28.501953 C 31.600156 27.849953 33.073844 27.901859 34.214844 28.630859 C 35.465844 29.430859 36.424969 30.045406 37.042969 30.441406 C 37.585969 30.789406 37.939797 31.366141 37.966797 31.994141 C 38.120797 35.558141 35.359641 37.001953 34.556641 37.001953 C 34.000641 37.001953 27.316344 37.761656 19.777344 30.222656 C 12.238344 22.683656 12.998047 15.999359 12.998047 15.443359 C 12.998047 14.640359 14.441859 11.879203 18.005859 12.033203 z"></path>
                                            </svg>
                                        </span>
                                        <input type="tel" class="form-control" placeholder="Mobile Number" name="mobile" ppattern="[1-9]{1}[0-9]{9}" onkeypress='return event.charCode >= 48 && event.charCode <= 57' maxlength="10" autofocus required>
                                    </div>
                                </div>
                                <!-- End of Form -->
                                <div class="form-group">
                                    <!-- Form -->
                                    <div class="form-group mb-4">
                                        <label for="password">Your Password</label>
                                        <!-- <div id="messagePass">
                                            <p id="letter" class="invalid">A <b>lowercase</b> letter</p>
                                            <p id="capital" class="invalid">A <b>capital (uppercase)</b> letter</p>
                                            <p id="number" class="invalid">A <b>number</b></p>
                                            <p id="length" class="invalid">Minimum <b>8 characters</b></p>
                                        </div> -->
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2">
                                                <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                            <input class="form-control popover_onfocus" 
                                            type="password" name="psw" id="psw" 
                                            pattern="(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}" 
                                            placeholder="Password" 
                                            data-toggle="popover" 
                                            data-placement="bottom"
                                            data-html="true" 
                                            data-content='
                                                <div id="messagePass">
                                                <p id="letter" class="invalid">A <b>Lowercase</b> Letter</p>
                                                <p id="capital" class="invalid">A <b>Uppercase</b> Letter</p>
                                                <p id="number" class="invalid">A <b>Number</b></p>
                                                <p id="length" class="invalid">Minimum <b>8 Characters</b></p></div>
                                        ' required autofocus />
                                        </div>
                                    </div>
                                    <!-- End of Form -->
                                    <!-- Form -->
                                    <div class="form-group mb-4">
                                        <label for="confirm_password">Confirm Password</label> <span id="message"></span>
                                        <div class="input-group">
                                            <span class="input-group-text" id="basic-addon2">
                                                <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                </svg>
                                            </span>
                                            <input type="password" placeholder="Confirm Password" class="form-control" id="confirm_password" name="confirm_password" onkeyup='check();' required>
                                        </div>
                                    </div>
                                </div>
                                <div class="d-grid">
                                    <button type="submit" id="subbutton" class="btn btn-gray-800">Sign up</button>
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
                                    <svg class="icon icon-xs" xmlns="http://www.w3.org/2000/svg" x="0px" y="0px" role="img" viewBox="0 0 32 32">
                                        <path fill="currentColor" d="M 28 8.558594 C 27.117188 8.949219 26.167969 9.214844 25.171875 9.332031 C 26.1875 8.722656 26.96875 7.757813 27.335938 6.609375 C 26.386719 7.171875 25.332031 7.582031 24.210938 7.804688 C 23.3125 6.847656 22.03125 6.246094 20.617188 6.246094 C 17.898438 6.246094 15.691406 8.453125 15.691406 11.171875 C 15.691406 11.558594 15.734375 11.933594 15.820313 12.292969 C 11.726563 12.089844 8.097656 10.128906 5.671875 7.148438 C 5.246094 7.875 5.003906 8.722656 5.003906 9.625 C 5.003906 11.332031 5.871094 12.839844 7.195313 13.722656 C 6.386719 13.695313 5.628906 13.476563 4.964844 13.105469 C 4.964844 13.128906 4.964844 13.148438 4.964844 13.167969 C 4.964844 15.554688 6.660156 17.546875 8.914063 17.996094 C 8.5 18.109375 8.066406 18.171875 7.617188 18.171875 C 7.300781 18.171875 6.988281 18.140625 6.691406 18.082031 C 7.316406 20.039063 9.136719 21.460938 11.289063 21.503906 C 9.605469 22.824219 7.480469 23.609375 5.175781 23.609375 C 4.777344 23.609375 4.386719 23.585938 4 23.539063 C 6.179688 24.9375 8.765625 25.753906 11.546875 25.753906 C 20.605469 25.753906 25.558594 18.25 25.558594 11.742188 C 25.558594 11.53125 25.550781 11.316406 25.542969 11.105469 C 26.503906 10.410156 27.339844 9.542969 28 8.558594 Z"></path>
                                    </svg>
                                </a> -->
                            </div>
                            <div class="d-flex justify-content-center align-items-center mt-4">
                                <span class="fw-normal">
                                    Already have an account?
                                    <a href="./login.php" class="fw-bold">Login here</a>
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
        $(function() {
            $('.popover_onfocus').popover({
                trigger: 'focus'
            }).on('shown.bs.popover', function() {
                $('body .popover').css({
                    'max-width': '800px'
                });
            });
        })

        var myInput = document.getElementById("psw");
        

        // When the user clicks on the password field, show the message box
        myInput.onfocus = function() {
            document.getElementById("messagePass").style.display = "block";
        }

        // When the user clicks outside of the password field, hide the message box
        myInput.onblur = function() {
            document.getElementById("messagePass").style.display = "none";
        }

        // When the user starts to type something inside the password field
        var total;
        $('[data-toggle="popover"]').on('shown.bs.popover', function () {
        var letter = document.getElementById("letter");
        var capital = document.getElementById("capital");
        var number = document.getElementById("number");
        var length = document.getElementById("length");
        myInput.onkeyup = function() {
            total = 0;
            // Validate lowercase letters
            var lowerCaseLetters = /[a-z]/g;
            if (myInput.value.match(lowerCaseLetters)) {
                letter.classList.remove("invalid");
                letter.classList.add("valid");
                total += 1;
            } else {
                letter.classList.remove("valid");
                letter.classList.add("invalid");
                total -= 1;
            }

            // Validate capital letters
            var upperCaseLetters = /[A-Z]/g;
            if (myInput.value.match(upperCaseLetters)) {
                capital.classList.remove("invalid");
                capital.classList.add("valid");
                total += 1;
            } else {
                capital.classList.remove("valid");
                capital.classList.add("invalid");
                total -= 1;
            }

            // Validate numbers
            var numbers = /[0-9]/g;
            if (myInput.value.match(numbers)) {
                number.classList.remove("invalid");
                number.classList.add("valid");
                total += 1;
            } else {
                number.classList.remove("valid");
                number.classList.add("invalid");
                total -= 1;
            }

            // Validate length
            if (myInput.value.length >= 8) {
                length.classList.remove("invalid");
                length.classList.add("valid");
                total += 1;
            } else {
                length.classList.remove("valid");
                length.classList.add("invalid");
                total -= 1;
            }
            if (total != 4) {
                document.getElementById('subbutton').disabled = true;;
            }
            return total;
        }
    });



        if (performance.navigation.type == 2) {

            location.reload(true);

        }

        function checkifexist() {
            var email = $('#email').val();
            $.ajax({
                url: './checkemail.php',
                type: 'POST',
                data: {
                    email: email
                },
                success: function(data) {
                    // console.log(data);
                    if (data == 'exist') {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Email already exist! Please use some other Email.',
                        }).then((result) => {
                            if (result.value) {
                                $('#email').val('');
                            }
                        })
                    }
                }
            })
        }

        document.getElementById('errorAlert').addEventListener('click', function() {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Your passwords did not match. Please Try Again!',
            })
        });
        document.getElementById('subbutton').disabled = true;

        function check() {
            if (document.getElementById('psw').value == document.getElementById('confirm_password').value) {
                if (total != 4) {
                    document.getElementById('message').style.color = 'red';
                    document.getElementById('message').innerHTML = 'Password too weak';
                    document.getElementById('subbutton').disabled = true;
                } else {
                    document.getElementById('message').style.color = 'green';
                    document.getElementById('message').innerHTML = 'Matching';
                    document.getElementById('subbutton').disabled = false;
                }

            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Not Matching';
                document.getElementById('subbutton').disabled = true;

            }
        }
    </script>

</body>

</html>