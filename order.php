<?php
  //get the user_id
  //get all the events added in cart and copy them to order master and order transaction
  //delete the cart items for the particular user
  require_once "config.php";
  require_once "functions.php";
  $email_id = $_SESSION['email_id'];
  if(!isset($_COOKIE['user_id'])){
    die('Please login');
  }
  else{
    $user_id = $_COOKIE['user_id'];
  }
  // $cart_id = $_GET['cart_id'];

  $sql = "SELECT cart.event_id,no_of_tickets,original_price,cart.discount_price,event_name,	event_start_time, event_date, event_link 
           FROM cart
           INNER JOIN event_master ON cart.event_id = event_master.event_id
           WHERE user_id = $user_id AND no_of_tickets > 0";
  $cart_items = mysqli_query($mysqli,$sql);

  $insertSql = "INSERT INTO order_master (user_id,payment_status,payment_mode) VALUES ($user_id,1,1)";
  $result = $mysqli->query($insertSql);

  $order_id = $mysqli->insert_id;
  echo(".");

  $html='';
  $html .= '<h4>Thank you for registering for the event. Your Event Details are as follows:</h4>';
  $html .= '<table><tr><th>Order ID</th>';
  $html .= '<th>Event Name</th>';
  $html .= '<th>Event Date</th>';
  $html .= '<th>Event Time</th>';
  $html .= '<th>Tickets</th>';
  $html .= '<th>Event Link</th></tr>';
 

  while ($item = $cart_items->fetch_object()) {
    $remaining_seats = getRemainingSeats($mysqli,$item->event_id);
    $no_of_tickets= intval($item->no_of_tickets);

    //append html here
    $html .= '<tr>';
    $html .= '<td>'.$order_id.'</td>';
    $html .= '<td>'.$item->event_name.'</td>';
    $html .= '<td>'.$item->event_date.'</td>';
    $html .= '<td>'.$item->event_start_time.'</td>';
    $html .= '<td>'.$item->no_of_tickets.'</td>';
    $html .= '<td>'.$item->event_link.'</td>';
    
    $html .= '</tr>';

    $sql =
    "INSERT INTO order_transaction
    (order_id,event_id,no_of_tickets,original_price,purchased_price)
    VALUES
    ($order_id,'$item->event_id','$item->no_of_tickets','$item->original_price','$item->discount_price')";
    $mysqli->query($sql);

    $sql =
    "UPDATE event_master SET filled_seats = filled_seats + $no_of_tickets WHERE event_id = '$item->event_id'";
    $mysqli->query($sql);

    $sql =
    "DELETE FROM cart WHERE user_id = $user_id";
    $mysqli->query($sql);

  }
  $html .= '</table>';

  // echo($html); 
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title></title>
  </head>
  <body>
  <div class="text-center" style="margin-top: 40vh;">
  <div class="spinner-border" role="status" style="width: 5rem; height: 5rem;">
    <span class="sr-only"></span>
  </div>
</div>

    <!-- Optional JavaScript; choose one of the two! -->

    <!-- Option 1: Bootstrap Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

    <!-- Option 2: Separate Popper and Bootstrap JS -->
    <!--
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
    -->
  </body>
</html>
<script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.4.4/dist/sweetalert2.all.min.js"></script>
<script src="https://smtpjs.com/v3/smtp.js"> </script>
<script>
  Swal.fire({
            title: 'Success',
            text: 'Order Placed Successfully. Email Sent.',
            icon: 'success',
            // confirmButtonText: 'OK',
            showConfirmButton: false,
            timer: 3000
          }).then((result) => {
  Email.send({
                Host: "smtp.gmail.com",
                Username: "aakar.mutha18@gmail.com",
                Password: "asbqqgosscscnofb",
                Port: "587",
                To: "<?=$email_id?>",
                From: "finservevents@gmail.com",
                Subject: "Order Placed Successfully",
                Body: "<?=$html?>", 
              }).then(function() {
                // alert("Event link has")
                window.location.href = "invoice.php?order_id=<?=$order_id?>";
              });
            })

  // console.log("Im in the script");
</script>