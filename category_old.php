<?php 
    require_once "util.php"; 
    require_once "functions.php";

    if(isset($_COOKIE['user_id'])){
        $user_id = $_COOKIE['user_id'];
    }
    else{
        $user_id = 0;
    }
    if(isset($_GET['category_id'])){
        $category_id = $_GET['category_id'];
        $category_name = getCategoryName($mysqli,$category_id);
    }
    else{
        $category_id = NULL;
    }
    $sql = "SELECT category_id,category_name FROM category_master WHERE effective_end_dt IS NULL";
    $categories = mysqli_query($conn, $sql);

?> 

<!doctype html>
<html>
    <head>
        <meta charset='utf-8'>
        <meta name='viewport' content='width=device-width, initial-scale=1'>
        <title>Category</title>
        <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'>
        <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
        <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
        <link href="category.css" rel="stylesheet">
        </head>
        <body oncontextmenu='return false' class='snippet-body'>

        <?php require_once "navbar.php";?>
        <br><br><br><br><br>
        <!-- Navbar section -->
<div class="filter"> <button class="btn btn-default" type="button" data-toggle="collapse" data-target="#mobile-filter" aria-expanded="true" aria-controls="mobile-filter">Filters<span class="fa fa-filter pl-1"></span></button>
</div>
<?php

?>
<div id="mobile-filter">
    <p class="pl-sm-0 pl-2"> Home | <b>All Breads</b></p>
    <div class="border-bottom pb-2 ml-2">
        <h4 id="burgundy">Filters</h4>
    </div>
    <div class="py-2 border-bottom ml-3">
        <h6 class="font-weight-bold">Categories</h6>
        <div id="orange"><span class="fa fa-minus"></span></div>
        <form>
            <?php  ?>
            <div class="form-group"> <input type="checkbox" id="artisan"> <label for="artisan">Music</label> </div>
            <div class="form-group"> <input type="checkbox" id="artisan"> <label for="artisan">Music</label> </div>
        </form>
    </div>
</div>
<!-- Sidebar filter section -->
<section id="sidebar">
    <div class="border-bottom pb-2 ml-2">
        <h4 id="burgundy" style="color: #4154F1 !important;">Filters</h4>
    </div>
    <div class="py-2 border-bottom ml-3">
        <input type="hidden" id="category_id" value="<?=$category_id?>">
        <input type="hidden" id="user_id" value="<?=$user_id?>">
        <input type="hidden" id="mode_id" value="2">

        <h6 class="font-weight-bold">Categories</h6>
        <div id="orange"><span class="fa fa-minus"></span></div>
        <form>
            <?php
                while ($category = $categories->fetch_assoc()) {
            ?>

            <div class="form-group"> 
                <input type="radio" name="category_filter" value="<?=$category['category_id']?>" id="category<?=$category['category_id']?>" onclick="getEvents(<?=$category['category_id']?>,2)"> 
                <label for="artisan"><?= $category['category_name']?></label> 
            </div>
            
            <?php } ?>
        </form>
    </div>
    <div class="py-2 border-bottom ml-3">
        <h6 class="font-weight-bold">Event Mode</h6>
        <div id="orange"><span class="fa fa-minus"></span></div>
        <form>
        <div class="form-group"> 
            <input name="event_mode" type="radio" id="online" onclick="getEvents(<?=$category_id?>,0,0)">
            <label for="online">Online</label>
        </div>
        
        <div class="form-group"> 
            <input name="event_mode" type="radio" id="offline" onclick="getEvents(<?=$category_id?>,1,0)">
            <label for="offline">Offline</label>
        </div>
        <div class="form-group"> 
            <input name="event_mode" type="radio" id="all_mode" onclick="getEvents(<?=$category_id?>,2,0)">
            <label for="all_mode">All</label>
        </div>
        
        </form>
    </div>
</section>
<!-- products section -->
<section id="products">
    <div class="container">
        <div class="d-flex flex-row">
            <div class="text-muted m-2" id="res">Showing filtered events</div>
            <div class="ml-auto mr-lg-4">
                <!-- <h3 id="category_name_heading"><?=$category_name?></h3> -->
            </div>
            <div class="ml-auto mr-lg-4">
                <div id="sorting" class="border rounded p-1 m-1"> <span class="text-muted">Sort by</span> <select name="sort" id="sort">
                        <option value="rating" onclick="getEvents(<?=$category_id?>,0,0)"><b>Name</b></option>
                        <option value="popularity" onclick="getEvents(<?=$category_id?>,0,1)"><b>Popularity</b></option>
                        <option value="prcie" onclick="getEvents(<?=$category_id?>,0,2)"><b>Price</b></option>
                    </select> </div>
            </div>
        </div>
        <div class="row">
            <section class="light">
                <div class="container py-2" id="cards_div">
                    <!-- <div class="h1 text-center text-dark" id="pageHeaderTitle">My Cards Light</div> -->
                    <!-- AJAX response is appended here -->
                </div>
            </section>
        </div>
    </div>
</section>
        <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>
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
  <script>
  
  var category_id = document.getElementById("category_id").value;
  function getEvents(str,mode,order) {
    if (str === "") {
        document.getElementById("txtHint").innerHTML = "";
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("cards_div").innerHTML = this.responseText;
                document.getElementById("mode_id").value = mode;
                document.getElementById("category_id").value = str;
                category_id = str;
                document.getElementById("category"+str).checked = true;
            }
        };
        xmlhttp.open("GET", "category_ajax.php?c_id="+str+"&mode="+ mode+"&order="+ order, true);
        console.log(str+" "+mode);
        xmlhttp.send();
    }
}
  function like(user_id,event_id,is_liked) {

    if (user_id == "0") {
        // document.getElementById("txtHint").innerHTML = "";
        alert("Please login to like this event");
        location.href = "/login/login.php?redrurl="+location.href;  
        return;
    } else {
        if (window.XMLHttpRequest) {
            // code for IE7+, Firefox, Chrome, Opera, Safari
            xmlhttp = new XMLHttpRequest();
        } else {
            // code for IE6, IE5
            xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
        }
        xmlhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                document.getElementById("itag"+event_id).innerHTML = this.responseText;
            }
        };
        xmlhttp.open("GET", "like_ajax.php?user_id="+user_id+"&event_id="+event_id+"&is_liked="+is_liked, true);
        xmlhttp.send();
        
    }
    
}
</script>
<script>
    document.onload = getEvents(<?= $category_id?>,'2',0);
    document.getElementById("all_mode").checked = true;
</script>
        </body>
    </html>