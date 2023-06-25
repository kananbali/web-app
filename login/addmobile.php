<?php
//session_start();
// $appid = '456704782820807';
include('./google/glogin.php');
// var_dump($_SESSION);
require_once '../config.php';

if(isset($_SESSION['redrurl'])){
    $redurl = $_SESSION['redrurl'];
    unset($_SESSION['redrurl']);
}
else{
    $redurl = "../index.php";
}
$email = $_SESSION['email'];
$signup_method = $_SESSION['signup_method'];
$sql = "SELECT * FROM user_master WHERE email_id = '$email' AND effective_end_dt IS NULL";
$result = mysqli_query($conn, $sql);
// var_dump($_SESSION);
if($result->num_rows > 0){
    $row = $result->fetch_assoc();
    // var_dump($row);
    $name = $row['name'];
    $role_id = $row['role_preference'];
    $user_id = $row['user_id'];
    setcookie("name", $name, time() + (86400 * 30), "/");
    setcookie("user_id", $user_id, time() + (86400 * 30), "/");
    $_SESSION['user_id'] = $user_id;
    setcookie("role_id", $role_id, time() + (86400 * 30), "/");
    $_SESSION['roles'] = json_decode($row['assigned_roles'])->roles;
    $_SESSION['email_id'] = $email;
    
    // var_dump($row);
    
    if($role_id == 1){
        header("Location:" . $redurl);
    }
    elseif($role_id == 2){
        header("Location: ../eventManager/event-list.php");
    }
    elseif($role_id == 3){
        header("Location: ../admin/");

    }
}

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <!-- Primary Meta Tags -->
    <title>Complete Signup with Bajaj Finserv Events</title>
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <!-- Favicon -->
    <link rel="apple-touch-icon" sizes="120x120" href="../../assets/img/favicon/apple-touch-icon.png">
    <link rel="icon" type="image/png" sizes="32x32" href="../../assets/img/favicon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="16x16" href="../../assets/img/favicon/favicon-16x16.png">
    <link rel="manifest" href="../../assets/img/favicon/site.webmanifest">
    <link rel="mask-icon" href="../../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
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

        <!-- Section -->
        <section class="vh-lg-100 mt-5 mt-lg-0 bg-soft d-flex align-items-center">
            <div class="container">
                <p class="text-center">
                </p>
                <div class="row justify-content-center form-bg-image" data-background-lg="../../assets/img/illustrations/signin.svg">
                    <div class="col-12 d-flex align-items-center justify-content-center">
                        <div class="bg-white shadow border-0 rounded border-light p-4 p-lg-5 w-100 fmxw-500">
                            <div class="text-center text-md-center mb-4 mt-md-0">
                                <h2 class="mb-0 h3">Add Phone Number to Complete Signup! </h2>
                            </div>
                            <form action="handlesignup.php" class="mt-4" method="post">
                                <!-- Form -->
                                <div class="form-group mb-4">
                                    <label for="name"> Full Name</label>
                                    <div class="input-group">
                                        <span class="input-group-text" id="basic-addon1">
                                             <svg class="icon icon-xs text-gray-600" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                             <path d="M9 6a3 3 0 11-6 0 3 3 0 016 0zM17 6a3 3 0 11-6 0 3 3 0 016 0zM12.93 17c.046-.327.07-.66.07-1a6.97 6.97 0 00-1.5-4.33A5 5 0 0119 16v1h-6.07zM6 11a5 5 0 015 5v1H1v-1a5 5 0 015-5z"></path>
                                            </svg>
                                        </span>
                                        <input type="text" class="form-control" placeholder="Full Name" value='<?php echo $_SESSION["name"] ?>' autofocus required disabled>
                                        <input type="text" class="form-control" placeholder="Full Name" value='<?php echo $_SESSION["name"] ?>' name="name" autofocus required hidden>
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
                                        <input type="email" class="form-control disabled" placeholder="example@company.com" value="<?php echo $_SESSION['email'] ?>" autofocus required disabled>
                                        <input type="email" class="form-control disabled" placeholder="example@company.com" name="email" value="<?php echo $_SESSION['email'] ?>" autofocus required hidden>

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
                                        <!-- <input type="number" class="form-control" placeholder="1234567890" name="mobile" autofocus required> -->
                                        <input type="tel" class="form-control" placeholder="Mobile Number" onkeypress='return event.charCode >= 48 && event.charCode <= 57' name="mobile" pattern="[0-9]{10}" autofocus required>

                                    </div>
                                </div>
                                <input type="text" name="signup_method" value="<?php echo $_SESSION['signup_method']?>" hidden>
                                <!-- End of Form -->
                                <div class="d-grid">
                                    <button type="submit" class="btn btn-gray-800">Complete Sign up</button>
                                </div>
                            </form>
                            <div class="d-flex justify-content-center my-4">
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <button class="btn btn-danger" id="errorAlert" hidden>Error alert</button>
    </main>

    <!-- Core -->
    <script src="../vendor/@popperjs/core/dist/umd/popper.min.js" type="text/javascript"></script>
    <script src="../vendor/bootstrap/dist/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- Vendor JS -->
    <script src="../vendor/onscreen/dist/on-screen.umd.min.js" type="text/javascript"></script>

    <script src="../vendor/sweetalert2/dist/sweetalert2.all.min.js" type="text/javascript"></script>



    <!-- Volt JS -->
    <script src="../assets/js/volt.js" type="text/javascript"></script>

    <!-- Facebook Button Link -->
    <script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js" type="text/javascript"></script>
    <script src="./facebook/fblogin.js" type="text/javascript"></script>

    <!-- Github Login Button -->
    <script src="./github/gitlogin.js" type="text/javascript"></script>

</body>

</html>