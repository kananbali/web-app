<?php
// opcache_reset();
require_once '../config.php';
require_once 'checkaccess.php';
$event_id = $_GET['event_id'];
setcookie('editevent_id', $event_id);
// session_start();
// $result = $mysqli->query(
//   "SELECT category_id,category_name FROM category_master 
//   WHERE effective_end_dt IS NULL
//   ORDER BY category_name ASC"
// );

$user_id = $_COOKIE['user_id'];
$sql = "SELECT email_id FROM user_master WHERE user_id = $user_id";
// echo $sql;
$res2 = mysqli_query($mysqli, $sql);

$email = $res2->fetch_assoc();
$email = $email['email_id'];

$result = $mysqli->query(
  "SELECT category_id,category_name FROM category_master 
  WHERE effective_end_dt IS NULL
  ORDER BY category_name ASC"
);

$event = $mysqli->query(" SELECT * FROM event_master WHERE event_id = $event_id");
$event = $event->fetch_assoc();

$_SESSION['fname'] = $event['event_extended_desc'];

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!-- Primary Meta Tags -->
  <title>Manage Events</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">

  <!-- Sweet Alert -->
  <!-- <link type="text/css" href="../vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet"> -->

  <!-- Notyf -->
  <link type="text/css" href="../vendor/notyf/notyf.min.css" rel="stylesheet">

  <!-- Volt CSS -->
  <link type="text/css" href="../css/volt.css" rel="stylesheet">

  <style>
    .open_image > div {
      display: none;
      width: 50px;
      transition: display;
      transition-duration: 2s;
      transition-delay: 0s;
    }

    .open_image:hover>div {
      display: block;
      width: 100px;
    }
  </style>
</head>

<!-- sidenav -->
<?php require_once "./sidenav.php"; ?>

<body>

  <main class="content">

    <!-- topnav -->
    <?php require_once "./topnav.php" ?>

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center">
      <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
          <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
              <a href="./dashboard.php">
                <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                  </path>
                </svg>
              </a>
            </li>
            <li class="breadcrumb-item active" aria-current="page">Event Clone Form</li>
          </ol>
        </nav>
      </div>
    </div>

    <!-- Event Registration Form -->

    <div class="row">
      <div class="col-12 mb-4">
        <div class="card bg-yellow-100 border-0 shadow">
        </div>
      </div>
      <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <div style="margin-left: 0%; width: 97%;" class="mb-4">

          <!-- First Column -->

          <div style="margin-left: 0%; width: 97%;" class="mb-4">
            <?php $manager = $_COOKIE['user_id']; ?>
            <label for="manager_id">Event Manager ID</label>
            <input disabled type="text" class="form-control" id="manager_id" aria-describedby="manager_id" value="<?= $manager ?>" required>
            <input hidden name="manager_id" type="text" value="<?= $manager ?>" required>
          </div>

          <!-- <legend style="margin-left: 0%; width: 97%;" class="h6">Event Mode</legend>
            <div style="margin-left: 0%; width: 97%;" class="form-check">
              <input name="event_mode" class="form-check-input" type="radio" id="event_mode1" value="1" checked>
              <label class="form-check-label" for="event_mode1">
                Online
              </label>
            </div>
            <div style="margin-left: 0%; width: 97%;" class="form-check">
              <input name="event_mode" class="form-check-input" type="radio" id="event_mode2" value="2">
              <label class="form-check-label" for="event_mode2">
                Offline
              </label>
            </div> -->
            <div style="margin-left: 0%; width: 97%;" class="mb-4">
          <label for="event_name">Event Name</label>
          <input name="event_name" type="text" class="form-control" id="event_name" aria-describedby="event_name" value="<?= $event['event_name'] ?>" required>
        </div>

        <div style="margin-left: 0%; width: 97%;" class="mb-4">

          <!-- Third Column -->
          <label class="my-1 me-2" for="event_category">Event Category</label>
          <select name="event_category" class="form-select" id="event_category" aria-label="Default select example" required>
            <?php while ($obj = $result->fetch_object()) { ?>
              <option <?= $event['category_id'] == $obj->category_id ? "selected='selected'" : "" ?> value="<?= $obj->category_id ?>"> <?= $obj->category_name ?> </option>
            <?php } ?>
          </select>
        </div>

          <div style="margin-left: 0%; width: 97%;" class="mb-3">
            <label for="event_date">Event Date</label>
            <input name="event_date" class="form-control" id="event_date" type="date" placeholder="dd/mm/yyyy" value="<?= $event['event_date'] ?>" required>
          </div>

          <div style="margin-left: 0%; width: 97%;" class="mb-4">
            <label for="event_seats">Number of Seats</label>
            <input name="event_seats" type="number" min="0" class="form-control" id="event_seats" aria-describedby="event_seats" value="<?= $event['total_seats'] ?>" required>
          </div>

          <form id="imgupload">
          <div style="margin-left: 0%; width: 97%;" class="mb-3">
            <label for="formFile" class="form-label">Event Image</label>
            <div class="input-group me-2 me-lg-3 fmxw-400">
              <a class="btn btn-primary open_image" id="ev1" href="<?= $event['event_image_url'] ?>">
                Open Image
                <div><img id="ev2" src="<?= $event['event_image_url'] ?>" /></div>
              </a>
              <input type="hidden" id="default_link" value="<?= $event['event_image_url'] ?>">
              <input name="image_path" class="form-control" type="file" id="event_image">
            </div>
          </div>
        </form>

          <div class="col-12 col-xl-7 px-xl-0">
          </div>
        </div>
      </div>
      <div class="col-12 col-sm-6 col-xl-4 mb-4">

        <!-- Second Column -->
        <legend style="margin-left: 0%; width: 47%;" class="h6">Event Mode</legend>
        <div style="margin-left: 0%; width: 47%;" class="form-check form-switch">
          <?php
          if ($event['event_mode'] == 1) {
            echo '<input class="form-check-input" id="eventmodetoggle" id="eventmodetoggle"type="checkbox" value="1" checked>';
            echo '<input hidden name="event_mode" id="hiddeneventmodetoggle" value="1" >';
            echo '<label class="form-check-label" for="flexSwitchCheckDefault" id="eventmodelabel">OFFLINE</label>';
          } else {
            echo '<input class="form-check-input" type="checkbox" id="eventmodetoggle" value="0">';
            echo '<label class="form-check-label" for="flexSwitchCheckDefault" id="eventmodelabel">ONLINE</label>';
            echo '<input hidden name="event_mode" id="hiddeneventmodetoggle" value="0" >';
          }
          ?>
        </div>

        <div style="margin-left: 0%; width: 97%;" class="mb-4">
        <?php if($event['event_mode'] == 0) {?>
          <label id="event_venue_label">Event Platform</label>
          <input name="event_venue" type="text" class="form-control" id="event_venue" aria-describedby="event_venue" value="<?= $event['event_venue'] ?>" required>
        <?php } else {?>
          <label id="event_venue_label">Event City</label>
          <input name="event_venue" type="text" class="form-control" id="event_venue" aria-describedby="event_venue" value="<?= $event['event_venue'] ?>" required>
        <?php }?>
        </div>

        <div style="margin-left: 0%; width: 97%;" class="mb-4">
        <?php if($event['event_mode'] == 0) {?>
            <label id="event_link_label">Event Link</label>
          <input name="event_link" type="text" class="form-control" id="event_link" aria-describedby="event_link" value="<?= $event['event_link'] ?>" required>
        <?php } else {?>
          <label id="event_link_label">Event Address</label>
          <input name="event_link" type="text" class="form-control" id="event_link" aria-describedby="event_link" value="<?=$event['event_link'] ?>" required>
        <?php }?>
        </div>

        <div style="margin-left: 0%; width: 97%;" class="mb-4">
          <label for="event_start_time">Start Time</label>
          <input name="event_start_time" type="time" class="form-control" id="event_start_time" aria-describedby="event_start_time" value="<?= $event['event_start_time'] ?>" required>
        </div>

        <div style="margin-left: 0%; width: 97%;" class="mb-4">
          <label for="event_end_time">End Time</label>
          <input name="event_end_time" type="time" class="form-control" id="event_end_time" aria-describedby="event_end_time" value="<?= $event['event_end_time'] ?>" required>
        </div>

        <div style="margin-left: 0%; width: 97%;" class="mb-4">
        <label for="event_cancellation_time">Cancel Before time (in hours)</label>
        <select name="event_cancellation_time" class="form-select" id="event_cancellation_time" >
          <option selected value="null">Select an Option</option>
          <option value="0"  <?= $event['event_cancellation_time'] == "0" ? ' selected="selected"' : '';  ?> >0 hour</option>
          <option value="6"  <?= $event['event_cancellation_time'] == "6" ? ' selected="selected"' : '';  ?>  >6 hours </option>
          <option value="12" <?= $event['event_cancellation_time'] == "12" ? ' selected="selected"' : '';  ?>  >12 hours</option>
          <option value="24" <?= $event['event_cancellation_time'] == "24" ? ' selected="selected"' : '';  ?>  >24 hours</option>
          <option value="48" <?= $event['event_cancellation_time'] == "48" ? ' selected="selected"' : '';  ?>  >48 hours</option>
        </select>
        </div>
      </div>


      <div class="col-12 col-sm-6 col-xl-4 mb-4">
      <legend style="margin-left: 0%; width: 47%;" class="h6">Paid Promotion</legend>
        <div style="margin-left: 0%; width: 47%;" class="form-check form-switch">
          <?php
          if ($event['subscription_status'] == 1) {
            echo '<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" checked>';
            echo '<input hidden name="paid_promotion" id="hiddenflexSwitchCheckDefault" value="1">';
            echo '<label class="form-check-label" for="flexSwitchCheckDefault" id="toggle-label">YES</label>';
            // echo '<script>document.getElementById("flexSwitchCheckDefault").checked = true;</script>';
          } else {
            echo '<input class="form-check-input" type="checkbox" id="flexSwitchCheckDefault" value="0">';
            echo '<input hidden name="paid_promotion" id="hiddenflexSwitchCheckDefault" value="0">';
            echo ' <label class="form-check-label" for="flexSwitchCheckDefault" id="toggle-label">NO</label>';
            // echo '<script>document.getElementById("flexSwitchCheckDefault").checked = false;</script>';
          }
          ?>
        </div>

        <div style="margin-left: 0%; width: 97%;" class="mb-4">
          <label for="event_price">Ticket Price</label>
          <input name="event_price" type="text" class="form-control" id="event_price" aria-describedby="event_price" value="<?= $event['event_price'] ?>" onkeyup="checkDiscountType()" required>
        </div>
        
        <input name="discounted_price" type="hidden" class="form-control" id="discounted_price" aria-describedby="discounted_price" value="<?= $event['discounted_price'] ?>" required>
        <div style="margin-left: 0%; width: 97%;" class="mb-4">
          <label for="discount_type">Discount Type</label>
          <select name="discount_type" class="form-control" id="discount_type" aria-describedby="discount_type" onchange="checkDiscountType()" required>
            <option value="">Select an Option</option>
            <option value="0" <?= $event['discount_type'] == "0" ? ' selected="selected"' : '';  ?>>Flat Offer</option>
            <option value="1" <?= $event['discount_type'] == "1" ? ' selected="selected"' : '';  ?>>Percentage Offer</option>
          </select>
        </div>
        <div style="margin-left: 0%; width: 97%;" class="mb-4">
          <label for="discounted_price">Discount Price</label>
          <input name="discount_price" type="text" class="form-control" id="discount_price" aria-describedby="discount_price" value="<?= $event['discount_price'] ?>" onkeyup="checkDiscountType()" required>
        </div>
        <div style="margin-left: 0%; width: 97%;" class="mb-4">
          <label for="selling_price">Selling Price</label>
          <input id="selling_price" class="form-control" type="text" placeholder="<?= $event['discounted_price'] ?>"  readonly>
        </div>
        <div style="margin-left: 0%; width: 97%;" class="my-4">
            <label for="textarea">Event Description</label>
            <textarea maxlength="255" name="textarea" class="form-control" placeholder="Other Details..." id="textarea" rows="5" required><?= $event['event_description'] ?></textarea>
          </div>
      </div>
    </div>
    <div style="margin-left: 0%;" class="mb-4">
      <label for="event_name">Extended Description</label>
      <div class="card">
        <?php require_once './editorjs_editor_edit_event.php'; ?>
      </div>
    </div>

    <div class="row">
      <div class="col-12 col-sm-6 col-xl-4 mb-4">
      </div>
      <div class="col-12 col-sm-6 col-xl-4 mb-4">
        <button id="subbutton" class="btn btn-outline-gray-700" style="font-size: 20px; width: 100%; margin-left: 0%; text-align: center;" type="click">Submit</button>
      </div>
    </div>
    <!-- Footer -->
    <footer class="bg-white rounded shadow p-5 mb-4 mt-4">
  <div class="row">
    <div class="col-12 col-md-4 col-xl-6 mb-4 mb-md-0">
      <p class="mb-0 text-center text-lg-start">© <span class="current-year"></span> <a class="text-primary fw-normal" href="../" target="_blank">Finserv EVENTS</a></p>
    </div>
    <div class="col-12 col-md-8 col-xl-6 text-center text-lg-start">
      <!-- List -->
      <ul class="list-inline list-group-flush list-group-borderless text-md-end mb-0">
        <li class="list-inline-item px-0 px-sm-2">
          <a href="../">Home</a>
        </li>
        <li class="list-inline-item px-0 px-sm-2">
          <a href="../index.php#contact">Contact</a>
        </li>
        <li class="list-inline-item px-0 px-sm-2">
          <a href="../index.php#categories">Categories</a>
        </li>
        <li class="list-inline-item px-0 px-sm-2">
          <a href="../userProfile/">Profile</a>
        </li>
      </ul>
    </div>
  </div>
</footer>
  </main>
  <script>
    document.getElementById("eventmodetoggle").addEventListener("change", function() {
      if (this.checked) {
        $('#event_venue_label').html('Event City');
        $('#event_link_label').html('Event Address');
        document.getElementById("eventmodelabel").innerHTML = "OFFLINE";
        document.getElementById("hiddeneventmodetoggle").setAttribute('value', 1);
      } else {
        $('#event_venue_label').html('Event Platform');
        $('#event_link_label').html('Event Link');
        document.getElementById("eventmodelabel").innerHTML = "ONLINE";
        document.getElementById("hiddeneventmodetoggle").setAttribute('value', 0);
      }
    });

    document.getElementById("flexSwitchCheckDefault").addEventListener("change", function() {
      if (this.checked) {
        document.getElementById("toggle-label").innerHTML = "YES";
        document.getElementById("hiddenflexSwitchCheckDefault").setAttribute('value', 1);

      } else {
        document.getElementById("toggle-label").innerHTML = "NO";
        document.getElementById("hiddenflexSwitchCheckDefault").setAttribute('value', 0);

      }
    });
  </script>

  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
  <script>
    // document.getElementById('discounted_price').value = $("#event_price").val();
    function checkDiscountType() {
      var discount_type = document.getElementById("discount_type").value;
      if (discount_type == "0") {
        if(!($("#discount_price").val() == 0)){
        document.getElementById('discounted_price').value = Math.round($("#event_price").val() - $("#discount_price").val());
        if(document.getElementById('discounted_price').value<0){
          Swal.fire({
                            icon: 'error',
                            title: 'Incorrect Discount',
                            text: 'Discount Price is Incorrect',
                        })
          document.getElementById('discount_price').value = "";
          document.getElementById('discounted_price').value = "";
          document.getElementById('event_price').value = "";
          document.getElementById('discount_type').value = "";
        }
        }
        else{
          document.getElementById('discounted_price').value = Math.round($("#event_price").val());
          if(document.getElementById('discounted_price').value<0){
            Swal.fire({
                            icon: 'error',
                            title: 'Incorrect Discount',
                            text: 'Discount Price is Incorrect',
                        })
          document.getElementById('discount_price').value = "";
          document.getElementById('discounted_price').value = "";
          document.getElementById('event_price').value = "";
          document.getElementById('discount_type').value = "";
        }
        }
      }
      //discounted_price = event_price - (event_price * discount_price / 100)
      else if (discount_type == "1") {
        document.getElementById('discounted_price').value = Math.round(($("#event_price").val() - ($("#event_price").val() * $("#discount_price").val() / 100)));
        if(document.getElementById('discounted_price').value<0){
          Swal.fire({
                            icon: 'error',
                            title: 'Incorrect Discount',
                            text: 'Discount Price is Incorrect',
                        })
          document.getElementById('discount_price').value = "";
          document.getElementById('discounted_price').value = "";
          document.getElementById('event_price').value = "";
          document.getElementById('discount_type').value = "";
        }
      }
      // console.log($("#discounted_price").val())
      document.getElementById('selling_price').placeholder= document.getElementById('discounted_price').value;
    }




    $('#imgupload').on('change', function() {
      // console.log($('#imgupload').val());
      $.ajax({
        url: "upload.php",
        type: "POST",
        data: new FormData($('#imgupload')[0]),
        contentType: false,
        cache: false,
        processData: false,
        success: function(data) {
          console.log(data);
          $('#ev2').attr('src', 'event_images/' + data)
          $('#ev1').attr('href', 'event_images/' + data)
          // $('#event_image').val('./event_images/' + data);
        },
        error: function(e) {
          console.log("error");
          console.log(e);
        }
      });
    })

    window.onload = function() {
      if (!window.location.hash) {
        window.location = window.location + '#loaded';
        window.location.reload();
      }
    }

    $("#subbutton").click(function() {
      savebtn();
      var img = $('#default_link').val();
      $.ajax({
        url: 'i_clone_event.php',
        type: 'POST',
        async: false,
        data: {
          event_date: $("#event_date").val(),
          event_seats: $("#event_seats").val(),
          event_price: $("#event_price").val(),
          discounted_price: $("#discounted_price").val(),
          textarea: $("#textarea").val(),
          event_name: $("#event_name").val(),
          event_venue: $("#event_venue").val(),
          event_start_time: $("#event_start_time").val(),
          paid_promotion: $("#hiddenflexSwitchCheckDefault").val(),
          event_mode: $("#hiddeneventmodetoggle").val(),
          event_category: $("#event_category").val(),
          event_link: $("#event_link").val(),
          event_end_time: $("#event_end_time").val(),
          manager_id: '<?= $manager ?>',
          default_link: img,
          discount_price: $("#discount_price").val(),
          discount_type: $("#discount_type").val(),
          event_cancellation_time : $("#event_cancellation_time").val()

        },
        dataType: 'json',
        success: function(data) {
          // console.log(data);
          // dp = JSON.parse(data);
          // console.log(dp);
          if (data['status'] == 'success') {
            Swal.fire({
              title: 'Success',
              text: 'Event Cloned Successfully!',
              icon: 'success',
              showConfirmButton: false,
              timer: 2000
            }).then((result) => {
              // alert("Event link has")
              window.location.href = "./event-list.php";
            })
          } else {
            Swal.fire({
              title: 'Error',
              text: 'Please check the Details and Try Again.',
              icon: 'error',
              showConfirmButton: false,
              timer: 2000
            })
          }
        },
        error: function(e) {
          console.log(e);
        }
      });
    })
  </script>

  <script src="https://smtpjs.com/v3/smtp.js"> </script>

  <!-- Core -->
  <script src="../vendor/@popperjs/core/dist/umd/popper.min.js"></script>
  <script src="../vendor/bootstrap/dist/js/bootstrap.min.js"></script>

  <!-- Vendor JS -->
  <script src="../vendor/onscreen/dist/on-screen.umd.min.js"></script>

  <!-- Slider -->
  <script src="../vendor/nouislider/distribute/nouislider.min.js"></script>

  <!-- Smooth scroll -->
  <script src="../vendor/smooth-scroll/dist/smooth-scroll.polyfills.min.js"></script>

  <!-- Charts -->
  <script src="../vendor/chartist/dist/chartist.min.js" type="text/javascript"></script>
  <script src="../vendor/chartist-plugin-tooltips/dist/chartist-plugin-tooltip.min.js" type="text/javascript"></script>

  <!-- Datepicker -->
  <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js" type="text/javascript"></script>

  <!-- Sweet Alerts 2 -->
  <script src="../vendor/sweetalert2/dist/sweetalert2.all.min.js" type="text/javascript"></script>

  <!-- Moment JS -->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.27.0/moment.min.js" type="text/javascript"></script>

  <!-- Vanilla JS Datepicker -->
  <script src="../vendor/vanillajs-datepicker/dist/js/datepicker.min.js" type="text/javascript"></script>

  <!-- Notyf -->
  <script src="../vendor/notyf/notyf.min.js" type="text/javascript"></script>

  <!-- Simplebar -->
  <script src="../vendor/simplebar/dist/simplebar.min.js" type="text/javascript"></script>

  <!-- Github buttons -->
  <script async defer src="https://buttons.github.io/buttons.js" type="text/javascript"></script>

  <!-- Volt JS -->
  <script src="../assets/js/volt.js" type="text/javascript"></script>


</body>

</html>