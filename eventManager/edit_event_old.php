<?php
// opcache_reset();
include('../config.php');
require_once 'checkaccess.php';
$event_id = $_GET['event_id'];
setcookie('editevent_id', $event_id);

$result = $mysqli->query('SELECT * FROM event_master WHERE event_id =' . $event_id . '');
if ($result === FALSE) {
  die(mysqli_error($mysqli));
}
$obj = $result->fetch_object();

$cat = $mysqli->query(
  "SELECT category_id,category_name FROM category_master 
  WHERE effective_end_dt IS NULL
  ORDER BY category_name ASC"
);

?>

<!DOCTYPE html>
<html lang="en">

<head>

  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

  <!-- Primary Meta Tags -->
  <title>Edit Event</title>
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

  <!-- Favicon -->
  <link rel="apple-touch-icon" sizes="120x120" href="../assets/img/favicon/apple-touch-icon.png">
  <link rel="icon" type="image/png" sizes="32x32" href="../assets/img/favicon/favicon-32x32.png">
  <link rel="icon" type="image/png" sizes="16x16" href="../assets/img/favicon/favicon-16x16.png">
  <link rel="manifest" href="../assets/img/favicon/site.webmanifest">
  <link rel="mask-icon" href="../assets/img/favicon/safari-pinned-tab.svg" color="#ffffff">
  <meta name="msapplication-TileColor" content="#ffffff">
  <meta name="theme-color" content="#ffffff">

  <!-- Sweet Alert -->
  <link type="text/css" href="../vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">

  <!-- Notyf -->
  <link type="text/css" href="../vendor/notyf/notyf.min.css" rel="stylesheet">

  <!-- Volt CSS -->
  <link type="text/css" href="../css/volt.css" rel="stylesheet">

  <style>
    a>div {
      display: none;
      width: 50p;
      transition: display;
      transition-duration: 2s;
      transition-delay: 0s;
    }

    a:hover>div {
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

    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
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
            <li class="breadcrumb-item active" aria-current="page">Event Registration Form</li>
          </ol>
        </nav>
      </div>
    </div>
    <form action="i_edit_event.php" method="post" enctype="multipart/form-data">

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
              <label for="manager_id">Event Manager ID</label>
              <?php echo '<input disabled  type="text" class="form-control" id="manager_id" aria-describedby="manager_id" value="' . $obj->event_manager_id . '">' ?>
              <?php echo '<input hidden name="manager_id" type="text" value="' . $obj->event_manager_id . '">' ?>
            </div>
            <div style="margin-left: 0%; width: 97%;" class="mb-3">
              <label for="event_date">Event Date</label>
              <?php echo '<input name="event_date" class="form-control" id="event_date" type="date" placeholder="dd/mm/yyyy" value="' . $obj->event_date . '"required>'; ?>
            </div>

            <div style="margin-left: 0%; width: 97%;" class="mb-4">
              <label for="event_seats">Number of Seats</label>
              <?php echo '<input name="event_seats" type="text" class="form-control" id="event_seats" aria-describedby="event_seats" value="' . $obj->total_seats . '">'; ?>
            </div>

            <div style="margin-left: 0%; width: 97%;" class="my-4">
              <label for="textarea">Event Description</label>
              <?php echo '<textarea name="textarea" class="form-control" id="textarea" rows="5">' . $obj->event_description . '</textarea>'; ?>
            </div>
            <div class="col-12 col-xl-7 px-xl-0">
            </div>
          </div>
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">

          <!-- Second Column -->
          <div style="margin-left: 0%; width: 97%;" class="mb-4">
            <label for="event_name">Event Name</label>
            <?php echo '<input name="event_name" type="text" class="form-control" id="event_name" aria-describedby="event_name" value="' . $obj->event_name . '">'; ?>
          </div> <br>

          <div style="margin-left: 0%; width: 97%;" class="mb-4">
            <label for="event_venue">Event Venue</label>
            <?php echo '<input name="event_venue" type="text" class="form-control" id="event_venue" aria-describedby="event_venue" value="' . $obj->event_venue . '">'; ?>
          </div>

          <div style="margin-left: 0%; width: 97%;" class="mb-4">
            <label for="event_start_time">Start Time</label>
            <?php echo '<input name="event_start_time" type="time" class="form-control" id="event_start_time" aria-describedby="event_start_time" value="' . $obj->event_start_time . '">'; ?>
          </div>

          <div style="margin-left: 0%; width: 97%;" class="mb-4">
            <label for="event_price">Ticket Price</label>
            <?php echo '<input name="event_price" type="text" class="form-control" id="event_price" aria-describedby="event_price" value="' . $obj->event_price . '">'; ?>
          </div>
          <legend style="margin-left: 0%; width: 47%;" class="h6">Paid Promotion</legend>
          <div style="margin-left: 0%; width: 47%;" class="form-check form-switch">
            <?php
            if ($obj->subscription_status == 1) {
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
          <legend style="margin-left: 0%; width: 47%;" class="h6">Event Mode</legend>
          <div style="margin-left: 0%; width: 47%;" class="form-check form-switch">
            <?php
            if ($obj->event_mode == 0) {
              echo '<input class="form-check-input" id="eventmodetoggle" id="eventmodetoggle"type="checkbox" value="0" checked>';
              echo '<input hidden name="event_mode" id="hiddeneventmodetoggle" value="0" >';              
              echo '<label class="form-check-label" for="flexSwitchCheckDefault" id="eventmodelabel">OFFLINE</label>';

              // echo '<script>document.getElementById("eventmodetoggle").checked = true;</script>';
            } else {
              echo '<input class="form-check-input" type="checkbox" id="eventmodetoggle" value="1">';
              echo '<label class="form-check-label" for="flexSwitchCheckDefault" id="eventmodelabel">ONLINE</label>';
              echo '<input hidden name="event_mode" id="hiddeneventmodetoggle" value="1" >';              
            }
            ?>
            <!-- <input name="event_mode" class="form-check-input" type="checkbox" id="eventmodetoggle" value="0">
          <label class="form-check-label" for="flexSwitchCheckDefault" id="eventmodelabel"></label> -->
          </div>
          <!-- Publish Button -->
        </div>
        <div class="col-12 col-sm-6 col-xl-4 mb-4">
          <div style="margin-left: 0%; width: 97%;" class="mb-4">

            <!-- Third Column -->
            <label class="my-1 me-2" for="event_category">Event Category</label>
            <select name="event_category" class="form-select" id="" aria-label="Default select example">
               <?php while ($obj2 = $cat->fetch_object()) { ?>
                <option <?= $obj->category_id == $obj2->category_id ? "selected='selected'" : ""?> value="<?= $obj2->category_id ?>"> <?= $obj2->category_name ?> </option>
              <?php }?>
            </select>
            </select>

          </div> <br>

          <div style="margin-left: 0%; width: 97%;" class="mb-4">
            <label for="event_link">Event Link (if mode is online)</label>
            <?php echo '<input name="event_link" type="text" class="form-control" id="event_link" aria-describedby="event_link" value="' . $obj->event_link . '">'; ?>
          </div>

          <div style="margin-left: 0%; width: 97%;" class="mb-4">
            <label for="event_end_time">End Time</label>
            <?php echo '<input name="event_end_time" type="time" class="form-control" id="event_end_time" aria-describedby="event_end_time" value="' . $obj->event_end_time . '">'; ?>
          </div>

          <div style="margin-left: 0%; width: 97%;" class="mb-3">
            <label for="formFile" class="form-label">Event Image</label>
            <div class="input-group me-2 me-lg-3 fmxw-400">
              <a class="btn btn-primary" href="<?= $obj->event_image_url ?>">
                Open Image
                <div><img src="<?= $obj->event_image_url ?>" /></div>
              </a>
              <input type="hidden" name="default_link" value="<?= $obj->event_image_url ?>">
              <input name="image_path" class="form-control" type="file" id="event_image">
            </div>
          </div>
          <div style="margin-left: 0%; width: 97%;" class="mb-4">
            <label for="discounted_price">Discounted Price</label>
            <?php echo '<input name="discounted_price" type="text" class="form-control" id="discounted_price" aria-describedby="discounted_price" value="'.$obj->discounted_price.'">'; ?>
          </div>

        </div>
        <div class="row">
          <div class="col-12 col-sm-6 col-xl-4 mb-4">
          </div>
          <div class="col-12 col-sm-6 col-xl-4 mb-4">
            <input class="btn btn-outline-gray-700" style="font-size: 20px; width: 100%; margin-left: 0%; text-align: center;" type="submit" value="Submit">
          </div>
        </div>
    </form>
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
        document.getElementById("eventmodelabel").innerHTML = "OFFLINE";
        document.getElementById("hiddeneventmodetoggle").setAttribute('value', 0);
      } else {
        document.getElementById("eventmodelabel").innerHTML = "ONLINE";
        document.getElementById("hiddeneventmodetoggle").setAttribute('value', 1);
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

  <script>
    document.getElementById('event_category').selectedIndex = <?php echo $obj->category_id ?>;
  </script>


</body>

</html>