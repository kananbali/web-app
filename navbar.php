<?php require_once("config.php");
$query = "SELECT * FROM category_master WHERE effective_end_dt IS NULL";
$cats = mysqli_query($mysqli, $query);
if (isset($_SESSION['roles'])) {
  $roles = $_SESSION['roles'];
}
?>
<style>
  .badge {
    padding-left: 9px;
    padding-right: 9px;
    -webkit-border-radius: 20px;
    -moz-border-radius: 20px;
    border-radius: 20px;
  }

  .label-warning[href],
  .badge-warning[href] {
    background-color: #c67605;
  }

  #lblCartCount {
    font-size: 15px;
    /* background: #ff0000; */
    /* background: red; */
    color: red;
    font-weight:800;
    /* font-size; */
    padding: 2px 3px;
    vertical-align: top;
    margin-left: -23px;
    margin-top: -1px; 
}
.mobileHide{
        display: block;
}
.mobileShow{
    display: none;
}
.cartArrow{
      display: none;
    }
@media(max-width:575px) {
    .mobileHide{
        display: none;
    }
    .mobileShow{
        display: block;
    }
    .cartArrow{
      display: inline;
    }
}
  </style>
<!-- ======= Header ======= -->
<header id="header" class="header fixed-top" style="background-color: white !important;">
  <div class=" container-xl d-flex align-items-center justify-content-between">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
    <a href="/index.php" class="logo d-flex align-items-center">
      <img src="/assets/img/logo.png" alt="">
      <span>Finserv EVENTS</span>
    </a>

    <nav id="navbar" class="navbar" onload="updateCartNav()">
      <ul>
        <li><a class="nav-link scrollto" href="/#hero">Home</a></li>

        <li><a class="nav-link scrollto" href="/#contact">Contact</a></li>
        <li class="dropdown"><a href="#"><span>Events</span> <i class="bi bi-chevron-down"></i></a>
          <ul>
            <?php
            while ($obj = $cats->fetch_object()) { ?>
              <li><a href="/category.php?category_id=<?= $obj->category_id ?>"><?= $obj->category_name ?></a></li>
            <?php } ?>
          </ul>
        </li>
        <?php
        if (!isset($_COOKIE['user_id'])) {
          // echo '<li><a class="nav-link scrollto" href="/#features">Features</a></li>';
          echo '<li><a class="nav-link" id="listbtn" style="cursor: pointer;">List your Event</a></li>';
          echo '<li><a style="background: #012970; cursor: pointer;" class="getstarted text-white" id="loginbtn" style="cursor: pointer;">Login</a></li>';
        } else {
          if (!in_array(2, $roles)) {
            echo '<li><a class="nav-link" style="cursor: pointer;" onclick="setaseventmanager()" >List Your Event</a></li>';
          }

          echo '
        <li class="dropdown">
          <a style="cursor: pointer; color: #012970;"><span onmouseover="updateCartNav()">Cart&nbsp; <i class="bi bi-chevron-down cartArrow" style=""></i></span></a>
          
          <ul id="cart_items">

          </ul>
          

        </li>
        <i class="bi bi-cart mobileHide" style="font-size:32px; color: #012970;"></i>
        <span class="badge badge-warning" id="lblCartCount"></span>
        ';
        
          if (isset($_COOKIE['user_id'])) {
            $user_id = $_COOKIE['user_id'];
            $query1 = "SELECT user_image FROM user_master WHERE user_id = $user_id";
            $cats1 = mysqli_query($mysqli, $query1);
            $img_url = $cats1->fetch_object();

            $role_id = $_COOKIE['role_id'];
            $name = $_SESSION['name'];

            echo '<li class="dropdown"><a href="#"><span>' . $name . '</span> <i class="bi bi-chevron-down"></i></a>
            <ul>';
          } else {
            $user_id = 0;
          }

          if (in_array(2, $roles)) {
            echo '<li><a href="/eventManager/event-list.php">Manage Events</a></li>';
          }
          if (in_array(3, $roles)) {
            echo '<li><a href="/admin/index.php">Admin Dashboard</a></li>';
            // echo '<li><a href="/eventManager/event-list.php">Manage Events</a></li>';
          }
        ?>



        <?php
        
  
          echo '
              <li><a href="/userProfile/registeredEvents.php">My Calendar</a></li>
              <li><a href="/userProfile/myOrders.php">My Orders</a></li>
              <li><a href="/userProfile/index.php">Edit Profile</a></li>
              <li><a href="/login/logout.php">Logout</a></li>
            </ul>
          </li>
          
          <a href="/userProfile" class="logo d-flex align-items-center">
        <img class="mobileHide" height="40px" width ="40px" src="/userProfile/' . $img_url->user_image . '" alt="" style="border-radius: 50%;">
      </a>';
        }

        
        ?>

      </ul>
      <i class="bi bi-list mobile-nav-toggle"></i>
    </nav><!-- .navbar -->

  </div>
</header><!-- End Header -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.5/dist/sweetalert2.all.min.js"></script>
<script>

  document.getElementById("loginbtn").onclick = function() {
    location.href = "/login/login.php?redrurl=" + window.location.href;
  };
  document.getElementById('listbtn').addEventListener('click', function() {

      window.location = "/login/login.php?redrurl=" + window.location.href;
    // })
  });


  function updateCartNav() {

    user_id = '<?= $user_id ?>';
    if (user_id == "0") {
      document.getElementById('lblCartCount').innerHTML = 0
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

          document.getElementById("cart_items").innerHTML = this.responseText;
          document.getElementById('lblCartCount').innerHTML = document.getElementById('cartCount').value;

        }
      };
      xmlhttp.open("GET", "/cart.php");
      xmlhttp.send();

    }

  }
  <?php
    if (isset($_COOKIE['user_id'])) {
    $uid = $_SESSION['user_id']; 
    ?>
    
    function setaseventmanager(){
      $.ajax({
        url:'/eventmanager.php',
        type:'POST',
        data:{
          user_id:<?=$uid?>
        },
        success: function(data){
    
          dp = JSON.parse(data);
          // console.log(dp);
          if(dp.status == 1){
            Swal.fire({
              icon: 'success',
              title: 'Success',
              text: 'Redirecting you to the event manager dashboard!',
              showConfirmButton: false,
              timer:2000
            }).then(function(){
              window.location.href = '/eventManager/';
            });
          }
        }
          
      })
    }
  <?php } ?>
  // updateCartNav();
  
</script>