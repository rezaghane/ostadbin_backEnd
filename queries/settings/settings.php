<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/settings/list_______________________________________
if($wch=='list'){
	require_once "./queries/settings/list.php";
}
//__________________________________________/settings/:id________________________________________
else{
	require_once "./queries/settings/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
