<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/account/login__________________________________________________
if($wch=='login' && isset($_POST['username']) && isset($_POST['password'])){
	require_once "./queries/account/login.php";
}
//__________________________________________/account/signup__________________________________________________
else if($wch=='signup'){
	require_once "./queries/account/signup.php";
}
//__________________________________________/account/recover__________________________________________________
else if($wch=='recover'){
	require_once "./queries/account/recover.php";
}
//__________________________________________/account/recover__________________________________________________
else if($wch=='duplicate'){
	require_once "./queries/account/duplicate.php";
}
//__________________________________________/account/recover__________________________________________________
else if($wch=='recovery'){
	require_once "./queries/account/recovery.php";
}
//__________________________________________/account/recover__________________________________________________
else if($wch=='oneTimePassword'){
	require_once "./queries/account/oneTimePassword.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
