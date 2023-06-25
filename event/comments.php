<?php 
require_once ("../config.php");
// session_start();
?>
<html>

<head>
	<link rel="stylesheet" href="./assets/css/style.css" />
	<!-- <link rel="stylesheet" href="./assets/css/bootstrap.min.css" /> -->
	<!-- <title>PHP Comment System with Like Unlike</title> -->
	<script src="./assets/js/jquery-3.2.1.min.js"></script>
	<!-- <script src="https://code.jquery.com/jquery-3.6.0.min.js" integrity="sha256-/xUj+3OJU5yExlq6GSYGSHk7tPXikynS7ogEvDej/m4=" crossorigin="anonymous"></script> -->
	<style>
	</style>

<body style="background: #ededed;">
	<div class="container">
		<div class="comment-form-container pt-0">
			<form id="frm-comment">
				<div class="input-row">
					<input type="hidden" name="comment_id" id="commentId" placeholder="Name" />
				</div>
				<div class="input-row">
					<textarea onkeydown="checkEmptyValue()" onkeyup="checkEmptyValue()" class="form-control" style="border-radius: 10px;" type="text" name="comment" id="comment" placeholder="Add a Comment" required></textarea>
				</div>
				<div onclick="clickDisabled();">
					<input type="button" class="btn btn-primary" id="submitButton" value="Add Comment" />
					<div id="comment-message">Comments Added Successfully!</div>
				</div>
			</form>
		</div>
		<div id="output"></div>
</div>
	
	<script>
		<?php 
			if(isset($_COOKIE['user_id'])){
				echo "var userid = ".$_COOKIE['user_id'].";";
			} else {
				echo "var userid = 0;";
			}
				?>

		function clickDisabled(){
			if(userid==0){
				Swal.fire({
                html: '<iframe height="625" width="375" loading="lazy" id="loginframe" style="margin:0 auto" src="../login/login_modal.php?popup=1" title="Login"></iframe>',
                showCancelButton: false,
                showCloseButton: false,
                showConfirmButton: false,
                width: 375
            })
			$("#loginframe").on('load', function () { // console.log('loaded');
                if ($(this).contents()[0].location.pathname == "/login/loginsuccess.php") { // console.log('logged in');
                    setTimeout(function () {
                        location.reload();
                    }, 1500);

                }

            });
			}
		}
		if(userid==0){
			// document.getElementById('submitButton').disabled = true;
			document.getElementById('comment').disabled = true;
			document.getElementById("comment").value = "Login to add comments";
		}
		
		// document.getElementById('comment').style = "visibility: hidden";
		// document.getElementById('submitButton').style = "visibility: hidden";
		// document.getElementById('comment').style = "display: none";
		// document.getElementById('submitButton').style = "display:none";
		

		if(userid > 0){
				document.getElementById('comment').style = "visibility: visible";
				document.getElementById('submitButton').style = "visibility: visible";
				document.getElementById('submitButton').disabled = true;

			}
		
			function checkEmptyValue(){
				if (document.getElementById('comment').value.length > 0) {
					document.getElementById('submitButton').disabled = false;
					
				} else {
					document.getElementById('submitButton').disabled = true;	
				}
			}


	</script>
	<script src="./assets/js/main.js"></script>

</body>

</html>