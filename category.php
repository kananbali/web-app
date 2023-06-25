<?php
require_once "util.php";
require_once "functions.php";

if (isset($_COOKIE['user_id'])) {
    $user_id = $_COOKIE['user_id'];
} else {
    $user_id = 0;
}
if (isset($_GET['category_id'])) {
    $category_id = $_GET['category_id'];
    $category_name = getCategoryName($mysqli, $category_id);
} else {
    $category_id = NULL;
}
$sql = "SELECT category_id,category_name FROM category_master WHERE effective_end_dt IS NULL";
$categories = mysqli_query($conn, $sql);

$sql = 
    "SELECT * 
    FROM event_master 
    WHERE filled_seats < total_seats AND event_approved = 1 AND event_status IS NULL AND category_id = $category_id AND effective_end_date IS NULL";
$result = $mysqli->query($sql);
$count = $result->fetch_assoc();
$allcount  = mysqli_num_rows($result);
?>

<!doctype html>
<html>

<head>
    <meta charset='utf-8'>
    <meta name='viewport' content='width=device-width, initial-scale=1'>
    <title>Category</title>
    <!-- <link href='https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0/css/bootstrap.min.css' rel='stylesheet'> -->
    <link href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css' rel='stylesheet'>
    <script type='text/javascript' src='https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js'></script>
    <link href="./category.css" rel="stylesheet">
    <style>
        #body::-webkit-scrollbar {
            display: none;
        }

        /* Hide scrollbar for IE, Edge and Firefox */
        #body {
        -ms-overflow-style: none;  /* IE and Edge */
        scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>

<?php require_once "navbar.php"; ?>


<body oncontextmenu='return false' class='snippet-body' onload="updateCartNav()" >
<div id="body" style="overflow:auto;height:200vh;width:auto;">
    
    
    <!-- Hidden fields for load more -->
    <input type="hidden" id="row" value="0">
    <input type="hidden" id="all" value="<?= $allcount; ?>">
    <input type="hidden" id="category_id" value="<?= $category_id ?>">
    <input type="hidden" id="user_id" value="<?= $user_id ?>">
    <input type="hidden" id="mode_id" value="2">
    
    <!-- Sidebar filter section -->

    <section id="sidebar">
        <div class="border-bottom pb-2 ml-2">
            <h4 id="burgundy" style="color:#012970 !important;">Filters</h4>
        </div>

        <button type="button" class="collapsible active">
            <h6 class="font-weight-bold">Categories</h6>
            <i class="bi bi-chevron-down"></i>
        </button>
        <!-- <div id="orange"><span class="fa fa-minus"></span></div> -->
        <div class="py-2 border-bottom ml-3" style="display: block;">
            <form>
                <?php
                while ($category = $categories->fetch_assoc()) {
                ?>

                    <div class="form-group">
                        <input type="radio" name="category_filter" value="<?= $category['category_id'] ?>" id="category<?= $category['category_id'] ?>" onclick="getAllCount(<?= $category['category_id'] ?>,document.getElementById('mode_id').value,document.getElementById('order').value,getEvents)">
                        <label for="artisan"><?= $category['category_name'] ?></label>
                    </div>

                <?php } ?>
            </form>
        </div>

        <button type="button" class="collapsible active">
            <h6 class="font-weight-bold">Event Mode</h6>
            <i class="bi bi-chevron-down"></i>
        </button>
        <div class="py-2 border-bottom ml-3" style="display: block;">
            <!-- <h6 class="font-weight-bold">Event Mode</h6>
            <div id="orange"><span class="fa fa-minus"></span></div> -->
            <form>
                <div class="form-group">
                    <input name="event_mode" type="radio" id="online" onclick="getAllCount(document.getElementById('category_id').value,'0',document.getElementById('order').value,getEvents)">
                    <label for="online">Online</label>
                </div>

                <div class="form-group">
                    <input name="event_mode" type="radio" id="offline" onclick="getAllCount(document.getElementById('category_id').value,'1',document.getElementById('order').value,getEvents)">
                    <label for="offline">Offline</label>
                </div>
                <div class="form-group">
                    <input name="event_mode" type="radio" id="all_mode" onclick="getAllCount(document.getElementById('category_id').value,'2',document.getElementById('order').value,getEvents)">
                    <label for="all_mode">All</label>
                </div>

            </form>
        </div>
    </section>
    <!-- products section -->
    <section id="products">
        <div class="container">
            <div class="d-flex justify-content-between">
                <div class="text-muted m-2" id="res">Showing filtered events</div>
                <div class="ml-auto mr-lg-4">
                    <!-- <h3 id="category_name_heading"><?= $category_name ?></h3> -->
                </div>
                <div class="ml-auto mr-lg-4">
                    <input type="hidden" id="order" value="1">
                    <div id="sorting" onchange="selectFunction(this.value)" class="border rounded p-1 m-1"> <span class="text-muted">Sort by</span>
                        <select style="color: #012970;" name="sort" id="sort">
                            <option>Choose a filter</option>
                            <option value="nameAsc"><b>A to Z</b></option>
                            <option value="nameDesc"><b>Z to A</b></option>
                            <option value="popularity"><b>Popularity</b></option>
                            <option value="priceAsc"><b>Price Low to High</b></option>
                            <option value="priceDesc"><b>Price High to Low</b></option>
                        </select>
                    </div>
                </div>
            </div>
            <div class="row" id="myDiv">
                <section class="light">
                    <div class="container py-0" id="cards_div" style="padding: 0;">

                    
                        <!-- <div class="h1 text-center text-dark" id="pageHeaderTitle">My Cards Light</div> -->
                        <!-- AJAX response is appended here -->
                    </div>
                    <h2 class="load-more text-center" style="cursor: pointer; padding: 10px;color:#012970;"><b>Load More</b></h2>
                </section>
            </div>
        </div>

    </section>
    <!-- ======= Footer ======= -->

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
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
    <script>

        window.addEventListener('load', collapse_function());

        function collapse_function(){
            var coll = document.getElementsByClassName("collapsible");
            var i;

            for (i = 0; i < coll.length; i++) {
            coll[i].addEventListener("click", function() {
                this.classList.toggle("active");
                var content = this.nextElementSibling;
                if (content.style.display === "block") {
                content.style.display = "none";
                } else {
                content.style.display = "block";
                }
            });
            }
        }
    </script>
    <script>
        if(performance.navigation.type == 2){
   location.reload(true);
}
        var category_id = document.getElementById("category_id").value;

        function selectFunction() {
            var selectBox = document.getElementById("sort");
            var selectedValue = selectBox.options[selectBox.selectedIndex].value;
            // console.log(selectedValue);
            if (selectedValue === "nameAsc") {
                getAllCount(document.getElementById("category_id").value, document.getElementById('mode_id').value, 1,getEvents);
                // document.getElementById("order").value = 1;
            }
            if (selectedValue === "nameDesc") {
                getAllCount(document.getElementById("category_id").value, document.getElementById('mode_id').value, 4,getEvents);
                // document.getElementById("order").value = 4;
            }
            if (selectedValue === "popularity") {
                getAllCount(document.getElementById("category_id").value, document.getElementById('mode_id').value, 2,getEvents);
                // document.getElementById("order").value = 2;
            }
            if (selectedValue === "priceAsc") {
                getAllCount(document.getElementById("category_id").value, document.getElementById('mode_id').value, 3,getEvents);
                // document.getElementById("order").value = 3;
            }
            if (selectedValue === "priceDesc") {
                getAllCount(document.getElementById("category_id").value, document.getElementById('mode_id').value, 5,getEvents);
                // document.getElementById("order").value = 5;
            }
        }

        function getAllCount (c_id,mode,order,callback) {
                $.ajax({
                    url:"getAllCount.php",    //the page containing php script
                    type: "get",    //request type,
                    // dataType: 'json',
                    data: {
                        category_id: c_id, mode: mode
                    },
                    success:function(result){
                        console.log(result);
                        callback(c_id, mode, order, result);
                        // const allCount = result;
                    }
                });
            }

        function getEvents(c_id, mode, order,result) {

            $('#category_id').val(c_id);
            $('#mode_id').val(mode);
            
            console.log("All count: "+result);
            // console.log(allCount);
            $('#row').val('0');
            $('#all').val(Number(result));
            // console.log($('#all').val());
            $('#order').val(order);
            $('#cards_div').empty();
            // $('.load-more').click();

            var row = Number($('#row').val());
            var allcount = Number($('#all').val());
            var c_id = Number($('#category_id').val());
            var mode_id = Number($('#mode_id').val());
            var order = Number($('#order').val());

            var rowperpage = 5;

            console.log("Row: "+row);
            console.log("RowPerPage: "+rowperpage);
            console.log("category: "+c_id);
            console.log("mode: "+mode_id);
            console.log("order: "+order);
            // row = row + rowperpage;

            if(row <= allcount){
                $("#row").val(row);

                $.ajax({
                    url: "category_ajax.php?c_id=" + c_id + "&row=" + row + "&mode=" + mode_id + "&order=" + order,
                    type: 'get',
                    data: {},
                    beforeSend:function(){
                        $(".load-more").html('<div class="spinner-border text-center" style="padding: 30px;margin-left:0%;margin-top:10%;width: 3rem; height: 3rem;" role="status"></div>');
                    },
                    success: function(response){

                        // Setting little delay while displaying new content
                        setTimeout(function() {
                            // appending posts after last post with class="post"
                            // $("#cards_div:last").after(response).show().fadeIn("slow");
                            $("#cards_div").append(response).show().fadeIn("slow");
                            document.getElementById("category" + c_id).checked = true;
                            var rowno = row + rowperpage;

                            // checking row value is greater than allcount or not
                            if(rowno > allcount){

                                // Change the text and background
                                $('.load-more').text("");
                                return;
                                // $('.load-more').css("background","darkorchid");
                            }
                            else{
                                $(".load-more").text("Load more");
                            }
                        }, 800);

                    }
                });
            }else{
            }
        }

        function chk_scroll(e) {
            var elem = $(e.currentTarget);
            if (elem[0].scrollHeight - elem.scrollTop() == elem.outerHeight()) {
                console.log("bottom");
                $('.load-more').click();
            }
        }

        function isScrolledToBottom(el) {
            var $el = $(el);
            return el.scrollHeight - $el.scrollTop() - $el.outerHeight() < 1;
        }

        $(document).ready(function(){

        // Load more data

        $('div').on('scroll', chk_scroll);



        $('.load-more').click(function(){
        // function getEvents(c_id, mode, order) {
        // $.fn.getEvents = function(c_id, mode, order) { 
            var row = Number($('#row').val());
            var allcount = Number($('#all').val());
            var c_id = Number($('#category_id').val());
            var mode_id = Number($('#mode_id').val());
            var order = Number($('#order').val());

            var rowperpage = 5;
            row = row + rowperpage;

            if(row <= allcount){
                $("#row").val(row);

                $.ajax({
                    url: "category_ajax.php?c_id=" + c_id + "&row=" + row + "&mode=" + mode_id + "&order=" + order,
                    type: 'get',
                    data: {},
                    beforeSend:function(){
                        $(".load-more").html('<div class="spinner-border text-center" style="padding: 30px;margin-left:0%;margin-top:0%;width: 3rem; height: 3rem;" role="status"></div>');
                    },
                    success: function(response){

                        // Setting little delay while displaying new content
                        setTimeout(function() {
                            // appending posts after last post with class="post"
                            // $("#cards_div:last").after(response).show().fadeIn("slow");
                            $("#cards_div").append(response).show().fadeIn("slow");
                            document.getElementById("category" + c_id).checked = true;
                            var rowno = row + rowperpage;

                            // checking row value is greater than allcount or not
                            if(rowno > allcount){

                                // Change the text and background
                                $('.load-more').text("");
                                return;
                                // $('.load-more').css("background","darkorchid");
                            }
                            else{
                                $(".load-more").text("Load more");
                            }
                        }, 800);

                    }
                });
            }else{
            }
        // }
        });

        // $('.load-more').click();
        getAllCount(document.getElementById('category_id').value,'2',document.getElementById('order').value,getEvents);

        });

        function like(user_id, event_id, is_liked) {

            if (user_id == "0") {
                // document.getElementById("txtHint").innerHTML = "";
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
                        document.getElementById("itag" + event_id).innerHTML = this.responseText;
                    }
                };
                xmlhttp.open("GET", "like_ajax.php?user_id=" + user_id + "&event_id=" + event_id + "&is_liked=" + is_liked, true);
                xmlhttp.send();

            }

        }
    </script>
    <script>
        // document.onload = getEvents(<?= $category_id ?>, 2, 0);
        // document.getElementsByClassName('load-more').click();
        document.getElementById("all_mode").checked = true;
    </script>
    <style>
        .swal2-popup{
            padding: 0;
        }
        .swal2-html-container{
            margin: 0;
        }
    </style>
    <div class="row" style="clear: both;">
        <div class="col-12">
            <?php include("./footer.php"); ?>
        </div>
    </div>
    <!-- <link rel="stylesheet" href="style.css"> -->
    
</div>
</body>

</html>