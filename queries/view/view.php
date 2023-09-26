<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/view/teachers_______________________________________
if($wch=='teachers'){
	require_once "./queries/view/teachers.php";
}
//__________________________________________/view/users__________________________________________
else if($wch=='users'){
	require_once "./queries/view/users.php";
}
//__________________________________________/view/comment________________________________________
else if($wch=='comment'){
	require_once "./queries/view/comment.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
