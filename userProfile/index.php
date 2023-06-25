<?php
//session_start();
include('../config.php');
// require_once "../style.php";

//require_once 'checkaccess.php';
if (isset(($_COOKIE['user_id']))) {
    $user_id = $_COOKIE['user_id'];
}

$sql = "SELECT * FROM user_master WHERE user_id = $user_id";
$res = mysqli_query($conn, $sql);
$res = $res->fetch_assoc();
// var_dump($res);
// var_dump($_SESSION);
$role_id = $_COOKIE['role_id'];
$name = $_COOKIE['name'];
// $mobile_no = $_COOKIE['mobile_no'];
// $email_id = $_COOKIE['email_id'];
// $mobile_no = "9876654432";
// $email_id = "dfkjdfk";

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <title>My Profile</title>
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Template Main CSS File -->

    <link rel="stylesheet" href="../volt/css/volt.css">
    <link href="../assets/css/style.css" rel="stylesheet">

    <style>
        @media (min-width: 1200px) {

            .container-xl,
            .container-lg,
            .container-md,
            .container-sm,
            .container {
                max-width: 95vw;
            }
        }

        #navbar {
            padding: 0;
        }
    </style>
</head>


<body onload="updateCartNav()">

    <!-- Topnav -->
    <div class="" style="max-width: 100vw!important;">
        <?php require_once "../navbar.php"; ?>
    </div>

    <!-- Edit Details Form -->
    <main class="mx-3 mt-6" >
        <div class="row">
            <div class="col-12 col-xl-8">
                <div class="card card-body border-0 shadow mb-4">
                    <h2 class="h5 mb-4" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 32px;">My Profile</h2>
                    <form action="handleUpdate.php" method="post">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <div>
                                    <label for="first_name" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 18px;">Name</label>
                                    <input name="name" class="form-control" id="first_name" type="text" value="<?= $res['name'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="email" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 18px;">Email</label>
                                    <input class="form-control" id="email1" type="email" value="<?= $res['email_id'] ?>" required disabled>
                                    <input hidden name="email_id" class="form-control" id="email" type="email" value="<?= $res['email_id'] ?>" required>
                                </div>
                            </div>
                        </div>
                        
                        <div class="row align-items-center">
                            <div class="col-md-6 mb-3">
                                <label for="birthday" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 18px;">Birthday</label>
                                <div class="input-group">
                                    <span class="input-group-text">
                                        <svg class="icon icon-xs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                            <path fill-rule="evenodd" d="M6 2a1 1 0 00-1 1v1H4a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-1V3a1 1 0 10-2 0v1H7V3a1 1 0 00-1-1zm0 5a1 1 0 000 2h8a1 1 0 100-2H6z" clip-rule="evenodd"></path>
                                        </svg>
                                    </span>
                                    <input name="birthday" class="form-control" id="birthday" type="date" placeholder="dd/mm/yyyy" value="<?= $res['birthday'] ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="gender" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 18px;">Gender</label>
                                <select name="gender" class="form-select mb-0" id="gender" aria-label="Gender select example" required>
                                    <option value="" selected>Gender</option>
                                    <option value="1" <?php if ($res['gender'] == 1) {
                                                            echo 'selected';
                                                        } ?>>Female</option>
                                    <option value="2" <?php if ($res['gender'] == 2) {
                                                            echo 'selected';
                                                        } ?>>Male</option>
                                </select>
                            </div>
                        </div>
                        <div class="row">
                            
                            <div class="col-md-6 mb-3">
                                <div class="form-group">
                                    <label for="phone" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 18px;">Phone</label>
                                    <input name="mobile_no" class="form-control" id="phone" type="tel" pattern="^[1-9]{1}[0-9]{9}" onkeypress='return event.charCode >= 48 && event.charCode <= 57' minlength="10" maxlength="10" value="<?= $res['mobile_no'] ?>" placeholder="Mobile Number" required>
                                </div>
                            </div>
                        </div>
                        <div class="mt-2">
                            <button id="saveChanges" class="btn btn-sm btn-secondary" name="update" type="submit" style="background: #012970; padding: 8px 20px; border-radius: 4px; color: #fff;">Save all</button>
                        </div>
                    </form>
                </div>
                <div class="card card-body border-0 shadow mb-3">
                    <div class="col-md-6 mb-2">
                        <label class="my-1 me-2" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 18px;" for="event_category">Login Preference</label>
                        <select  class="form-select" id="role_preference" aria-label="Default select example" onchange="updatepref()" required>

                            <?php
                            if ($role_id == 1) {
                                echo '<option value="1" selected >User</option>';
                            } else {
                                echo '<option value="1" >User</option>';
                            }
                            if (in_array(2, $_SESSION['roles'])) {
                                if ($role_id == 2) {
                                    echo '<option value="2" selected>Event Manager</option>';
                                } else {
                                    echo '<option value="2">Event Manager</option>';
                                }
                            }
                            if (in_array(3, $_SESSION['roles'])) {
                                if ($role_id == 3) {
                                    echo '<option value="3" selected>Admin</option>';
                                } else {
                                    echo '<option value="3">Admin</option>';
                                }
                            }
                            ?>
                        </select>
                    </div>
                    <!-- <div class="mt-1">
                            <button id="saveChanges" class="btn btn-sm btn-secondary" name="update" type="submit" style="background: #012970; padding: 8px 20px; border-radius: 4px; color: #fff;">Save all</button>
                        </div> -->
                </div>
            </div>


            <!-- Profile Card -->
            <div class="col-12 col-xl-4">
                <div class="row">
                    <div class="col-12 mb-4">
                        <div class="card shadow border-0 text-center">
                            <div class="card-body">
                                <img src="<?= $res['user_image'] ?>" class="avatar-xxl rounded-circle mx-auto mb-1 mt-2" alt="user image" style="height: 220px; width: 220px;">
                                <form method="post" action="handleImage.php" enctype="multipart/form-data"> <br>
                                    <input type="hidden" name="default_link" value="<?= $res['user_image'] ?>">
                                    <input name="image_path" class="form-control" type="file" id="user_images" oninvalid="this.setCustomValidity('Please select an image to continue')"> <br>
                                    <button class="btn btn-sm btn-secondary" type="submit" style="background: #012970; padding: 8px 20px; border-radius: 4px; color: #fff;">Upload Image</button>
                                </form>
                                <br>
                                <h2 class="h3" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 25px;"><?= $res['name'] ?></h2>
                                <h5 class="fw-normal"></h5>
                                <p class="text-gray mb-4" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 15px;"><?= $res['email_id'] ?></p>
                                <button id="imageUpload" type="button" class="btn btn-sm btn-secondary mb-3" data-bs-toggle="modal" data-bs-target="#modalSignUp" style="background: #012970; padding: 8px 20px; border-radius: 4px; color: #fff;">Change Password</button>


                                <!-- Change Password Modal -->
                                <!-- Modal Content -->
                                <div class="modal fade" id="modalSignUp" tabindex="-1" role="dialog" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h2 class="h4 text-center" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 28px;">Change Password</h2>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close" id="closebtn"></button>
                                            </div>
                                            <div class="modal-body px-md-5">


                                                <div class="form-group mb-4">
                                                    <label for="oldPassword" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 18px;">Current Password</label>
                                                    <div class="input-group">
                                                        <span class="input-group-text border-gray-300" id="basic-addon4">
                                                            <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                            </svg>
                                                        </span>
                                                        <input name="oldPassword" type="password" placeholder="Password" class="form-control border-gray-300" id="oldPassword" required>
                                                    </div>
                                                </div>
                                                <div class="form-group">
                                                    <div class="form-group mb-4">
                                                        <label for="newPassword1" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 18px;">New Password</label>
                                                        <div class="input-group">
                                                            <span class="input-group-text border-gray-300" id="basic-addon4">
                                                                <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            </span>
                                                            <input name="newPassword1" type="password" placeholder="Password" class="form-control border-gray-300" id="newPassword1" required>
                                                        </div>
                                                    </div>
                                                    <div class="form-group mb-4">
                                                        <label for="newPassword2" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 18px;">Confirm New Password</label> <span id="message"></span>
                                                        <div class="input-group">
                                                            <span class="input-group-text border-gray-300" id="basic-addon5">
                                                                <svg class="icon icon-xxs" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                                                                    <path fill-rule="evenodd" d="M5 9V7a5 5 0 0110 0v2a2 2 0 012 2v5a2 2 0 01-2 2H5a2 2 0 01-2-2v-5a2 2 0 012-2zm8-2v2H7V7a3 3 0 016 0z" clip-rule="evenodd"></path>
                                                                </svg>
                                                            </span>
                                                            <input name="newPassword2" type="password" placeholder="Confirm Password" class="form-control border-gray-300" id="newPassword2" onkeyup='check();' required>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="d-grid">
                                                    <button type="click" class="btn btn-primary" id="subbutton" style="background: #012970; padding: 8px 20px; border-radius: 4px; color: #fff;">Change Password</button>
                                                </div> <br>
                                            </div>
                                        </div><br>
                                    </div>
                                </div>
                                <button class="btn btn-danger" id="errorAlert" hidden>Error alert</button>
                                <!-- End of Modal Content -->

                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <!-- Footer -->
    <?php include("../footer.php"); ?>


    <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>
    <script src="../vendor/@popperjs/core/dist/umd/popper.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <!-- <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script> -->
    <!-- Vendor JS Files -->
    <script src="../assets/vendor/purecounter/purecounter.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <!-- <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script> -->
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <!-- <script src="../assets/vendor/php-email-form/validate.js"></script> -->

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
    <script>
        $("#subbutton").click(function() {
            var oldpass = $("#oldPassword").val();

            $.ajax({
                url: 'handlePassword.php',
                type: 'POST',
                async: false,
                data: {
                    oldPassword: $("#oldPassword").val(),
                    newPassword1: $("#newPassword1").val(),
                },
                dataType: 'json',
                success: function(data) {
                    $("#oldPassword").val("");
                    $("#newPassword1").val("");
                    $("#newPassword2").val("");
                    document.getElementById('message').innerHTML = '';
                    $("#closebtn").click();
                    if (data.success == 1) {
                        Swal.fire({
                            icon: 'success',
                            title: 'Password Changed Successfully!',

                        })
                    } else if (data.success == 0) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Old Password Does Not Match!',
                            text: 'Please check your old password and try again...',

                        })
                    }
                }
            });
        })
        <?php
        // var_dump($_SESSION);
        if (isset($_SESSION['added'])) {
            if ($_SESSION['added'] == 1) {
                unset($_SESSION['added']);
                echo "    Swal.fire({
            icon: 'success',
            title: 'Details Saved Successfully!',
        });";
            } else if ($_SESSION['added'] == 0) {
                unset($_SESSION['added']);
                echo "    Swal.fire({
            icon: 'error',
            title: 'Error!',
            text: 'Please check your details and try again...',
        });";
            }
        }

        if (isset($_SESSION['uploaded'])) {
            if ($_SESSION['uploaded'] == 1) {
                unset($_SESSION['uploaded']);
                echo " Swal.fire({
                        icon: 'success',
                        title: 'Image Uploaded Sucessfully!',
        });";
            } else if ($_SESSION['uploaded'] == 0) {
                unset($_SESSION['uploaded']);
                echo "    Swal.fire({
                        icon: 'error',
                        title: 'Image Upload Failed!',
                        text: 'Please check if an image is selected and try again.',
        });";
            }
        }
        ?>
        function updatepref(){
            // console.log($("#role_preference").find(":selected").val());
            $.ajax({
                url: 'updatepref.php',
                type: 'POST',
                data : {
                    pref: $("#role_preference").find(":selected").val()
                },
                success: function(data) {
                    data = JSON.parse(data);
                    if(data.status == 1){
                        Swal.fire({
                            icon: 'success',
                            title: 'Login Preference Updated Successfully!',
                        })
                    }
                    else if(data.status == 0){
                        Swal.fire({
                            icon: 'error',
                            title: 'Error!',
                            text: 'Please check your details and try again...',
                        })
                    }
                },
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
            if (document.getElementById('newPassword1').value == document.getElementById('newPassword2').value) {
                document.getElementById('message').style.color = 'green';
                document.getElementById('message').innerHTML = 'Matching';
                document.getElementById('subbutton').disabled = false;

            } else {
                document.getElementById('message').style.color = 'red';
                document.getElementById('message').innerHTML = 'Not Matching';
                document.getElementById('subbutton').disabled = true;

            }
        }
    </script>

</body>

</html>