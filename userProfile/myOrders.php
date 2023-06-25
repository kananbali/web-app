<?php
include('../admin/pdo.php');

//require_once 'checkaccess.php';
if (isset(($_COOKIE['user_id']))) {
  $user_id = $_COOKIE['user_id'];
}

$sql =
"SELECT order_id,order_time,payment_status,payment_mode.payment_mode
FROM order_master
INNER JOIN payment_mode ON payment_mode.payment_mode_id = order_master.payment_mode
WHERE order_master.user_id = $user_id
ORDER BY order_time DESC";
// $event = mysqli_query($conn, $sql);
$statement = $pdo->query($sql);
$orders = $statement->fetchAll(PDO::FETCH_ASSOC);

$count = count($orders);


?>

<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
  <title>Your Orders</title>
  <!-- Favicons -->
  <link href="../assets/img/favicon.png" rel="icon">
  <link href="../assets/img/apple-touch-icon.png" rel="apple-touch-icon">
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.8.1/font/bootstrap-icons.css">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,300i,400,400i,600,600i,700,700i|Nunito:300,300i,400,400i,600,600i,700,700i|Poppins:300,300i,400,400i,500,500i,600,600i,700,700i" rel="stylesheet">

  <!-- Vendor CSS Files -->
  <link href="../assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
  <link href="../assets/vendor/bootstrap-icons/bootstrap-icons.css" rel="stylesheet">

  <!-- Template Main CSS File -->
  <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body onload="updateCartNav()">
  <?php require_once "../navbar.php"; ?>
  <br><br><br>
  <section id="categories" class="categories py-0">

    <div class="container-fluid" data-aos="fade-up">


    <p class="py-3 container" style="color:#012970; font-family: Nunito, sans-serif; font-weight: 700; font-size: 32px;">Your Orders</p>
      <div class="container">

        <?php if($count == 0):?>
          <h4>No orders placed</h4>
        <?php endif;?>

        <?php
        if($count != 0){
        foreach ($orders as $order) {
            $dt = new DateTime($order['order_time']);

            $date = $dt->format('M d Y');
            $time = $dt->format('H:i A');
        ?>

            <div class="card" style="margin-top: 15px;margin-bottom: 15px;">
            <div class="card-header">
                Order Number: <?= $order['order_id']?>
            </div>
            <div class="card-body">
                <h5 class="card-title"><i class="bi bi-calendar"></i> <?= $date?> <i class="bi bi-dot"></i> <i class="bi bi-alarm"></i> <?=$time?></h5>
                <h5 class="card-title"></h5>
                <p class="card-text">Payment Status: 
                    <?php 
                        if($order['payment_status'] == 1){ echo '<span class="text-success">Paid using '.$order['payment_mode'].'</span>';}
                        ?></p>
                <a style="background: #012970;" href="../invoice.php?order_id=<?=$order['order_id']?>" class="btn btn-primary">Order Details</a>
            </div>
            </div>
        <?php } } ?>

      </div>
    </div>

  </section>
  <script type='text/javascript' src='https://stackpath.bootstrapcdn.com/bootstrap/4.0.0/js/bootstrap.bundle.min.js'></script>
    <!-- Vendor JS Files -->
    <script src="../assets/vendor/purecounter/purecounter.js"></script>
    <script src="../assets/vendor/aos/aos.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.min.js"></script>
    <script src="../assets/vendor/glightbox/js/glightbox.min.js"></script>
    <script src="../assets/vendor/isotope-layout/isotope.pkgd.min.js"></script>
    <script src="../assets/vendor/swiper/swiper-bundle.min.js"></script>
    <script src="../assets/vendor/php-email-form/validate.js"></script>

    <!-- Template Main JS File -->
    <script src="../assets/js/main.js"></script>
  <?php require_once "../footer.php" ?>
</body>

</html>
