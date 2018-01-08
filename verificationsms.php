<?php
if (!isset($_POST["authid"])) {
  header("Location: index.php");
}
$cellNo = $_POST["cellNo"];
$authid = $_POST["authid"];
?>
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CITCALL Demo -Verification </title>

    <link rel="stylesheet" href="css/bootstrap.min.css" >
    <link rel="stylesheet" href="css/font-awesome.min.css" >
    <link rel="stylesheet" href="css/sweetalert.css" >
    <script src="js/jquery-1.12.1.min.js" type="text/javascript" ></script>
    <script src="js/citcommon.js" type="text/javascript" ></script>
    <script src="js/jquery.jsonp-2.4.0.min.js" type="text/javascript" ></script>
    <script src="js/jquery.redirect.js" type="text/javascript"></script>
    <script src="js/sweetalert.min.js" type="text/javascript"></script>
    <link href='http://fonts.googleapis.com/css?family=Montserrat:400,700' rel='stylesheet' type='text/css'>

    <style>
      body {
        background-size: cover;
        background-color: #000000;
        font-family: Montserrat;
        font-size: 12px;
      }

      .logo {
        width: 213px;
        height: 36px;
        margin: 30px auto;
      }

      .login-block {
        width: 320px;
        padding: 20px;
        background: #fff;
        border-radius: 5px;
        border-top: 5px solid #ff656c;
        margin: 0 auto;
      }

      .login-block h1 {
        text-align: center;
        color: #000;
        font-size: 18px;
        text-transform: uppercase;
        margin-top: 0;
        margin-bottom: 20px;
      }

      .login-block input {
        width: 100%;
        height: 42px;
        box-sizing: border-box;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        font-size: 14px;
        font-family: Montserrat;
        padding: 0 20px 0 50px;
        outline: none;
      }

      .login-block input#cellNo {
        background: #fff url('img/username_icons.png') 20px top no-repeat;
        background-size: 16px 80px;
      }

      .login-block input#cellNo:focus {
        background: #fff url('img/username_icons.png') 20px bottom no-repeat;
        background-size: 16px 80px;
      }

      .login-block input:active, .login-block input:focus {
        border: 1px solid #ff656c;
      }

      .login-block button {
        width: 100%;
        height: 40px;
        background: #ff656c;
        box-sizing: border-box;
        border-radius: 5px;
        border: 1px solid #e15960;
        color: #fff;
        font-weight: bold;
        text-transform: uppercase;
        font-size: 14px;
        font-family: Montserrat;
        outline: none;
        cursor: pointer;
      }

      .login-block button:hover {
        background: #ff7b81;
      }

    </style>
  </head>
  <body>

    <div class="logo"></div>
    <div id="cpage" class="login-block" style="text-align: center;">
      <h1>Citcall Demo </h1>
      <span style="text-align: center;display: inline-block; font-size: 12px;">Please insert verification number</span><br>
      <span style="text-align: center;display: inline-block; font-size: 12px;">which sent to  <?php echo $cellNo ?></span><br>
      <input type="text" value="" placeholder="Verification Code" name="verifyCode" id="verifyCode" required />
      <button onclick="sendRequest()">Verify</button>
      <h1 id="clock" style="text-align: center;"></h1>
      <h1 id="verspan" style="text-align: center;"></h1>
    </div>
    <div id="vpage" class="login-block" style="text-align: center;display: none;">
      <h1>Citcall Demo</h1>
      <span style="text-align: center;display: inline-block;"><?= $cellNo ?> has been verified</span><br>
      <img alt="verified" src="img/verified.png"  />
      <button onclick="location.href = 'index.php'">Home</button>
    </div>
    <div id="uvpage" class="login-block" style="text-align: center;display: none;">
      <h1>Citcall Demo</h1>
      <span style="text-align: center;display: inline-block;"><?= $cellNo ?> failed to verify</span><br><br>
      <img alt="unverified" width="277px" height="300px" src="img/unverified.png"  /><br>
      <button onclick="tryAgain()">Try Again</button>
    </div>
    <script type="text/javascript" >
      var verified = false;
      var timeinterval;
      var cellNo = "<?= $cellNo ?>";
      function sendRequest() {
        $.ajax({
          url: "smsval.php",
          data: {
            "msisdn": "<?= $cellNo ?>",
            "code": $("#verifyCode").val().trim(),
            "authid": "<?= $authid ?>",
            "spam_delay": 10
          },
          type: "POST",
          success: function (data) {
            if (data.valid == "valid") {
              $("#cpage").hide();
              $("#vpage").show();
              $("#uvpage").hide();
              clearInterval(timeinterval);
              $("#clock").hide();
              verified = true;
              swal("Congratulation your data has been verified.");
              $("#verspan").html("Congratulation your data has been verified.").css("color", "blue");
            } else {
              swal("Invalid verification code");
              $("#verifyCode").focus();
            }
          },
          error: function (parsedjson, textStatus, errorThrown) {
            alert("Error occurred when validating code");
          }
        });
      }
      function startTimer() {
        var i = 0;
        var startDate = new Date();
        var endDate = new Date((startDate.getTime() + (5 * 60000)));
//        console.log(endDate);
//        console.log(getTimeRemaining(endDate));
        function getTimeRemaining(endtime) {
          var t = Date.parse(endtime) - Date.parse(new Date());
          var seconds = Math.floor((t / 1000) % 60);
          var minutes = Math.floor((t / 1000 / 60) % 60);
          return {
            'total': t,
            'minutes': ("0" + minutes).slice(-2),
            'seconds': ("0" + seconds).slice(-2)
          };
        }
        function updateClock() {
          i++;
          var t = getTimeRemaining(endDate);
          $("#clock").html("Time left: 00:" + t.minutes + ":" + t.seconds);
          // console.log(t);
          if (t.total <= 0 || verified) {
            clearInterval(timeinterval);
            if (!verified) {
              $("#cpage").hide();
              $("#vpage").hide();
              $("#uvpage").show();
              $("#verspan").html("We're sorry that you run out time and failed to verify").css("color", "red");
            } else if (verified) {
              $("#cpage").hide();
              $("#vpage").show();
              $("#uvpage").hide();
              $("#clock").hide();
              $("#verspan").html("Congratulation your data has been verified.").css("color", "blue");
            }
          }
        }
        updateClock(); // run function once at first to avoid delay
        timeinterval = setInterval(updateClock, 1000);
        // var checkDataInterval = setInterval(checkMisscall(did,tid),2000);
      }

      function tryAgain() {
//        location.reload(true);
        $("#verspan").html("");
        $("#cpage").show();
        $("#vpage").hide();
        $("#uvpage").hide();
        $("#verifyCode").focus();
        startTimer();
      }
      $(document).ready(function () {
        if (cellNo !== "") {
          $("#cpage").show();
          $("#vpage").hide();
          $("#uvpage").hide();
          $("#verifyCode").focus();
          startTimer();
        } else {
          $.redirect("index.php", {}, "GET");
        }
      });
    </script>
  </body>
</html>