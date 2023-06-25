<?php
require_once '../config.php';
require_once '../functions.php';
// require_once "popularEvents.php";



// session_start();
$event_id = $_GET['eventid'];
$_SESSION['eventid'] = $event_id;
if (isset(($_COOKIE['user_id']))) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = 0;
}

$sql2 = "SELECT * FROM event_master WHERE event_id = $event_id ";
$res2 = mysqli_query($conn, $sql2);

$event = $res2->fetch_assoc();
$_SESSION['fname'] = $event['event_extended_desc'];
$event_mode = "offline";
if ($event['event_mode'] == 1) {
    $event_mode = "online";
}
$original_price = $event['event_price'];
$discount_price = $event['discounted_price'];

$sql5 = "SELECT 
event_id, event_name,event_description,event_image_url, 
(SELECT COUNT(*)
        FROM event_likes 
        WHERE event_likes.event_id = event_master.event_id) like_count
FROM event_master 
WHERE 
effective_end_date IS NULL AND event_approved = 1 AND category_id = $event[category_id]
ORDER BY like_count DESC,event_name ASC";
$events = mysqli_query($conn, $sql5);

$sql4 = "SELECT category_name from category_master where category_id = $event[category_id]";
$res4 = mysqli_query($conn, $sql4);
$category = $res4->fetch_assoc();

$no_of_count = 0;
if ($user_id != 0) {
    $sql5 = "SELECT no_of_tickets from cart where user_id = $user_id AND event_id = $event_id";
    $res5 = mysqli_query($conn, $sql5);
    $count  = mysqli_num_rows($res5);
    if ($count == 0) {
        $no_of_count = 0;
    } else {
        $initial_count = $res5->fetch_assoc();
        $no_of_count = intval($initial_count['no_of_tickets']);
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width">
    <!-- displays site properly based on user's device -->

    <link rel="icon" type="image/png" sizes="32x32" href="./images/favicon-32x32.png">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

    <title><?= $event['event_name'] ?></title>
    <!-- <meta name="description" content="E-commerce product page."> -->

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>

    <style>
        .card-img-top {
            width: 100%;
            height: calc(150px + 5vw);
            object-fit: cover;
        }

        #slideLeft,
        #slideRight {
            /* padding: 10px; */
            background-color: rgba(255, 255, 255, 0.8);
            /* margin: -20px; */
            position: absolute;
            top: 40%;
            width: 50px;
            height: 30%;
            font-size: 4rem;
            z-index: 100;
            border: none;
        }

        #slideLeft i {
            position: absolute;
            left: -10;
            top: 600px;
            color: #4154F1;
        }

        #slideLeft {
            left: 0;
        }

        #slideRight {
            right: 0;
        }

        #slideRight i {
            position: absolute;
            right: -10;
            top: 600px;
            color: #4154F1;
        }

        #content {
            margin: 20px;
        }
    </style>

    <!-- About Event CSS -->
    <link href="https://fonts.googleapis.com/css2?family=Cinzel&display=swap" rel="stylesheet">

    <style>
        .aboutbtn {
            width: 50vw;
            height: 50px;
            border: 2px solid #6065EC;
            /* font-family: 'Cinzel', serif; */
            font-size: 20px;
            cursor: pointer;
            -webkit-tap-highlight-color: transparent;
            display: flex;
            align-items: center;
            justify-content: center;
            position: absolute;
            left: 25%;
            z-index: 0;
            transition: 1s;
        }

        .aboutbtn::before,
        .btn::after {
            position: absolute;
            background: #fff;
            z-index: -1;
            transition: 2s;
            content: '';
        }

        .aboutbtn::before {
            height: 50px;
            width: 48vw;
        }

        .aboutbtn::after {
            width: 150px;
            height: 30px;
        }

        .noselect {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }

        .aboutbtn:hover::before {
            width: 0px;
            background: #fff;
        }

        .aboutbtn:hover::after {
            height: 0px;
            background: #fff;
        }

        .aboutbtn:hover {
            background: #fff;
        }

        body {
            margin-top: 10%;
            /* padding-bottom: 10%; */
        }

        .mobileHide {
            display: block;
        }

        .mobileShow {
            display: none;
        }

        @media(max-width:575px) {
            .mobileHide {
                display: none;
            }

            .mobileShow {
                display: block;
            }
        }
    </style>

    <!-- Extended Description -->
    <style>
        .extended_description {
            color: #012970;
            font-size: 14px;
            background-size: 20px 20px;
            background-position: 2px;
            padding: 5px;
            border-radius: 5px 5px 5px;
            border: 1px solid #012970;
            display: flex;
            text-align: center;
            justify-content: center;
        }
    </style>



    <link rel="stylesheet" href="./css/app.css">
    <link rel="stylesheet" href="divider.css">
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <!-- Favicons -->
    <link href="../assets/img/favicon.png" rel="icon">
    <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

    <!-- Vendor CSS Files -->
    <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

    <!-- Template Main CSS File -->
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<?php require_once '../navbar.php'; ?>
<div>
    <br><br><br>
</div>

<body style="background-color: #fff;" onload="getlikes(<?= $event_id ?>,<?= $user_id ?>);updateCartNav();">

    <div>
        <main>

            <div class="sm:max-w-lg md:max-w-xl lg:max-w-6xl mx-auto lg:px-6 sm:pt-2 lg:pt-10 lg:flex md:mt-3">

                <div class="lg:w-1/2 block lg:flex flex-col justify-center  lg:relative lg:top-1">

                    <div x-data="{open: false}">

                        <div class="w-full lg:pl-10 lg:pr-16  ">
                            <div x-data="{ activeSlide: 1, slides: [1] }">
                                <div class="relative">
                                    <!-- Slides -->
                                    <div class="aspect-w-5 aspect-h-4 lg:aspect-w-1 lg:aspect-h-1 ">
                                        <template x-for="slide in slides" :key="slide">
                                            <div x-show="activeSlide === slide" x-transition>
                                                <div class="aspect-w-5 aspect-h-4 lg:aspect-w-1 lg:aspect-h-1">
                                                    <picture>
                                                        <source srcset="../eventManager/<?php echo $event['event_image_url'] ?>" type="image/webp">
                                                        <img src="../eventManager/<?php echo $event['event_image_url'] ?>" class="object-cover sm:rounded-2xl w-full h-full" alt="" width="448" height="448" @click.prevent="open = true">
                                                    </picture>
                                                </div>
                                            </div>
                                        </template>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div x-show="open=false" x-cloak x-transition.opacity @keyup.escape.window="open = false" class="p-4 fixed flex justify-center items-center inset-0 bg-black bg-opacity-75 z-50">
                            <div>
                                <div class="relative">
                                    <div x-data="{ activeSlide: 1, slides: [1] }">
                                        <div class="relative lightbox-slides">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    if (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')
                        $url = "https://";
                    else
                        $url = "http://";
                    // Append the host(domain name, ip) to the URL.
                    $url .= $_SERVER['HTTP_HOST'];
                    $url .= urlencode("/event/index.php?eventid=" . $event_id);
                    $postTitle = urlencode("Hi everyone, please check this event out:");
                    $wap = $postTitle . $url;
                    echo "<div class='text-center text-3xl pt-4'>";
                    echo " <a href='https://www.facebook.com/sharer.php?u=$url' target='_blank'><i class=' mr-4 mt-2 bi bi-facebook text-muted' aria-hidden='true'></i></a>&nbsp;&nbsp;";
                    // echo "<a href='https://www.linkedin.com/shareArticle?url=$url&title=${postTitle}' target='_blank'><i class='fab fa-linkedin text-muted' aria-hidden='true'></i></a>";
                    echo "<a href='https://wa.me/?text=${wap}' target='_blank'><i class='bi bi-whatsapp text-muted mr-4' aria-hidden='true'></i></a>&nbsp; ";
                    echo "<a href='https://twitter.com/share?url=${url}&text=${postTitle}' target='_blank'><i class='bi bi-twitter text-muted' aria-hidden='true'></i></a>";
                    echo "</div>"
                    ?>
                    <hr class="mobileShow">
                </div>

                <div class="lg:w-1/2 p-6 lg:pt-16 lg:pl-16 lg:pr-10 lg:relative lg:top-1 pt-0">

                    <div class=" mb-3 lg:mb-10 d-flex">
                        <h1 class="font-bold text-3xl lg:text-5xl mr-auto"><?= $event['event_name'] ?> </h1>

                        <h2 class=" text-2xl lg:text-4xl" id="heart" onclick="likeunlike(<?= $event['event_id'] ?>,<?= $user_id ?>)"><i class="bi bi-heart-fill" style="cursor:pointer;"></i></h2>
                        &nbsp;
                        <p class="" id="count">0</p>

                    </div>
                    <p class="font-bold uppercase tracking-widest text-xs mb-4" style="color: #012970; font-size:1.5em"><?= $category['category_name'] ?></p>
                    <!-- <h4 class="text-gray-500 mb-2 lg:mb-3"><?php echo date_format(date_create($event['event_date']), "M d"); ?> | <?= date_format(date_create($event['event_start_time']), "H:i"); ?> to <?= date_format(date_create($event['event_end_time']), "H:i"); ?> </h4> -->

                    <i class="bi bi-calendar">
                        <?php echo date_format(date_create($event['event_date']), 'M d, Y') ?>
                    </i> <br>
                    <i class="bi bi-clock">
                        <?= date('h:i a', strtotime($event['event_start_time'])) ?>
                        <?php echo 'to' ?>
                        <?= date('h:i a', strtotime($event['event_end_time'])) ?>

                    </i> <br>
                    <i class="bi bi-geo-alt">
                        <?php if ($event['event_mode'] == 0) {
                            echo 'Platform: ' . $event['event_venue'];
                        } else {
                            echo 'City: ' . $event['event_venue'];
                        }
                        ?>
                    </i>
                    <br>
                    <i class="bi bi-card-text"></i>
                    Description: <?= $event['event_description'] ?>

                    <div class="mb-0 lg:mb-5 flex items-center lg:flex-col lg:items-start">
                        <p class="flex items-center mb-2 mr-auto mt-3">
                            <span class="font-bold text-3xl" style="color: green; font-size: 40px;">₹<?= $event['discounted_price'] ?></span>
                            <strike>
                                <span class="ml-3" style="color: grey; font-size: 25px; font-weight: 400;" class="font-bold text-3xl mr-4">₹<?= $event['event_price'] ?></span>
                            </strike>
                        </p>

                    </div>
                    <?php
                    if ($event['discount_type'] == 0) {
                        echo 'Special Discount of Flat &#8377;' . $event['discount_price'] . '!';
                    } else if ($event['discount_type'] == 1) {
                        echo 'Special Discount of ' . $event['discount_price'] . '% Off!';
                    }
                    ?>
                    <p class="text-gray-500 mb-3" id="message">Remaining Seats: <b><?php echo ($event['total_seats'] - $event['filled_seats']) ?></b></p>
                    <div id="ajax_div"></div>
                    <div class="d-flex">
                        <i style="font-size: 1.5rem; background: #012970;" class="bi bi-dash-square btn btn-primary" id="increment" onclick="decrement()"></i>
                        <input readonly type="text" style="width: 100px;" class="text-center form-control" id="no_of_items" name="no_of_items" value="<?= $no_of_count ?>">
                        <i style="font-size: 1.5rem; background: #012970;" class="bi bi-plus-square btn btn-primary" onclick="increment()"></i>
                    </div>
                </div>
            </div> <br>

            <section id="categories" class="categories" style="padding-top:0; height:auto">
                <div class="container">

                    <header class="section-header">
                        <p>About this Event</p>
                    </header>
                    <br>
                    <div class="extended_description"><?php require_once './description.php' ?></div>
            </section>

            <!-- ======= Popular Events Section ======= -->
            <div class="popularevents">
                <section id="categories" class="categories" style="padding-top:0;">
                    <div class="container-fluid">

                        <header class="section-header">
                            <p>Popular Events</p>
                            <br>
                        </header>

                        <div class="row flex-row flex-nowrap" id="content" style="overflow-x:scroll !important;">
                            <!-- <button id="slideLeft" type="button"><i class="bi bi-chevron-left"></i></button>
                        <button id="slideRight" type="button"><i class="bi bi-chevron-right"></i></button> -->
                            <?php
                            while ($event = $events->fetch_assoc()) {
                                $event_id_loop = $event['event_id'];
                            ?>
                                <div class="col-lg-3" data-aos="fade-up" data-aos-delay="200" style="padding:20px;">

                                    <a href="index.php?eventid=<?= $event_id_loop ?>" style="color:black;">
                                        <div class="box shadow p-0">
                                            <img src="../eventManager/<?= $event['event_image_url'] ?>" class="img-fluid p-2 mb-3 card-img-top" style="height: calc(130px + 5vw);" alt="IMAGE">
                                            <i class="bi bi-heart-fill mt-3" style="float: right; top:0; color:red; cursor:pointer;">
                                                <sub style="font-size: small;color: black;"><?= getLikeCount($mysqli, $event_id_loop) ?></sub>
                                            </i>
                                            <h3 class="my-3"><?= $event['event_name'] ?></h3>
                                            <p><?= $event['event_description'] ?></p>
                                        </div>
                                    </a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                </section>
            </div>
            <!-- End Popular events Section -->


            <p class="pt-4 container text-center" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 32px;"> Comments Section</p>
            <div class="row pt-3">
                <div class="col-xl-2"></div>
                <div class="col-xl-8">

                    <?php include './comments.php'; ?>
                </div>

            </div>
            <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            <!-- <script src="../vendor/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script> -->
            <script>
                <?php
                if (isset($_COOKIE['user_id'])) {
                    echo "document.getElementById('Alert').onclick = function() {
                        window.location.href = '../landingPage/registerevent.php?event_id=' + $event_id + '&user_id=' + $user_id;}";
                } else {
                    echo "document.getElementById('Alert').onclick = function() {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: 'Please login to book this event!',
                        }).then(function() {
                            window.location.href = '../login/login.php?redrurl='+location.href;
                        })
                }";
                }
                ?>
            </script>
        </main>

        <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
        <script src="../assets/js/main.js"></script>


    </div>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
    <script>
        if (performance.navigation.type == 2) {
            location.reload(true);
        }

        function increment() {
            var number = document.getElementById('no_of_items').value;
            document.getElementById('no_of_items').value = Number(number) + 1;
            addToCart(<?= $user_id ?>, <?= $event_id ?>, document.getElementById('no_of_items').value, <?= $original_price ?>, <?= $discount_price ?>);
        }

        function decrement() {
            var number = document.getElementById('no_of_items').value;
            if (number == 0) {
                return;
            }
            document.getElementById('no_of_items').value = Number(number) - 1;
            addToCart(<?= $user_id ?>, <?= $event_id ?>, document.getElementById('no_of_items').value, <?= $original_price ?>, <?= $discount_price ?>);
        }

        function addToCart(user_id, event_id, no_of_items, original_price, discount_price) {
            // console.log(event_id);
            if (user_id == "0") {
                document.getElementById('no_of_items').value = 0;
                Swal.fire({
                    html: '<iframe height="625" width="375" loading="lazy" id="loginframe" style="margin:0 auto" src="../login/login_modal.php?popup=1" title="Login"></iframe>',
                    showCancelButton: false,
                    showCloseButton: false,
                    showConfirmButton: false,
                    width: 375
                })
                $("#loginframe").on('load', function() { // console.log('loaded');
                    if ($(this).contents()[0].location.pathname == "/login/loginsuccess.php") { // console.log('logged in');
                        setTimeout(function() {
                            location.reload();
                        }, 1500);

                    }

                });
                // document.getElementById("txtHint").innerHTML = "";
                // Swal.fire({
                //             icon: 'error',
                //             title: 'Oops...',
                //             text: 'Please login to book this event!',
                //         }).then(function() {
                //             window.location.href = '../login/login.php?redrurl='+location.href;
                //         })
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function() {
                    if (this.readyState == 4 && this.status == 200) {
                        if (this.responseText == "noSeats") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Not enough seats left!',
                            }).then(function() {})
                            // document.getElementById('no_of_items').value = 0;
                            decrement();
                        } else if (this.responseText == "notLoggedIn") {
                            Swal.fire({
                                icon: 'warning',
                                title: 'Oops...',
                                text: 'Please login to add to the cart!',
                            }).then(function() {
                                window.location.href = '../login/login.php?redrurl=' + location.href;
                            })
                        } else {
                            document.getElementById("no_of_items").value = this.responseText;
                            updateCartNav();
                        }
                    }
                };
                xmlhttp.open("GET", "add_to_cart_ajax.php?user_id=" + user_id + "&event_id=" + event_id + "&no_of_items=" + no_of_items + "&original_price=" + original_price + "&discount_price=" + discount_price);
                xmlhttp.send();

            }

        }

        function getlikes(event_id, user_id = 0) {
            var heart = $('#heart');
            var count = $('#count');
            $.ajax({
                url: './geteventlikes.php',
                type: 'POST',
                data: {
                    event_id: event_id,
                    user_id: user_id
                },
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    count.text(data.likecnt);
                    if (data.is_liked == 1) {
                        heart.css('color', 'red');
                    } else {
                        heart.css('color', 'gray');
                    }
                }

            })

        }


        function likeunlike(eventid, userid = 0) {
            var heart = $('#heart');
            var count = $('#count');
            // console.log(eventid, userid);
            if (userid == 0) {
                Swal.fire({
                    html: '<iframe height="625" width="375" loading="lazy" id="loginframe" style="margin:0 auto" src="../login/login_modal.php?popup=1" title="Login"></iframe>',
                    showCancelButton: false,
                    showCloseButton: false,
                    showConfirmButton: false,
                    width: 375
                })
                $("#loginframe").on('load', function() {
                    if ($(this).contents()[0].location.pathname == "/login/loginsuccess.php") {
                        setTimeout(function() {
                            location.reload();
                        }, 1500);
                    }
                })
                return;
            }
            $.ajax({
                url: 'event-likes.php',
                type: 'POST',
                async: false,
                data: {
                    event_id: eventid,
                    user_id: userid
                },
                dataType: 'json',
                success: function(data) {
                    // console.log(data);
                    count.text(data.likecnt);
                    if (data.is_liked == 1) {
                        heart.css('color', 'red');
                    } else {
                        heart.css('color', 'gray');
                    }

                }
            })

        }
    </script>
    <style>
        .swal2-popup {
            padding: 0;
        }

        .swal2-html-container {
            margin: 0;
        }
    </style>
    <footer class="px-0">
        <?php include("../footer.php"); ?>
    </footer>
</body>

</html>