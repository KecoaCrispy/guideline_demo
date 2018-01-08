
<!DOCTYPE html>
<html>
  <head>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>CITCALL Demo -Verification </title>

    <link rel="stylesheet" href="css/sweetalert.css" />
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
        /*width: 100%;*/
        height: 42px;
        box-sizing: border-box;
        border-radius: 5px;
        border: 1px solid #ccc;
        margin-bottom: 20px;
        font-size: 14px;
        font-family: Montserrat;
        padding: 0 2px 0 11px;
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

      .home{
        width: 50%;
        height: 20px;
        background: #3333ff;
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

      .home:hover {
        background: #ccccff;
      }
      #loading {
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
        position: fixed;
        display: block;
        opacity: 0.69;
        background-color: #fff;
        z-index: 99;
        text-align: center;
      }

      #loading-image {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        margin: auto;
      }
      #loading1 {
        width: 100%;
        height: 100%;
        top: 0px;
        left: 0px;
        position: fixed;
        display: block;
        opacity: 0.99;
        background-color: #fff;
        z-index: 99;
        text-align: center;
      }

      #loading-image1 {
        position: absolute;
        left: 0;
        top: 0;
        right: 0;
        bottom: 0;
        margin: auto;
      }
      #loading-text {
        position: absolute;
        left: 0;
        top: 50%;
        right: 0;
        bottom: 0;
        margin-top: -55px;
      }
    </style>
  </head>
  <body>

    <div id="loading" style="display:none">
      <img id="loading-image" src="img/loader-64.gif" alt="Loading..." />
      <span id="loading-text" style="color: blue;font-size: 16px;">please wait, your number will be missed call by a 5 digit caller ID</span>
    </div>
    <div id="loading1" style="display:none">
      <img id="loading-image1" src="img/loader-64.gif" alt="Loading..." />
    </div>
    <div class="logo"></div>
    <div id="cpage" class="login-block" style="text-align: center;display: none">
      <h1>Citcall Demo </h1>
      <span style="text-align: center;display: inline-block;font-size: 12px;">Thank you for trying misscall verification</span><br>
      <span style="text-align: center;display: inline-block; font-weight: bold;font-size: 12px;">please wait while we make a call to<br></span>
      <!-- <h1 id="mnumber" style="text-align: center; color: blue"></h1> -->
      <div><a id="mnumber" href=""></a></div>
      <h1 id="clock" style="text-align: center;font-size: 12px;"></h1>
      <span style="text-align: center;display: inline-block;color: #3300ff;">Trying sms verification instead<br></span>
      <button onclick="sendRequestSms()">SMS Verification</button>
    </div>
    <div id="verpage" class="login-block" style="text-align: center;">
      <h1>Citcall Demo </h1>
      <span style="text-align: center;display: inline-block; font-size: 12px;">Please insert 5 digit number been miss called to your phone</span><br>

      <!--<input type="text" value="" placeholder="5 digit verification code" name="verifyCode" id="verifyCode"  autocomplete="off" required />-->
	  <div class="inputan">
	  +62213001 
		  <input id="input1" type="text" size="1" maxlength="1" autofocus >-
		  <input id="input1" type="text" size="1" maxlength="1">-
		  <input id="input1" type="text" size="1" maxlength="1">-
		  <input id="input1" type="text" size="1" maxlength="1">
	  </div>
      <button onclick="verifyCode()">Verify</button>
      <div>&nbsp;</div>
      <button id="btnSend" onclick="sendRequest()">Retry</button>
      <span style="text-align: center;display: inline-block; font-size: 12px;color: blue;">if you're not receiving any call, please retry</span><br>
      <!--      <div>&nbsp;</div>
            <span style="text-align: center;display: inline-block;color: #3300ff;">Not receiving any code? Trying sms verification instead<br></span>
            <button onclick="sendRequestSms()">SMS Verification</button>-->
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
      <img alt="unverified" width="277px" height="300px" src="img/unverified.png"  /><br/>
      <button onclick="tryAgain()">Try Again</button>
    </div>

    <script type="text/javascript" >
      

      $(document).ready(function () {
        
		//
		var container = document.getElementsByClassName("inputan")[0];
		container.onkeyup = function(e) {
			var target = e.srcElement;
			var maxLength = parseInt(target.attributes["maxlength"].value, 10);
			var myLength = target.value.length;
			console.log(e.which);
			if(myLength == 0 && e.which == 8 || e.which == 46){
				var prev = target;
				while (prev = prev.previousElementSibling) {
					if (prev == null)
						break;
					if (prev.tagName.toLowerCase() == "input") {
						prev.focus();
						break;
					}
				}
			}else if (myLength >= maxLength) {
				var next = target;
				while (next = next.nextElementSibling) {
					if (next == null)
						break;
					if (next.tagName.toLowerCase() == "input") {
						next.focus();
						break;
					}
				}
			}
		}
      });
    </script>
  </body>
</html>