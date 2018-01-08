<?php
date_default_timezone_set('Asia/Jakarta');
$msisdn = $_POST['msisdn'];
include "conn.php";
$tgljm = date('Y-m-d H:i:s');
$query_ip_m = "insert into hit_ip (tanggal,ip,msisdn) values ('$tgljm','$ipuser','$msisdn')";
$data = $conn->query($query_ip_m);
if($data){
	echo 1;
}else{
	echo 0;
}
exit();
?>