<?php
if($cod>=200 && $cod<=299){
	$D = [
		'ok' => true,
		'status' => [ "code" => $cod, "text"=> $txt ],
		'data' => $arr,
		"message" => $msg,
	];
}else{
	$D = [
		"ok" => false,
		"status" => [ "code" => $cod, "text" => $txt ],
		"message" => $msg,
		"payload" => []
	];
}
echo json_encode($D, JSON_UNESCAPED_UNICODE);

?>
