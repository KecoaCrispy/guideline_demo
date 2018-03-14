<?php
if (!isset($_POST["trxid"]) || !isset($_POST["token"])) {
	header("location: index.php");
}
include "conn.php";
$trxid = $_POST["trxid"];
$token = $_POST["token"];
if($trxid==""||$token==""){
	header("location: index.php");
}
header("Content-Type: application/json");
$today = date('Y-m-d');
$query_ip = "select count(id) as jml from log_miscall where trx_id = '$trxid' and token = '$token' and is_aktive = 1";
$get_stat = $conn->query($query_ip);
$row_main = $get_stat->fetch_assoc();
$jml = $row_main['jml'];


if($jml > 0){
	$valid="valid";
}else{
	$valid="invalid";
}

$resp = array(
	"error" => FALSE,
	"valid" => $valid
);
echo json_encode($resp);
exit();