<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link type="text/css" href="./vendor/sweetalert2/dist/sweetalert2.min.css" rel="stylesheet">
 
    <link rel="stylesheet" href="./vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" href="./volt/css/volt.css">
<script src="./vendor/sweetalert2/dist/sweetalert2.min.js" type="text/javascript"></script>
</head>
<body>

<script>
        function alertMessage(msg,path,buttonText){
            Swal.fire({
                title: msg,
                confirmButtonText: buttonText,
              }).then((result) => {
                /* Read more about isConfirmed, isDenied below */
                location.href = path;
              });
        }
            
</script>
<?php
    if(!isset($_GET['user_id']) || !isset($_GET['event_id'])){
        die("<script>location.replace('./404.html')</script>");
    }
    $user_id = $_GET['user_id'];
    $event_id = $_GET['event_id'];

    require_once "admin/pdo.php";

    $stmt = $pdo->query(
        "SELECT *
        FROM event_transaction
        WHERE user_id = '$user_id' AND event_id = '$event_id' ");
        $count = $stmt->fetchColumn();
        if($count == 0){
            echo "<script>alertMessage('You have not registered for this event','event.php?eventid=$event_id','Go to event page')</script>";
            die();
        }

    $stmt = $pdo->query(
        "SELECT *
        FROM event_transaction
        WHERE user_id = '$user_id' AND event_id = '$event_id' AND in_event = 1 ");
        $count = $stmt->fetchColumn();
        if( $count > 1){
            //the user is registered fo that event
            $stmt = $pdo->query(
                "SELECT event_link
                FROM event_master 
                WHERE event_id = '$event_id' ");
            $res = $stmt->fetch(PDO::FETCH_ASSOC);

            header('Location: '. $res['event_link']);
        }
        else{
            // die('Sorry you are in the queue for the event')
            echo "<script>alertMessage('Sorry you are in the queue for the event','index.php','Go to Home Page')</script>";
        }
?>

</body>

</html>
