<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/user/address________________________________________
if($wch=='address'){
	require_once "./queries/user/address.php";
}
//__________________________________________/user/check________________________________________
if($wch=='check'){
	require_once "./queries/user/check.php";
}
//__________________________________________/teachers/:id____________________________________________
else{
	require_once "./queries/user/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
