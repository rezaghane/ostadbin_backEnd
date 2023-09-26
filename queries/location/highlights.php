<?php
$sort = '';
$wher = '';
//***************************** SQL *******************************************
$sql = "SELECT CONCAT(province.id ,',', county.id) AS id, CONCAT(province.name ,' ، ', county.name) AS name FROM teachers
INNER JOIN county ON teachers.county=county.id
INNER JOIN province ON province.id=teachers.province
GROUP BY province.id, county.id";
$db->query($sql);
$data = $db->resultSet();
if(sizeof($data)>0){
	$arr = $data;
  $cod = 200;
  $txt = 'OK';
}else{
  // تایید نشده
  $cod = 400;
  $txt = 'Bad Request';
  $msg = "data not found";
}
?>
