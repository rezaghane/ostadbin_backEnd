<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/location/highlights _______________________________________
if($wch=='highlights'){
	require_once "./queries/location/highlights.php";
}
//__________________________________________/location/list _____________________________________________
else if($wch=='list'){
	require_once "./queries/location/list.php";
}
//__________________________________________ END _______________________________________________________
require_once "echoJson.php";
?>
