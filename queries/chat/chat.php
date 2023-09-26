<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/chat/list___________________________________________
if($wch=='list'){
	require_once "./queries/chat/list.php";
}
//__________________________________________/chat/teachers_______________________________________
else if($wch=='admin'){
	require_once "./queries/chat/admin.php";
}
//__________________________________________/chat/comment________________________________________
else{
	require_once "./queries/chat/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
