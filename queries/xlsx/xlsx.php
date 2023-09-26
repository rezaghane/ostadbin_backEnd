<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/xlsx/reserved_______________________________________
if($wch=='reserved'){
	require_once "./queries/xlsx/reserved.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
