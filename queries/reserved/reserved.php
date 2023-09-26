<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/category/list_______________________________________
if($wch=='address'){
	require_once "./queries/reserved/address.php";
}else if($wch=='check'){
	require_once "./queries/reserved/check.php";
}else if($wch=='teachers'){
	require_once "./queries/reserved/teachers.php";
}else if($wch=='list'){
	require_once "./queries/reserved/list.php";
}else if($wch=='setStatus'){
	require_once "./queries/reserved/setStatus.php";
}else if($wch=='link'){
	require_once "./queries/reserved/link.php";
}else if($wch=='grade'){
	require_once "./queries/reserved/grade.php";
}else if($wch=='create'){
	require_once "./queries/reserved/create.php";
}else{
	require_once "./queries/reserved/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
