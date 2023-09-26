<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/discount/list_______________________________________
if($wch=='list'){
	require_once "./queries/discount/list.php";
}
//__________________________________________/discount/create______________________________________
else if($wch=='create'){
	require_once "./queries/discount/create.php";
}
//__________________________________________/discount/check______________________________________
else if($wch=='check'){
	require_once "./queries/discount/check.php";
}
//__________________________________________/discount/:id________________________________________
else{
	require_once "./queries/discount/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
