<?php
date_default_timezone_set('Asia/Jakarta');
if (!isset($_POST["cellNo"])) {
  header("Location: index.php");
  exit();
}

$cellNo = $_POST["cellNo"];

include "conn.php";
$tgljm = date('Y-m-d H:i:s');
$query_ip_m = "insert into hit_ip (tanggal,ip,msisdn) values ('$tgljm','$ipuser','$cellNo')";
$conn->query($query_ip_m);
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<link rel="stylesheet" href="css/bootstrap.min.css" />
    <link rel="stylesheet" href="css/font-awesome.min.css" />
    <link rel="stylesheet" href="css/sweetalert.css" />
    <link rel="stylesheet" href="css/intlTelInput.css" />
    <link rel="stylesheet" href="css/style.css" />
    <script src="js/jquery-1.12.1.min.js" type="text/javascript" ></script>
    <script src="js/citcommon.js" type="text/javascript" ></script>
    <script src="js/jquery.jsonp-2.4.0.min.js" type="text/javascript" ></script>
    <script src="js/jquery.redirect.js" type="text/javascript"></script>
    <script src="js/sweetalert.min.js" type="text/javascript"></script>
    <script src="js/intlTelInput.min.js" type="text/javascript"></script>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<a href="index.php"><img class="profile-img" src="img/logo.png?" alt=""></a>
				<!--<h1 class="text-center login-title">account registration for demo@citcall.com</h1>-->
				<p class="text-center">Thank you for using citcall system demo</p>
				<p class="text-center">Contact us <a href="mailto:info@citcall.com?Subject=Mail%20From%20Demo" target="_top">info@citcall.com</a> for more info</p>
				<div class="account-wall">
					<img class="profile-img" src="img/verified.png?" alt="">
					<!--<p class="text-center">Enter your mobile number</p>
					<input class="form-control" type="tel" value="" name="cellNo" id="cellNo" required>
					<button class="full" id="btnSend" onclick="sendRequest()">Verify My Mobile</button>-->
				</div>
				<!--<p class="text-center">For more info contact  <a href="mailto:info@citcall.com?Subject=Mail%20From%20Demo" target="_top">info@citcall.com</a></p>-->
			</div>
		</div>
	</div>
</body>
</html>