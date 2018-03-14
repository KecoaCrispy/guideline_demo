<?php
/*
* This file for making miscall request to citcall.
* Read http://docs.citcall.com
*/
ini_set('max_execution_time', 60);
if(!isset($_POST["cid"]) || !isset($_POST["trying"])){
  header("location: index.php");
}
include "conn.php";
$msisdn = $_POST["cid"];
$base_url = 'http://104.199.196.122/gateway';
$version = '/v1';
$action = '/call';
$url = $base_url . $version . $action ;

$data = array(
    "userid" => "USERNAME",
	"password" => "PASSWORD",
    "msisdn" => $msisdn,
    "gateway" => $_POST["trying"]
);

$content = json_encode($data);
$curl = curl_init($url);
curl_setopt($curl, CURLOPT_CUSTOMREQUEST, "POST");
curl_setopt($curl, CURLOPT_POSTFIELDS, $content);
curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
curl_setopt($curl, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/json',
    'Content-Length: ' . strlen($content))
);
$response = curl_exec($curl);
$err  = curl_error($ch);
curl_close($curl);
$ret = array();
if ($err) {
	$ret['result'] = "Failed";
  echo 'cURL Error #:'. $err;
} else {
	$res = json_decode($response);
	$rc = $res->rc;
	if($rc == "00"){
		$date_now = date('Y-m-d H:i:s');
		$trx_id = $res->trx_id;
		$token = $res->token;
		$first = substr($token,0,-4);
		$last = substr($token, -4);
		$length = strlen($token);
		$query_log = "insert into log_miscall (date,msisdn,trx_id,token,is_aktive) values ('$date_now','$msisdn','$trx_id','$token',1)";
		$conn->query($query_log);

		$ret['trx_id'] = $trx_id;
		$ret['first'] = $first;
		$ret['panjang'] = $length;
		$ret['result'] = "Success";
	}else{
		$ret['result'] = "Failed";
	}
}
echo json_encode($ret);
exit();









