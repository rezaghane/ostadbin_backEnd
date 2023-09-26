<?php
//***************************** SQL *******************************************
$sql = "SELECT * FROM province";
$db->query($sql);
$data = $db->resultSet();
if(sizeof($data)>0){
	$DATA = array();
	for($i=0; $i<sizeof($data); $i++){
		$sql = "SELECT id, name FROM county WHERE province_id=".$data[$i]->id;
		$db->query($sql);
		$county = $db->resultSet();

		$D = [
			"id"=> $data[$i]->id,
			"name"=> $data[$i]->name,
			"county"=> $county,
		];
		array_push($DATA,$D);
	}
	$arr = $DATA;
  $cod = 200;
  $txt = 'OK';
}else{
  // تایید نشده
  $cod = 400;
  $txt = 'Bad Request';
  $msg = "data not found";
}
?>
