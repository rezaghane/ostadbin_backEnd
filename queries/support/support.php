<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/support/list_______________________________________
if($wch=='list'){
	require_once "./queries/support/list.php";
}
//__________________________________________/support/read______________________________________
else if($wch=='read'){
	require_once "./queries/support/read.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
