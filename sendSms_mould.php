<?php
$val = base64_decode($_POST['val']);
//$val = "09378444550~0101~ostadbinotp";
$arr = explode("~", $val);



$url ="https://api.kavenegar.com/v1/31564E616558544B6D4536664749623139743362386646792F7131556B6E3778695A7439547868626968733D/verify/lookup.json?receptor=".$arr[0]."&token=".$arr[1]."&template=".$arr[2];

$ch = curl_init();

curl_setopt($ch, CURLOPT_URL, $url);
curl_setopt($ch, CURLOPT_HEADER, 0);

curl_exec($ch);

curl_close($ch);



/*
if(isset($_POST['txt']) && isset($_POST['phn'])){
	$phn = "98".substr($_POST['phn'], 1);
	require  './vendor/autoload.php';
	$sender = "10004444000404";
	$receptor = $phn;
	$message = $_POST['txt'];
	$api = new \Kavenegar\KavenegarApi("31564E616558544B6D4536664749623139743362386646792F7131556B6E3778695A7439547868626968733D");
	$api->Send($sender,$receptor,$message);
	echo "pk";
}*/
?>
