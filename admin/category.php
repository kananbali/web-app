<?php
// session_start();

require_once "pdo.php";
require_once 'checkaccess.php';
require_once "util.php";
// display_message();


// opcache_reset();

// SELECT COMMAND
if (isset($_SESSION['inactive_records_selection'])) {
  $stmt = $pdo->query("SELECT category_id,category_name,category_description,category_image,effective_from_dt,effective_end_dt
                       FROM category_master
                       ORDER BY effective_end_dt DESC");
  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
  unset($_SESSION['inactive_records_selection']);
} else {
  $stmt = $pdo->query("SELECT category_id,category_name,category_description,category_image,effective_from_dt,effective_end_dt
                       FROM category_master
                       WHERE effective_end_dt IS NULL
                       ORDER BY category_name ASC");
  $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
<html>

<head>
  <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
  <!-- Primary Meta Tags -->
  <title>Manage Categories</title>
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

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"></script>
  <!--LINK TO CUSTOM JAVASCRIPT FUNCTIONS-->
  <script src="sa_javascript.js"></script>
  <!--AUTOCOMPLETE JQUERY LINK-->
  <script type="text/javascript" src="http://code.jquery.com/ui/1.10.1/jquery-ui.min.js"></script>

  <script src="https://kit.fontawesome.com/0dbfcd8819.js" crossorigin="anonymous"></script>


  <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
  <link rel="stylesheet" href="/resources/demos/style.css">
  <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
  <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>

  <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

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

<?php require_once "./sidenav.php"; ?>

<body>

  <!-- NOTICE: You can use the _analytics.html partial to include production code specific code & trackers -->

  <main class="content">
  <div class="topnav">
    <?php
    require_once "./topnav.php";
    ?>
    </div>
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center py-4">
      <div class="d-block mb-4 mb-md-0">
        <nav aria-label="breadcrumb" class="d-none d-md-inline-block">
          <ol class="breadcrumb breadcrumb-dark breadcrumb-transparent">
            <li class="breadcrumb-item">
              <a href="#">
                <svg class="icon icon-xxs" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                  <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                </svg>
              </a>
            </li>
            <li class="breadcrumb-item"><a href="#">Admin</a></li>
            <li class="breadcrumb-item active" aria-current="page">Manage Categories</li>
          </ol>
        </nav>
        <h2 class="h4">Category Master</h2>
        <p class="mb-0">Manage all of the categories here</p>
      </div>
      <!-- <div class="btn-toolbar mb-2 mb-md-0">
        <div class="btn-group ms-2 ms-lg-3">
          <button type="button" class="btn btn-sm btn-outline-gray-600">All</button>
          <button type="button" class="btn btn-sm btn-outline-gray-600">Inactive</button>
        </div>
      </div> -->
    </div>
    <span class="fw-normal"></span>
    <div class="table-settings mb-4">
      <div class="row align-items-center justify-content-between">
        <div class="col col-md-6 col-lg-3 col-xl-4">
          <div class="input-group me-2 me-lg-3 fmxw-400">
            <span class="input-group-text">
              <svg class="icon icon-xs" x-description="Heroicon name: solid/search" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                <path fill-rule="evenodd" d="M8 4a4 4 0 100 8 4 4 0 000-8zM2 8a6 6 0 1110.89 3.476l4.817 4.817a1 1 0 01-1.414 1.414l-4.816-4.816A6 6 0 012 8z" clip-rule="evenodd"></path>
              </svg>
            </span>
            <input type="text" id="myInput" class="form-control" placeholder="Search categories">

            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#modal-default">Add New Category</button>

          </div>

        </div>
        <div class="col-4 col-md-2 col-xl-1 ps-md-0 text-end">
          <div class="dropdown">
            <button class="btn btn-link text-dark dropdown-toggle dropdown-toggle-split m-0 p-1" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
              <svg class="icon icon-sm" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                <path fill-rule="evenodd" d="M11.49 3.17c-.38-1.56-2.6-1.56-2.98 0a1.532 1.532 0 01-2.286.948c-1.372-.836-2.942.734-2.106 2.106.54.886.061 2.042-.947 2.287-1.561.379-1.561 2.6 0 2.978a1.532 1.532 0 01.947 2.287c-.836 1.372.734 2.942 2.106 2.106a1.532 1.532 0 012.287.947c.379 1.561 2.6 1.561 2.978 0a1.533 1.533 0 012.287-.947c1.372.836 2.942-.734 2.106-2.106a1.533 1.533 0 01.947-2.287c1.561-.379 1.561-2.6 0-2.978a1.532 1.532 0 01-.947-2.287c.836-1.372-.734-2.942-2.106-2.106a1.532 1.532 0 01-2.287-.947zM10 13a3 3 0 100-6 3 3 0 000 6z" clip-rule="evenodd"></path>
              </svg>
              <span class="visually-hidden">Toggle Dropdown</span>
            </button>
            <div class="dropdown-menu dropdown-menu-xs dropdown-menu-end pb-0">
              <span class="small ps-3 fw-bold text-dark">Show</span>
              <a class="dropdown-item d-flex align-items-center fw-bold" href="#">10 <svg class="icon icon-xxs ms-auto" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                  <path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"></path>
                </svg></a>
              <a class="dropdown-item fw-bold" href="#">20</a>
              <a class="dropdown-item fw-bold rounded-bottom" href="#">30</a>
            </div>
          </div>
        </div>
      </div>
    </div>

    <!-- Add new Category form -->
    <form method="post" action="add_category.php" enctype="multipart/form-data">
      <div class="modal fade" id="modal-default" tabindex="-1" role="dialog" aria-labelledby="modal-default" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h2 class="h6 modal-title">Add New Category</h2>
              <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">

              <div class="mb-3">
                <label for="exampleFormControlInput1" class="form-label">Category Name</label>
                <input type="text" required class="form-control" name="category_name" id="exampleFormControlInput1" placeholder="Category name">
              </div>
              <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Category Description</label>
                <textarea class="form-control" required name="category_description" id="exampleFormControlTextarea1" rows="3"></textarea>
              </div>
              <div class="mb-3">
                <label for="exampleFormControlTextarea1" class="form-label">Upload Image</label>
                <input type="file" required class="form-control" id="image_file" name="image_path">
              </div>
            </div>
            <div class="modal-footer">

              <button type="submit" class="btn btn-success">Add Category</button>
              <!-- <button type="button" class="btn btn-danger">Reject</button> -->
              <button type="button" class="btn btn-link text-gray ms-auto" data-bs-dismiss="modal">Close</button>
            </div>
          </div>
        </div>
      </div>
    </form>

    <form method="post" action="category_master.php" id="myForm" enctype="multipart/form-data">
      <div class="card card-body border-0 shadow table-wrapper table-responsive">
        <table class="table table-hover">
          <thead>
            <tr>
              <th scope="col" class="text-center"><i class="fa fa-check" aria-hidden="true"></i></th>
              <th class="border-gray-200">Category Name</th>
              <th class="border-gray-200">Category Description </th>
              <th class="border-gray-200">Category Image</th>
            </tr>
          </thead>
          <tbody id="myTable">
            <!-- Item -->
            <?php foreach ($categories as $category) : ?>

              <?php
              if (isset($category['effective_end_dt'])) {
                $active = "disabled";
              } else {
                $active = "";
              }
              ?>
              <tr>

                <th scope="row">
                  <input <?= $active ?> type="checkbox" class="form-control-xs" name='delete[]' id="category_id<?= $category['category_id'] ?>" value='<?= $category['category_id'] ?>'></td>
                <td>
                  <span hidden class="fw-normal"><?= $category['category_name'] ?></span>
                  <input class="form-control" type="text" onchange="check('category_id<?= $category['category_id'] ?>')" value="<?= $category['category_name'] ?>" name="category_name<?= $category['category_id'] ?>" <?= $active ?>>
                </td>
                <td>
                  <span hidden class="fw-normal"><?= $category['category_description'] ?></span>
                  <input class="form-control" type="text" onchange="check('category_id<?= $category['category_id'] ?>')" value="<?= $category['category_description'] ?>" name="category_description<?= $category['category_id'] ?>" <?= $active ?>>
                </td>
                <td>
                  <div class="input-group me-2 me-lg-3 fmxw-400">
                    
                    <a class="btn btn-primary open_image" href="<?= $category['category_image'] ?>">
                      Open Image
                      <div><img src="<?= $category['category_image'] ?>" /></div>
                    </a>
                    <input type="hidden" name="default_link<?= $category['category_id'] ?>" value="<?= $category['category_image'] ?>">
                    <input <?= $active ?> type="file" onchange="check('category_id<?= $category['category_id'] ?>')" class="form-control" id="image_file" name="image_path<?= $category['category_id'] ?>">
                  </div>
                </td>
                </th>
              </tr>
            <?php endforeach; ?>
            <!-- Item -->

          </tbody>


        </table>
        <script>
          $(document).ready(function() {
            $("#myInput").on("keyup", function() {
              var value = $(this).val().toLowerCase();
              $("#myTable tr").filter(function() {
                $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
              });
            });
          });
        </script>
        <div class="card-footer px-3 border-0 d-flex flex-column flex-lg-row align-items-center justify-content-between">
          <button type="submit" class="btn btn-success" name="edit">Make Changes To Selected Records</button>
          <button type="submit" onclick="confirmDelete()" class="btn btn-danger" name="set_inactive">Make Selected Records Inactive</button>
          <button id="inactive_records_selection" name="inactive_records_selection" type="submit" class="btn btn-warning"><i class="fa fa-eye" aria-hidden="true"></i> Show inactive records</button>
          <!-- <div class="fw-normal small mt-4 mt-lg-0">Showing <b>5</b> out of <b>25</b> entries</div> -->
        </div>
      </div>
    </form>
    <?php require_once "./footer.php"; ?>
  </main>

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

  <script type="text/javascript">
    function confirmDelete() {
      // event.preventDefault();
      // Swal.fire({
      //   title: 'Are you sure you want to delete this category?',
      //   text: "You won't be able to revert this!",
      //   icon: 'warning',
      //   showCancelButton: true,
      //   confirmButtonColor: '#3085d6',
      //   cancelButtonColor: '#d33',
      //   confirmButtonText: 'Yes, delete it!'
      // }).then((result) => {
      //   if (result.isConfirmed) {
      //     Swal.fire(
      //       'Deleted!',
      //       'Category has been deleted.',
      //       'success'
      //     )
      //     document.getElementById('myForm').submit();
      //   }
      // })

    }
  </script>

  <?php //display_message();
  ?>
  <script src="javascript.js"></script>

</body>

</html>