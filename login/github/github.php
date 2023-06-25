<?php
session_start();
$code = $_GET['code'];
// To get access token from github
$url = "https://github.com/login/oauth/access_token";
echo $code;
$curl = curl_init();
curl_setopt($curl, CURLOPT_URL, $url);
curl_setopt($curl, CURLOPT_POST, true);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);

$headers = array(
   "Accept: application/json",
   "Content-Type: application/json",
);
curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);

// "client_id":"6b80ef155241be9adb31",
//   "redirect_uri":"http://ec2-18-233-157-142.compute-1.amazonaws.com/login/github/github.php",
//   "client_secret":"1eb6f3e564b5b11b5d4ebe3b52f49548e4bd49c9",

// "client_id":"544df1bb709d379d3aec",
  // "redirect_uri":"http://localhost:8888/login/github/github.php",
  // "client_secret":"aacd9419fd8c5a9bbf5c5810fd61d0ab813a6ffa",
$data = <<<DATA
{
  "client_id":"6b80ef155241be9adb31",
  "redirect_uri":"http://ec2-13-235-76-10.ap-south-1.compute.amazonaws.com/login/github/github.php",
  "client_secret":"1eb6f3e564b5b11b5d4ebe3b52f49548e4bd49c9",
    "code":"$code"
  }
DATA;

curl_setopt($curl, CURLOPT_POSTFIELDS, $data);

$resp = curl_exec($curl);
$respd = json_decode($resp);
// var_dump($resp);
$access_token = $respd->access_token;
// var_dump($access_token);

// To get user details from github
$encoded_access_token = base64_encode("username:$access_token");
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.github.com/user',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array(
    "Authorization: Basic $encoded_access_token",
    'Cookie: _octo=GH1.1.291986463.1645186576; logged_in=no',
    "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36",
  ),
));

$response = curl_exec($curl);
$response = json_decode($response);
$name = $response->name;
// var_dump($response);


// To get user email id from github.
curl_setopt_array($curl, array(
  CURLOPT_URL => 'https://api.github.com/user/emails',
  CURLOPT_RETURNTRANSFER => true,
  CURLOPT_ENCODING => '',
  CURLOPT_MAXREDIRS => 10,
  CURLOPT_TIMEOUT => 0,
  CURLOPT_FOLLOWLOCATION => true,
  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
  CURLOPT_CUSTOMREQUEST => 'GET',
  CURLOPT_HTTPHEADER => array( 
"Authorization: Basic $encoded_access_token",
  'Cookie: _octo=GH1.1.291986463.1645186576; logged_in=no',
  "User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/70.0.3538.77 Safari/537.36",
),
));

$response = curl_exec($curl);

curl_close($curl);
echo "<br>";
$response = json_decode($response);
// var_dump($response);
$email;
foreach ($response as $key => $value) {
  if($value->primary == true){
    $email = $value->email;
  }
}
// echo $email;
// var_dump($email);
$_SESSION['email'] = $email;
$_SESSION['name'] = $name;
// $_SESSION['signup_method'] = "github";

// var_dump($_SESSION);
// echo "<script>
// localStorage.setItem('name', ' $name');
// localStorage.setItem('email', ' $email');
// window.location.href = '../addmobile.php
// </script>";
header("Location: ../addmobile.php");

// window.location.href = '../addmobile.php';
// 
// exit;

?>