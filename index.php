<?php
// opcache_reset();
require_once 'util.php';

if (isset($_COOKIE['user_id'])) {
  $user_id = $_COOKIE['user_id'];
}
// $user_id= 1;

// $sql1 = "SELECT * FROM category_master WHERE effective_end_dt IS NULL";
// $res1 = mysqli_query($conn, $sql1);

// $sql2 = "SELECT * FROM event_master WHERE event_approved = 1 AND effective_end_date IS NULL";
// $res2 = mysqli_query($conn, $sql2);

// $sql4 = "SELECT * FROM category_master WHERE effective_end_dt IS NULL";
// $categories = mysqli_query($conn, $sql4);



// $categories = $res1->fetch_assoc();
$sql1 = "SELECT COUNT(*) as count FROM event_master WHERE event_approved = 1 AND effective_end_date IS NULL";
$res1 = mysqli_query($conn, $sql1);
$result1 = $res1->fetch_object();

$sql2 = "SELECT COUNT(*) as count FROM order_master";
$res2 = mysqli_query($conn, $sql2);
$result2 = $res2->fetch_object();

$sql3 = "SELECT COUNT(*) as count FROM event_likes";
$res3 = mysqli_query($conn, $sql3);
$result3 = $res3->fetch_object();

$sql4 = "SELECT COUNT(*) as count FROM user_master WHERE effective_end_dt IS NULL";
$res4 = mysqli_query($conn, $sql4);
$result4 = $res4->fetch_object();


?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta content="width=device-width, initial-scale=1.0" name="viewport">
  
  <title>Event Management</title>


  <style>
    html {
  scroll-behavior: smooth;
}
    .card-img-top {
    width: 100%;
    height: calc(130px + 5vw)!important;
    object-fit: cover;
}
#slideLeft,#slideRight{
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
#slideLeft i{
  position: absolute;
  left: -10;
  top: 30%;
  color: #4154F1;
}
#slideLeft{
  left: 0;
}
#slideRight{
  right: 0;
}
#slideRight i{
  position: absolute;
  right: -10;
  top: 30%;
  color: #4154F1;
}
#content{
  margin: 20px;
}
@media (min-width:992px){
#content > .col-lg-3 {
  width: 24%;
}
}
/* .load-more:hover{
    cursor: pointer;
} */
  </style>
<link rel="stylesheet" href="./vendor/sweetalert2/dist/sweetalert2.min.css">
</head>

<body onload="updateCartNav()">

  <main id="main">
    <?php require_once "navbar.php"; ?>
    <!-- ======= Hero Section ======= -->
    <section id="hero" class="hero d-flex align-items-center">

      <div class="container">
        <div class="row">
          <div class="col-lg-6 d-flex flex-column justify-content-center">
            <h1 data-aos="fade-up">Finserv EVENTS</h1>
            <h2 data-aos="fade-up" data-aos-delay="400">Your All in One Event Booking Partner.<br />Book your Favorite Events Today.</h2>
            <div data-aos="fade-up" data-aos-delay="600">
              <div class="text-center text-lg-start">
                <a style="background:#012970;" href="#categories" class="btn-get-started scrollto d-inline-flex align-items-center justify-content-center align-self-center">
                  <span>Get Started</span>
                  <i class="bi bi-arrow-right"></i>
                </a>
              </div>
            </div>
          </div>
          <div class="col-lg-6 hero-img" data-aos="zoom-out" data-aos-delay="200">
            <img src="assets/img/home.webp" class="img-fluid" alt="">
          </div>
        </div>
      </div>

    </section><!-- End Hero -->

    <!-- ======= Counts Section ======= -->

    <section id="counts" class="counts">
      <div class="container" data-aos="fade-up">
        <header class="section-header">
          <p>HIGHLIGHTS</p>
          <br>
          <!-- <h2>Event Categories</h2>
          <p>Browse through the event categories here</p> -->
        </header>
        <div class="row gy-4" id="count_div">

          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="count-box">
              <i class="bi bi-list-ol"></i>
              <div>
                <?php ?>
                <span data-purecounter-start="0" data-purecounter-end="<?= $result1->count ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Total Events</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="count-box">
              <i class="bi bi-calendar-week" style="color: #ee6c20;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?= $result2->count ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Total Bookings</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="count-box">
              <i class="bi bi-heart" style="color: red;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?= $result3->count ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Total Likes</p>
              </div>
            </div>
          </div>

          <div class="col-lg-3 col-md-6 col-sm-6 col-xs-6">
            <div class="count-box">
              <i class="bi bi-people" style="color: #bb0852;"></i>
              <div>
                <span data-purecounter-start="0" data-purecounter-end="<?= $result4->count ?>" data-purecounter-duration="1" class="purecounter"></span>
                <p>Total Users</p>
              </div>
            </div>
          </div>

        </div>

      </div>
    </section><!-- End Counts Section -->

    <!-- ======= Categories Section ======= -->
    <section id="categories" class="categories" style="padding-top:0;">

      <div class="container-fluid" data-aos="fade-up">

        <header class="section-header">
          <p>EVENT CATEGORIES</p>
          <br>
          <!-- <h2>Event Categories</h2>
          <p>Browse through the event categories here</p> -->
        </header>

        <div class="row flex-row flex-nowrap m-0 py-3 px-3" id="content"  style="overflow-x:scroll !important; ">
        <!-- <button id="slideLeft" type="button"><i class="bi bi-chevron-left"></i></button>
        <button id="slideRight" type="button"><i class="bi bi-chevron-right"></i></button> -->
        <?php
            $rowperpage = 5;
            // counting total number of posts
            $allcount_query = "SELECT count(*) as allcount FROM category_master WHERE effective_end_dt is NULL";
            $allcount_result = mysqli_query($conn,$allcount_query);
            $allcount_fetch = mysqli_fetch_array($allcount_result);
            $allcount = $allcount_fetch['allcount'];

            // select first 5 posts
            $query = "SELECT * FROM category_master WHERE effective_end_dt is NULL ORDER BY category_name LIMIT 0,$rowperpage";
            $result = mysqli_query($conn,$query);

            while ($category = $result->fetch_assoc()) {
            ?>
          <div class="col-lg-3 col-md-5 col-sm-6 col-10 post" id="post" data-aos="fade-up" data-aos-delay="200" >
          
          <a class="text-center" href="category.php?category_id=<?=$category['category_id'] ?>" style="color:black;">
          <div class="box shadow p-0">
              <img src="admin/<?= $category['category_image'] ?>" class="mb-3 p-2 img-fluid card-img-top">
              <h4 class=" my-3 "><?= $category['category_name'] ?></h4>
              <p class="mx-4 " style="word-wrap: break-word;" ><?= $category['category_description'] ?></p>
            </div>
            </a>

          </div>
            <?php } ?>
            <h2 type="hidden" class="load-more" style="width: auto;"></h2>
            <input type="hidden" id="row" value="0">
            <input type="hidden" id="all" value="<?= $allcount ?>">
        

      </div>

    </section><!-- End Categories Section -->

    <!-- ======= Features Section ======= -->
    <section id="features" class="features pt-0">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <p>FEATURES</p>
          <!-- <p>Explore various events from the comfort of your home</p> -->
        </header>

        <div class="row">

          <div class="col-lg-6">
            <img src="assets/img/features.png" class="img-fluid" alt="">
          </div>

          <div class="col-lg-6 mt-5 mt-lg-0 d-flex">
            <div class="row align-self-center gy-4">

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="200">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <!-- <h3>Regular Updates</h3> -->
                  <h3>Events From Top Artists Across The Globe</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="300">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <!-- <h3>Filter Various Events</h3> -->
                  <h3>Browse Across Various Categories</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="400">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <!-- <h3>Mobile Friendly Interface</h3> -->
                  <h3>Filter Various Events</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="500">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Hassle-Free Booking Process</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="600">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>Integrated Calendar View for Booked Events</h3>
                </div>
              </div>

              <div class="col-md-6" data-aos="zoom-out" data-aos-delay="700">
                <div class="feature-box d-flex align-items-center">
                  <i class="bi bi-check"></i>
                  <h3>24/7 Customer Support</h3>
                </div>
              </div>

            </div>
          </div>

        </div> <!-- / row -->
    </section>

    <!-- ======= Contact Section ======= -->
    <section id="contact" class="contact pt-0 text-center">

      <div class="container" data-aos="fade-up">

        <header class="section-header">
          <!-- <h2>Contact</h2> -->
          <p>CONTACT US</p><br />
        </header>


        <div class="row gy-4">

          <div class="col-lg-6">

            <div class="row gy-4">
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-geo-alt"></i>
                  <h3>Address</h3>
                  <p>Smartworks Pune<br>Maharashtra</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-telephone"></i>
                  <h3>Call Us</h3>
                  <p>+91 9988008877<br>+91 8877997766</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-envelope"></i>
                  <h3>Email Us</h3>
                  <p>events@bajajfinserv.in<br>outreach@bajajfinserv.in</p>
                </div>
              </div>
              <div class="col-md-6">
                <div class="info-box">
                  <i class="bi bi-clock"></i>
                  <h3>Open Hours</h3>
                  <p>Monday - Friday<br>9:00AM - 05:00PM</p>
                </div>
              </div>
            </div>

          </div>

          <div class="col-lg-6">
            <form action="forms/contact.php" method="post" class="php-email-form" style="background-color: white;">
              <div class="row gy-4">
                <img src="assets/img/contact_us.webp" height="100%">
              </div>
            </form>

          </div>

        </div>

      </div>

    </section><!-- End Contact Section -->


  </main><!-- End #main -->

  <script>
    $(document).ready(function(){

      const myDiv = document.getElementById('content')  
      myDiv.addEventListener('scroll', () => {  
        if (myDiv.offsetWidth + myDiv.scrollLeft >= myDiv.scrollWidth) {  
          var row = Number($('#row').val());
    var allcount = Number($('#all').val());
    var rowperpage = 5;
    row = row + rowperpage;
    if(row <= allcount){
        $("#row").val(row);
        $.ajax({
            url: 'category_loadmore.php',
            type: 'post',
            data: {row:row},
            beforeSend:function(){
                $(".load-more").html('<div class="spinner-border" style="margin-top: 150px;width: 3rem; height: 3rem;" role="status"></div>');
            },
            success: function(response){
                // Setting little delay while displaying new content
                setTimeout(function() {
                    // appending posts after last post with class="post"
                    $(".post:last").after(response).show().fadeIn("slow");
                    var rowno = row + rowperpage;
                    // checking row value is greater than allcount or not
                    if(rowno > allcount){
                        // Change the text and background
                        $('.load-more').text("");
                        // $('.load-more').css("background","darkorchid");
                        return;
                    }else{
                        // $(".load-more").text("Load more");
                    }
                }, 500);
            }
        });
    }else{
    }
        }  
      })

// Load more data
$('.load-more').click(function(){
    

});

});
  </script>

  <!-- ======= Footer ======= -->
  <?php include("footer.php"); ?>

  <a href="#" class="back-to-top d-flex align-items-center justify-content-center"><i class="bi bi-arrow-up-short"></i></a>

  <!-- Vendor JS Files -->
  <script src="assets/vendor/purecounter/purecounter.js"></script>
  <script src="assets/vendor/aos/aos.js"></script>
  <script src="assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
  <script src="assets/vendor/glightbox/js/glightbox.min.js"></script>
  <script src="assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
  <script src="assets/vendor/swiper/swiper-bundle.min.js"></script>
  <script src="assets/vendor/php-email-form/validate.js"></script>

  <!-- Template Main JS File -->
  <script src="assets/js/main.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/11.4.4/sweetalert2.min.js" integrity="sha512-vDRRSInpSrdiN5LfDsexCr56x9mAO3WrKn8ZpIM77alA24mAH3DYkGVSIq0mT5coyfgOlTbFyBSUG7tjqdNkNw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>

  <script>
    
    // var button = document.getElementById('slideRight');
    //       button.onclick = function () {
    //           var container = document.getElementById('content');
    //           scrollAmount = 0;
    //           var slideTimer = setInterval(function(){
    //               container.scrollLeft += 30;
    //               scrollAmount += 10;
    //               if(scrollAmount >= 100){
    //                   window.clearInterval(slideTimer);
    //               }
    //           }, 25);
    //       };

    // var back = document.getElementById('slideLeft');
    // back.onclick = function () {
    //     var container = document.getElementById('content');
    //     scrollAmount = 0;
    //     var slideTimer = setInterval(function(){
    //         container.scrollLeft -= 30;
    //         scrollAmount += 10;
    //         if(scrollAmount >= 100){
    //             window.clearInterval(slideTimer);
    //         }
    //     }, 25);
    // };
  </script>

</body>

</html>