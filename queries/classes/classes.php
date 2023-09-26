<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/classes/list_______________________________________
if($wch=='list'){
	require_once "./queries/classes/list.php";
}
//__________________________________________/classes/create______________________________________
else if($wch=='create'){
	require_once "./queries/classes/create.php";
}
//__________________________________________/classes/:id_________________________________________
else {
	require_once "./queries/classes/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
