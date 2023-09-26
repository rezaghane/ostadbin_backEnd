<?php
if(isset($_POST['txt']) && isset($_POST['phn'])){
	$phn = "98".substr($_POST['phn'], 1);
	require  './vendor/autoload.php';
	$sender = "10004444000404";
	$receptor = $phn;
	$message = $_POST['txt'];
	$api = new \Kavenegar\KavenegarApi("31564E616558544B6D4536664749623139743362386646792F7131556B6E3778695A7439547868626968733D");
	$api->Send($sender,$receptor,$message);
	echo "pk";
}
?>
