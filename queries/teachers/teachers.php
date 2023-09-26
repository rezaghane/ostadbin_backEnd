<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';

//__________________________________________/teachers/reserved________________________________________
if($wch=='reserved'){
	require_once "./queries/teachers/reserved.php";
}
//__________________________________________/teachers/proposal________________________________________
else if($wch=='proposal'){
	require_once "./queries/teachers/proposal.php";
}
//__________________________________________/teachers/:id____________________________________________
else{
	require_once "./queries/teachers/get_id.php";
}
//__________________________________________END______________________________________________________
require_once "echoJson.php";
?>
