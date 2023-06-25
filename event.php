<?php
require_once './config.php';
if (isset($_GET['transaction_id'])) {
    $trans_id = $_GET['transaction_id'];
}
if (isset($_GET['inqueue'])) {
    $inqueue = $_GET['inqueue'];
}
$event_id = $_GET['eventid'];
$registered = $_GET['registered'];
if (isset($_GET['fresh'])) {
    $fresh = $_GET['fresh'];
}
if (isset($_GET['deregistered'])) {
    $deregistered = $_GET['deregistered'];
}
if (isset($_GET['alreadyregistered'])) {
    $alreadyregistered = $_GET['alreadyregistered'];
}
if (isset(($_COOKIE['user_id']))) {
    $user_id = $_COOKIE['user_id'];
}
if (isset(($_COOKIE['user_id']))) {
    $user_id = $_COOKIE['user_id'];
}

$sql2 = "SELECT * FROM event_master WHERE event_id = $event_id ";
$res2 = mysqli_query($conn, $sql2);

if (isset($user_id)) {
    $sql3 = "SELECT * from event_transaction where event_id = $event_id and user_id=$user_id ";
    $res3 = mysqli_query($conn, $sql3);
}
$event = $res2->fetch_assoc();
$event_mode = "offline";
if ($event['event_mode'] == 1) {
    $event_mode = "online";
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $event['event_name'] ?></title>
    <link rel="stylesheet" href="./landingPage/event.css">
    <link href="./assets/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://kit.fontawesome.com/9e94008e0e.js" crossorigin="anonymous"></script>

    <!-- Sweet Alert -->
    <link type="text/css" href="./vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

    <link rel="stylesheet" href="./volt/css/volt.css">
    <style>
    </style>

<body class="container-fluid">
    <header>
        <div class="container-fluid">
            <?php require_once './landingPage/topnav.php'; ?>
        </div>
    </header>
    <br><br>
    <div class="container mt-5 mb-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10">
                <div class="card">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="images p-3">
                                <div class="text-center p-4">
                                    <img id="main-image" class=" main-image" src="./eventManager/<?php echo $event['event_image_url'] ?>" />
                                </div>
                                <!-- <div class="thumbnail text-center"> <img onclick="change_image(this)" src="https://i.imgur.com/Rx7uKd0.jpg" width="70"> <img onclick="change_image(this)" src="https://i.imgur.com/Dhebu4F.jpg" width="70"> </div> -->
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="product p-4">
                                <div class="d-flex justify-content-between align-items-center">

                                    <div class="d-flex align-items-center btn p-0 " id="backbutton">
                                        <i class="fa fa-long-arrow-left mb-2 mr-2"> </i>
                                        <h5 class="ml-2"> Back</h5>

                                    </div>

                                </div>
                                <div class="mt-3 mb-3">
                                    <!-- <span class="text-uppercase text-muted brand">Orianz</span> -->
                                    <h5 class="text-uppercase"><?= $event['event_name'] ?></h5>
                                    <div class="price d-flex flex-row align-items-center">
                                        <span class="act-price">Rs.<?= $event['event_price'] ?></span>
                                    </div>
                                    <div class="price d-flex flex-row align-items-center mb-0">
                                        <!-- <div class="ml-2"> -->
                                        <?php echo date_format(date_create($event['event_date']), "M d"); ?> | <?= $event['event_start_time'] ?> to <?= $event['event_end_time'] ?>
                                        <!-- </div> -->
                                    </div>
                                </div>
                                <p class="about"><?= $event['event_description'] ?></p>
                                <div class="sizes mt-3">
                                    <h6 class="text-uppercase">Mode of event: <?= $event_mode ?></h6>
                                    <h6>Venue: <?= $event['event_venue'] ?></h6>
                                    <!-- <label class="radio"> <input type="radio" name="size" value="S" checked> <span>S</span> </label> <label class="radio"> <input type="radio" name="size" value="M"> <span>M</span> </label> <label class="radio"> <input type="radio" name="size" value="L"> <span>L</span> </label> <label class="radio"> <input type="radio" name="size" value="XL"> <span>XL</span> </label> <label class="radio"> <input type="radio" name="size" value="XXL"> <span>XXL</span> </label> -->
                                </div>
                                <div class="cart mt-4 align-items-center">

                                    <?php
                                    if (isset($user_id)) {
                                        $row = $res3->fetch_assoc();
                                        if (isset($inqueue)) {
                                            if ($inqueue == 1) {
                                                echo "<button class='btn btn-info text-uppercase mr-2 px-4' disabled>In Queue</button>";
                                            } elseif ($inqueue == 0) {
                                                echo "<button class='btn btn-danger text-uppercase mr-2 px-4' id='Alert' disabled>Already Registered</button>";
                                            }
                                        } elseif (isset($registered)) {
                                            if ($registered == 1) {
                                                echo "<button class='btn btn-danger text-uppercase mr-2 px-4' onclick = 'deregister($trans_id)' >Deregister</button>";
                                            } elseif ($registered == 0 and $res3->num_rows == 0) {
                                                echo "<button class='btn btn-danger text-uppercase mr-2 px-4' id='Alert'>Register</button>";
                                            } elseif ($registered == 0 and $res3->num_rows > 0) {
                                                if ($row['in_event'] == 1) {
                                                    echo "<button class='btn btn-danger text-uppercase mr-2 px-4' id='Alert' disabled>Already Registered</button>";
                                                } elseif ($row['in_event'] == 0) {
                                                    echo "<button class='btn btn-info text-uppercase mr-2 px-4' disabled>In Queue</button>";
                                                }
                                            }
                                        } else {
                                            echo "<button class='btn btn-danger text-uppercase mr-2 px-4' id='Alert'>Register</button>";
                                        }
                                    } else {
                                        echo "<button class='btn btn-danger text-uppercase mr-2 px-4' id='Alert'>Register</button>";
                                    }

                                    // <!-- echo "<button class='btn btn-info text-uppercase mr-2 px-4' disabled>In Queue</button>"; -->
                                    // <!-- echo "<button class='btn btn-danger text-uppercase mr-2 px-4' id='Alert' disabled>Already Registered</button>"; -->
                                    // <!-- echo "<button class='btn btn-danger text-uppercase mr-2 px-4' id='Alert'>Register</button>"; -->
                                    // <!-- echo "<button class='btn btn-danger text-uppercase mr-2 px-4' onclick = 'deregister($trans_id)' >Deregister</button>"; -->

                                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                                        $url = "https://";
                                    else
                                        $url = "http://";
                                    // Append the host(domain name, ip) to the URL.   
                                    $url .= $_SERVER['HTTP_HOST'];
                                    $url.= urlencode("/event.php?eventid=" . $event_id);
                                    $postTitle = urlencode("Hi everyone, please check this event out:");
                                    $wap = $postTitle . $url;
                                    echo " <a href='https://www.facebook.com/sharer.php?u=$url' target='_blank'><i class=' mt-2 fab fab fa-facebook text-muted' aria-hidden='true'></i></a>";
                                    // echo "<a href='https://www.linkedin.com/shareArticle?url=$url&title=${postTitle}' target='_blank'><i class='fab fa-linkedin text-muted' aria-hidden='true'></i></a>";
                                    echo "<a href='https://wa.me/?text=${wap}' target='_blank'><i class='fab fa-whatsapp text-muted' aria-hidden='true'></i></a>";
                                    echo "<a href='https://twitter.com/share?url=${url}&text=${postTitle}' target='_blank'><i class='fab fa-twitter text-muted' aria-hidden='true'></i></a>";
                                    
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="./assets/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Sweet Alerts 2 -->
    <script src="./vendor/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
    <script>
        document.getElementById("backbutton").onclick = function() {
            history.back(-1);
        };


        <?php if ($registered == 1) {
            echo "
        function deregister(transaction_id) {
            Swal.fire({
                icon: 'error',
                title: 'Are you sure?',
                text: 'Are you sure you want to deregister for this event?',
                showCancelButton: true,
                confirmButtonColor: '#FF0000',
                confirmButtonText: 'Yes, deregister it!',
                cancelButtonText: 'No, cancel!'
            }).then((result) => {
                if (result.isConfirmed) {
                    location.href = './landingPage/deregisterevent.php?event_id=$event_id&transaction_id=$trans_id';
                }
            });
        };";
        } else {
            $name = $_COOKIE['name'];

            $loggedin = 0;
            if ($user_id) {
                $loggedin = 1;
            }
            echo "document.getElementById('Alert').onclick =  function() {
                if ($loggedin) {
                    window.location.href = '/landingPage/registerevent.php?event_id=$event_id&user_id=$user_id';
    
                } else {
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Please sign in to register for this event!',
                    }).then((result) => {
                        
                            window.location.href = './login/login.php';
                    
                    });
                }
            };
            ";
        }
        if (isset($fresh)) {
            if ($fresh == 1) {
                echo "Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'You have registered for this event!',
                showCancelButton:false,
                showConfirmButton: false ,
                timer:3000

            }).then((result) =>{
                location.href = '/';
            })
            
            ";
            }
        }
        if (isset($deregistered)) {
            if ($deregistered == 1) {
                echo "Swal.fire({
                icon: 'success',
                title: 'Success',
                text: 'You have deregistered for this event!',
                showConfirmButton: false,
                showCancelButton:false,
                timer:3000
            }).then((result) => {
                location.href = '/';
            });";
            }
        }
        if (isset($alreadyregistered)) {
            if ($alreadyregistered == 1) {
                echo "Swal.fire({
                icon: 'error',
                title: 'Error',
                text: 'You have already registered for this event!',
                showConfirmButton: false,
                showCancelButton:false,
                timer:3000
            }).then((result) => {
                location.href = '/';
            });";
            }
        }
        ?>
    </script>
    <footer class="mt-7">
        <?php require_once "./landingPage/footer.php"; ?>
    </footer>
</body>

</html>