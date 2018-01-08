<?php
session_start();
$now = date("YmdHis");
$_SESSION["demo"] = $now;
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
			<div class="col-sm-1 col-md-4 col-md-offset-4">
				<img class="profile-img" src="img/logo.png?" alt="">
				<h1 class="text-center login-title">account registration for demo@citcall.com</h1>
				<div class="account-wall">
					<img class="profile-img" src="img/laptop.png?" alt="">
					<p class="text-center">Enter your mobile number</p>
					<input class="form-control" type="tel" value="" name="cellNo" id="cellNo" onKeyUp="numberOnly(this)" autofocus required>
					<p class="help-block" style="display:none;">Please input cellphone number</p>
					<button class="full" id="btnSend" onclick="sendRequest()">Verify My Mobile</button>
				</div>
				<p class="text-center">For more info contact  <a href="mailto:info@citcall.com?Subject=Mail%20From%20Demo" target="_top">info@citcall.com</a></p>
			</div>
		</div>
	</div>
<script type="text/javascript">
	function numberOnly(ob) {
      var invalidChars = /[^0-9]/gi
      if(invalidChars.test(ob.value)) {
                ob.value = ob.value.replace(invalidChars,"");
          }
    }
	function sendRequest() {
		var cellNo = $("#cellNo").intlTelInput("getNumber");
		if ($("#cellNo").val().trim() == "") {
		  $( ".account-wall" ).addClass( "has-error" );
		  $(".help-block").show();
		  setTimeout(function(){ 
		    $( ".account-wall" ).removeClass( "has-error" );
			$(".help-block").hide(); 
		  }, 5000);
		} else {
			$.redirect("verification.php", {"cellNo": cellNo});
		}
	}
	function callback(code) {
	}
	$(document).ready(function(){
		$("#cellNo").intlTelInput({
			geoIpLookup: function (callback) {
				$.get("http://ipinfo.io", function () {}, "jsonp").always(function (resp){
					var countryCode = (resp && resp.country) ? resp.country : "";
					$("#cellNo").intlTelInput("setCountry", countryCode);
					callback(countryCode);
				});
			},
			initialCountry: "auto",
			onlyCountries: ['id', 'sg', 'cn', 'hk', 'my', 'th', 'ph', 'bn'],
			preferredCountries: ['id', 'sg'],
			separateDialCode: true,
			utilsScript: "js/intutils.js"
		});
		$("#cellNo").keypress(function(e){
			var key = e.which;
			if (key == 13) {
				$("#btnSend").click();
			return false;
			}
		});
	});
</script>
</body>
</html>