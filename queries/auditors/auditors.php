<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/auditors/list_______________________________________
if($wch=='list'){
	require_once "./queries/auditors/list.php";
}
//__________________________________________/auditors/create______________________________________
else if($wch=='create'){
	require_once "./queries/auditors/create.php";
}
//__________________________________________/auditors/:id________________________________________
else{
	require_once "./queries/auditors/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
