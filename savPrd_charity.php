<?php
$url = $_SERVER['SERVER_NAME'];

require_once "connection.php";
require_once "jdf.php";
if($_SERVER['REQUEST_METHOD'] == 'POST'){
		$_POST = filter_input_array(INPUT_POST, FILTER_SANITIZE_STRING);
}
$data = array();
$sql = "";
$date = jdate("Y/n/d");
if($_GET['Status']=="OK"){
    $sql = "UPDATE `reserved` SET status=2, prdCod='".$_GET['Authority']."', discount='".$_GET["discount"]."' WHERE id IN (".$_GET['id'].")";
    $db->query($sql);
    $changed = $db->execute();
}
$url = ($_GET['mobile']==0) ? 'https' : 'ostadbin';
// ********************************************************************************************************
$sql = "SELECT 
teachers.fullname AS teacher, users.fullname AS user
FROM `reserved`
INNER JOIN users ON users.id = reserved.user
INNER JOIN teachers ON teachers.id = reserved.teacher
WHERE reserved.id IN (".$_GET['id'].")
ORDER BY reserved.id DESC
LIMIT 1 ";
$db->query($sql);
$data = $db->resultSet();

$_POST['txt'] = 
"یک درخواست در تاریخ " . 
jdate("Y/n/d") . 
" ساعت " . 
date("H:i") . 
" توسط ".
$data[0]->user.
" برای مدرس " . 
$data[0]->teacher . 
" در سامانه استادبین ثبت شد ";

$_POST['phn'] = "09121892029";
$phn = "98".substr($_POST['phn'], 1);
require  './vendor/autoload.php';
$sender = "10004444000404";
$receptor = $phn;
$message = $_POST['txt'];
$api = new \Kavenegar\KavenegarApi("31564E616558544B6D4536664749623139743362386646792F7131556B6E3778695A7439547868626968733D");
$api->Send($sender,$receptor,$message);

// ********************************************************************************************************
Header('Location: '.$url.'://www.ostadbin.ir/reserved/'.$_GET['id']);
?>