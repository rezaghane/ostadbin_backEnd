<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/self/account________________________________________
if($wch=='account'){
	require_once "./queries/self/account.php";
}
//__________________________________________/self/setpass________________________________________
else if($wch=='setpass'){
	require_once "./queries/self/setpass.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
