<?php
session_start();
date_default_timezone_set('Asia/Jakarta');
header("Cache-Control: no-cache, must-revalidate");
if (!isset($_SESSION["demo"]) || $_SESSION["demo"] == ""){
  header("Location: index.php");
  exit();
}
if (!isset($_POST["cellNo"])) {
  header("Location: index.php");
  exit();
}
$cellNo = $_POST["cellNo"];
include "conn.php";
$today = date('Y-m-d');
$query_ip = "select count(id) as jml from hit_ip where ip = '$ipuser' and date(tanggal) = '$today'";
$get_stat = $conn->query($query_ip);
$row_main = $get_stat->fetch_assoc();
$jml_hit = $row_main['jml'];
// he we are cek limitation for a day
if($jml_hit > 200){
	echo "<script>
	alert('maximum limit is reached!');
	window.location.href = \"index.php\";
	</script>";
	exit();
}
$query_msisdn = "select count(id) as jml from hit_ip where msisdn = '$cellNo' and date(tanggal) = '$today'";
$get_stat_m = $conn->query($query_msisdn);
$row_main_m = $get_stat_m->fetch_assoc();
$jml_msisdn = $row_main_m['jml'];
// here we are cek maximum attempt
if($jml_msisdn > 9){
	echo "<script>
	alert('maximum limit is reached!');
	window.location.href = \"index.php\";
	</script>";
	exit();
}
session_destroy();
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
	<link rel="stylesheet" type="text/css" href="css/jquery-confirm.min.css"/>
    <script src="js/jquery-1.12.1.min.js" type="text/javascript" ></script>
    <script src="js/citcommon.js" type="text/javascript" ></script>
    <script src="js/jquery.jsonp-2.4.0.min.js" type="text/javascript" ></script>
    <script src="js/jquery.redirect.js" type="text/javascript"></script>
    <script src="js/sweetalert.min.js" type="text/javascript"></script>
    <script src="js/intlTelInput.min.js" type="text/javascript"></script>
    <script type="text/javascript" src="js/jquery-confirm.min.js"></script>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>
</head>
<body>
	<div id="loading" style="display:none">
      <img id="loading-image" src="img/Please_wait.gif" alt="Loading..." />
    </div>
	<div class="container">
		<div class="row">
			<div class="col-sm-6 col-md-4 col-md-offset-4">
				<img class="profile-img" src="img/logo.png?" alt="">
				<h1 class="text-center login-title">account registration for demo@citcall.com</h1>
				<div class="account-timeout" style="display:none">
					<p class="text-center">Haven't got miss-call yet? <a href="#" onclick='sendRequest()'>miss call me again</a></p>
				</div>
				<div class="account-wall">
					<img class="profile-img" src="img/idv_call.png?" alt="">
					<p class="text-center">We will misscall you at <?php echo $cellNo; ?> </p>
					<p class="text-center"><b>Complete the last 4 digit misscalled number</b></p>
					<input class="form-control" type="tel" value="" name="cellNo" id="cellNo" autofocus placeholder="input here" readonly required>
					<p class="help-block" style="display:none;">Wrong, please try again.</p>
					<button class="full" id="btnSend" onclick="verifyCode()">Verify</button>
				</div>
				<p class="text-center">For more info contact  <a href="mailto:info@citcall.com?Subject=Mail%20From%20Demo" target="_top">info@citcall.com</a></p>
			</div>
		</div>
	</div>
	<div class="jconfirm jconfirm-light jconfirm-open" style="display: none;">
		<div class="jconfirm-bg" style="transition-duration: 0.4s; transition-timing-function: cubic-bezier(0.36, 0.55, 0.19, 1);"></div>
		<div class="jconfirm-scrollpane">
			<div class="jconfirm-row">
				<div class="jconfirm-cell">
					<div class="jconfirm-holder" style="padding-top: 40px; padding-bottom: 40px;">
						<div class="jc-bs3-container container">
							<div class="jc-bs3-row row justify-content-md-center justify-content-sm-center justify-content-xs-center justify-content-lg-center">
								<div class="jconfirm-box-container jconfirm-animated col-md-4 col-md-offset-4 col-sm-6 col-sm-offset-3 col-xs-10 col-xs-offset-1 jconfirm-no-transition" style="transform: translate(0px, 0px); transition-duration: 0.4s; transition-timing-function: cubic-bezier(0.36, 0.55, 0.19, 1);">
									<div class="jconfirm-box jconfirm-hilight-shake jconfirm-type-default jconfirm-type-animated" role="dialog" aria-labelledby="jconfirm-box95442" tabindex="-1" style="transition-duration: 0.4s; transition-timing-function: cubic-bezier(0.36, 0.55, 0.19, 1); transition-property: all, margin;">
										<div class="jconfirm-closeIcon" style="display: none;">×</div>
										<div class="jconfirm-title-c" style="display: none;">
											<span class="jconfirm-icon-c"></span><span class="jconfirm-title"></span>
										</div>
										<div class="jconfirm-content-pane no-scroll" style="transition-duration: 0.4s; transition-timing-function: cubic-bezier(0.36, 0.55, 0.19, 1); height: 386px; max-height: 497px;"><div class="jconfirm-content" id="jconfirm-box95442">
											<center><div><img src="img/confirm.PNG"></div></center>
											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<script type="text/javascript" src="js/jquery.inputmask.bundle.js" charset="utf-8"></script>
	<script type="text/javascript" >
		var timeout = false, verified = false;
		var timeinterval;
		var trxId = "";
		var cellNo = "<?= $cellNo ?>";
		var trying = -1;
		var is_valid = 0;
		function sendRequest(){
			trying++;
			if (trying > 6) {
				return swal("Error", "Maximmum retries reached.", "error");
			}
			$(".jconfirm-open").show();
			$("#cellNo").attr("placeholder", "Please input the misscall number");
			$("#cellNo").attr("readonly", true);
			$.ajax({
				timeout: 120000,
				url: "misscallapi.php",
				data: {
					"cid": "<?php echo $_POST["cellNo"] ?>",
					"trying": trying,
					"spam_delay": 10
				},
				type: "POST",
				dataType: "json",
				success: function (data) {
					$(".jconfirm-open").hide();
					if (data.result == "Success") {
						$("#cellNo").attr("placeholder", "input here");
						$("#cellNo").attr("readonly", false);
						setTimeout(function(){ $(".account-timeout").show(); }, 20000);
						var first = data.first;
						var length = data.length;
						var maxlength = length.toString().length;
						trxId = data.trx_id;
						$("#cellNo").inputmask(first + " 9999",{
							placeholder: "x",
						});
						$('#cellNo').on('input', function() {
							var value = $('#cellNo').val();
							var res = value.replace("x", "");
							console.log('maxlenth: '+ res.length);
							console.log('res length : '+ res.length);
							var maxlenghtbaru = maxlength + 2;
							if (res.length == maxlenghtbaru) {
								console.log(value.length);
								verifyCode();
							}
						});
					} else {
						alert("Hi, Your network is busy or unreachable. Please retry & click Verify again.");
						$.redirect("index.php", {}, "GET");
					}
				},
				error: function (parsedjson, textStatus, errorThrown) {
					$(".jconfirm-open").hide();
					return swal("Error", JSON.stringify(parsedjson).responseText, "error");
					console.log("ERRO parsedJson: " + JSON.stringify(parsedjson));
				}
			});
		}
		function logMsisdn(msisdn){
			$.ajax({
				url: "catat_msisdn.php",
				data: {
					"msisdn": msisdn
				},
				type: "POST",
				success: function (data) {
					console.log('msisdn logged');
				},
				error: function (parsedjson, textStatus, errorThrown) {
				}
			});
		}
		function verifyCode(){
			var xtoken = $('#cellNo').val();
			var token = xtoken.replace(/[^A-Z0-9]/ig, "");
			$.ajax({
				url: "misscallval.php",
				data: {
					"trxid": trxId,
					"token": token
				},
				type: "POST",
				success: function (data) {
					if(!data.error){
						if(data.valid == "valid"){
							window.history.pushState('citcall demo', null, 'index.php');
							$('#cellNo').val('');
							$.redirect("success.php", {"cellNo": cellNo});
						}else{
							is_valid++;
							if(is_valid > 9){
								logMsisdn(cellNo);
								alert("Limit Try is reached !");
								$.redirect("index.php", {}, "GET");
							}else{
								$( ".account-wall" ).addClass( "has-error" );
								$(".help-block").show();
							}
						  setTimeout(function(){ 
							$( ".account-wall" ).removeClass( "has-error" );
							$(".help-block").hide(); 
						  },5000);
						}
					}else{
						alert("Error Occured when validation your token.");
					}
				},
				error: function(parsedjson, textStatus, errorThrown){
					console.log("ERRO parsedJson: " + JSON.stringify(parsedjson));
				}
			});
		}
		$(document).ready(function(){
			if(cellNo !== ""){
				sendRequest();
			}else{
				$.redirect("index.php", {}, "GET");
			}
			window.onpopstate = function(event) {
			    if(event && event.state) {
			        location.reload(); 
			    }
			}
		});
    </script>
</body>
</html>