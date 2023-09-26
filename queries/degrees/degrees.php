<?php
require_once "public.php";
$arr = null;
$cod = 0;
$txt = '';
$msg = '';
//__________________________________________/category/list_______________________________________
if($wch=='list'){
	require_once "./queries/degrees/list.php";
}
//__________________________________________/degrees/create______________________________________
else if($wch=='create'){
	require_once "./queries/degrees/create.php";
}
//__________________________________________/degrees/hightlights__________________________________
else if($wch=='hightlights'){
	require_once "./queries/degrees/hightlights.php";
}
//__________________________________________/degrees/:id________________________________________
else{
	require_once "./queries/degrees/get_id.php";
}
//__________________________________________END__________________________________________________
require_once "echoJson.php";
?>
