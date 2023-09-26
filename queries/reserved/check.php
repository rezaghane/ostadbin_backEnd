<?php
$DAT = false;

$sql = "SELECT date_class FROM reserved WHERE id=:id";
$db->query($sql);
$db->bind(":id", $mod);
$data = $db->resultSet();
if(sizeof($data)>0){
  if($data[0]->date_class >= jdate("Y/n/d")){
    $DAT = true;
  }
}

// $db->bind(":date", jdate("Y/n/d"));

$arr = $DAT;
$cod = 200;
$txt = 'OK';
?>
