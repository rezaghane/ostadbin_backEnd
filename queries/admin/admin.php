<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/admin/list_______________________________________
if($wch=='list'){
	require_once "./queries/admin/list.php";
}
//__________________________________________/admin/create______________________________________
else if($wch=='create'){
	require_once "./queries/admin/create.php";
}
//__________________________________________/admin/:id________________________________________
else{
	require_once "./queries/admin/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
