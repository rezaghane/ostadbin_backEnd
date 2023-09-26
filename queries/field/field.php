<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/field/list_______________________________________
if($wch=='list'){
	require_once "./queries/field/list.php";
}
//__________________________________________/field/create______________________________________
else if($wch=='create'){
	require_once "./queries/field/create.php";
}
//__________________________________________/field/:id________________________________________
else{
	require_once "./queries/field/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
