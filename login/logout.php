<?php
include('./google/glogin.php');
//Reset OAuth access token
$google_client->revokeToken();
//Destroy entire session data.
session_destroy();
//redirect page to index.php
unset($_SESSION['access_token']);
unset($_SESSION['state']);

// Remove user data from session
unset($_SESSION['userData']);
// unset cookies
if (isset($_SERVER['HTTP_COOKIE'])) {
  $cookies = explode(';', $_SERVER['HTTP_COOKIE']);
  foreach($cookies as $cookie) {
      $parts = explode('=', $cookie);
      $name = trim($parts[0]);
      setcookie($name, '', time()-1000);
      setcookie($name, '', time()-1000, '/');
  }
}

?>
<script async defer crossorigin="anonymous" src="https://connect.facebook.net/en_US/sdk.js">
FB.logout(function(response) {
  // user is now logged out
});
</script>
<script>
localStorage.clear();
window.location.href = '../../';

</script>

