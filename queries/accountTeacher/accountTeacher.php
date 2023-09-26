<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/accountTeacher/signup__________________________________________________
if($wch=='signup'){
	require_once "./queries/accountTeacher/signup.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
