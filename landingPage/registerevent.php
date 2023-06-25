<script src="https://smtpjs.com/v3/smtp.js"> </script>
    <script>
        function sendEmail(to,event_link) {
	// var email = $("#email").val().trim();
	// var name = $("#name").val().trim();
	// var text = $("#text").val().trim();
	// var num = $("#pnum").val().trim();

// Password: "pydnzfifywbrxaaz",
			// Username: "finservevents@gmail.com",
		Email.send({
			Host: "smtp.gmail.com",
			Username: "aakar.mutha18@gmail.com",
			Password: "asbqqgosscscnofb",
			Port: "587",
			To: to,
			From: "finservevents@gmail.com",
			Subject: "Event registration link",
			Body: "Thank you for registering. Here is the event link: \n"+event_link,
			})
			.then(function () {
				// alert("Event link has")
				
			});

}
</script>
<?php
require_once '../config.php';

$event_id = $_GET['event_id'];
$user_id = $_GET['user_id'];

$sql5 = "SELECT * FROM event_transaction WHERE user_id = '$user_id' AND event_id = '$event_id'";
$res5 = mysqli_query($conn, $sql5);
if($res5->num_rows == 0){
$sql = "INSERT INTO event_transaction(event_id, user_id) VALUES ($event_id, $user_id)";
$res = mysqli_query($conn, $sql);

$sql = "SELECT email_id FROM user_master WHERE user_id = $user_id";
// echo $sql;
$res2= mysqli_query($mysqli, $sql);

$email = $res2->fetch_assoc();
$email = $email['email_id'];

$sql = "SELECT event_name FROM event_master WHERE event_id = $event_id";
// echo $sql;
$res3= mysqli_query($mysqli, $sql);

$event_name = $res2->fetch_assoc();
// var_dump($email);
$event_name = $event_name['event_name'];
if(isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on')   
         $url = "https://";   
    else  
         $url = "http://";   
    // Append the host(domain name, ip) to the URL.   
    $url.= $_SERVER['HTTP_HOST'];  
	$url.= "/email_redirect.php?user_id=$user_id&event_id=$event_id";
echo "
<script>
    sendEmail('$email','$url');
	location.href = '../event/index.php?registered=1&eventid=$event_id&fresh=1';
</script>";
}else{
	echo "<script>location.href = '../event/index.php?alreadyregistered=1&eventid=$event_id';</script>";
}
?>