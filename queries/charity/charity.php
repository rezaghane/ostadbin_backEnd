<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/charity/save__________________________________________________
if($wch=='save' && isset($_POST['val'])){
	require_once "./queries/charity/save.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
