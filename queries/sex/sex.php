<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/category/list_______________________________________
if($wch=='list'){
	require_once "./queries/sex/list.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
