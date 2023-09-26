<?php
$url = $_SERVER['SERVER_NAME'];
session_start();
$_SESSION["id"] = isset($_GET["id"]) ? $_GET["id"] : '0';
$_SESSION["mobile"] = isset($_GET["mobile"]) ? $_GET["mobile"] : '0';
$_GET["discount"] = isset($_GET["discount"]) ? $_GET["discount"] : '0';
require_once "connection.php";
$data = array();

$sql = "SELECT sum(price) AS mny, ismobile FROM reserved WHERE id in (".$_SESSION["id"].")";
$db->query($sql);
$data = $db->resultSet();

$sql = "SELECT percentage FROM discount WHERE id in (".$_GET["discount"].")";
$db->query($sql);
$discount = $db->resultSet();
$percentage = 0;
if(sizeof($discount)>0){
	$percentage = $discount[0]->percentage;
}

$MerchantID = 'bbc9880d-cf56-423f-a31e-815d8892b0ed'; //Required
$Amount = (($data[0]->mny) - ($data[0]->mny * $percentage / 100));
$Description = ''; // Required
$Email = ''; // Optional
$Mobile = ''; // Optional
$CallbackURL = 'http://'.$url.'/api_UTadris/savPrd.php?id='.$_SESSION["id"].'&mobile='.$_SESSION["mobile"]."&discount=".$_GET["discount"];
$client = new SoapClient('https://www.zarinpal.com/pg/services/WebGate/wsdl', ['encoding' => 'UTF-8']);

$result = $client->PaymentRequest(
[
	'MerchantID' => $MerchantID,
	'Amount' => $Amount,
	'Description' => $Description,
	'Email' => $Email,
	'Mobile' => $Mobile,
	'CallbackURL' => $CallbackURL,
]
);

//Redirect to URL You can do it also by creating a form
if ($result->Status == 100) {
	Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority);
	//برای استفاده از زرین گیت باید ادرس به صورت زیر تغییر کند:
	//Header('Location: https://www.zarinpal.com/pg/StartPay/'.$result->Authority.'/ZarinGate');
} else {
	Header('Location: ' . $CallbackURL . '&Status=OK');
}
?>
