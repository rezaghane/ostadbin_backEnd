<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/category/list_______________________________________
if($wch=='list'){
	require_once "./queries/category/list.php";
}
//__________________________________________/category/create______________________________________
else if($wch=='create'){
	require_once "./queries/category/create.php";
}
//__________________________________________/category/:id________________________________________
else{
	require_once "./queries/category/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
