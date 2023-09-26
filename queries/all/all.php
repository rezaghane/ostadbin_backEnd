<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________ /all/public _______________________________________
if($wch=='public'){
	// $cod = 400;
	require_once "./queries/all/publicData.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
